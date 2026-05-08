from icrawler.builtin import BingImageCrawler
import mysql.connector
import os
import random
import re
import unicodedata

# =========================
# 1. Kết nối database MySQL
# =========================
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="petshop_db"
)

cursor = conn.cursor()
print("Kết nối database thành công!")

# Kiểm tra số sản phẩm trước khi chạy
cursor.execute("SELECT COUNT(*) FROM products")
before_count = cursor.fetchone()[0]
print("Số sản phẩm trước khi chạy:", before_count)


# =========================
# 2. Hàm tạo slug
# =========================
def remove_vietnamese_accents(text):
    text = unicodedata.normalize("NFD", text)
    text = text.encode("ascii", "ignore").decode("utf-8")
    return text


def create_slug(text):
    text = remove_vietnamese_accents(text)
    text = text.lower()
    text = re.sub(r"[^a-z0-9\s-]", "", text)
    text = re.sub(r"\s+", "-", text)
    text = re.sub(r"-+", "-", text)
    return text.strip("-")


# =========================
# 3. Dữ liệu muốn cào
# Lưu ý: category_id phải tồn tại trong bảng categories
# =========================
products_data = {
    "dogs": {
        "keyword": "poodle dog isolated white background product photo",
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Chó Poodle",
            "Chó Husky",
            "Chó Golden Retriever",
            "Chó Corgi",
            "Chó Shiba Inu"
        ],
        "price_range": (500000, 8000000)
    },

    "cats": {
        "keyword": "british shorthair cat isolated white background pet photo",
        "category_id": 2,
        "is_pet": 1,
        "names": [
            "Mèo Anh Lông Ngắn",
            "Mèo Ba Tư",
            "Mèo Munchkin",
            "Mèo Ragdoll",
            "Mèo Scottish Fold"
        ],
        "price_range": (400000, 7000000)
    },

    "rabbits": {
        "keyword": "cute rabbit isolated white background studio photo",
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Thỏ Mini",
            "Thỏ Trắng",
            "Thỏ Tai Cụp",
            "Thỏ Hà Lan"
        ],
        "price_range": (200000, 1500000)
    },

    "hamsters": {
        "keyword": "hamster pet isolated white background studio photo",
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Hamster Winter White",
            "Hamster Bear",
            "Hamster Robo"
        ],
        "price_range": (80000, 500000)
    },

    "birds": {
        "keyword": "parrot pet isolated white background studio photo",
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Vẹt Cảnh",
            "Chim Yến Phụng",
            "Chim Canary"
        ],
        "price_range": (150000, 2000000)
    },

    "fish": {
        "keyword": "betta fish isolated white background aquarium fish",
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Cá Betta",
            "Cá Vàng",
            "Cá Koi Mini"
        ],
        "price_range": (30000, 1000000)
    }
}


# =========================
# 4. Hàm insert vào bảng products
# =========================
def insert_product(product_name, price_old, price_new, stock_quantity, image_url, description, is_pet, slug, category_id):
    try:
        sql = """
            INSERT INTO products 
            (product_name, price_old, price_new, stock_quantity, image_url, description, is_pet, slug, category_id)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        values = (
            product_name,
            price_old,
            price_new,
            stock_quantity,
            image_url,
            description,
            is_pet,
            slug,
            category_id
        )

        cursor.execute(sql, values)
        conn.commit()

        print(f"Đã lưu DB: {product_name} | ảnh: {image_url}")

    except mysql.connector.Error as err:
        print("Lỗi khi insert database:", err)


# =========================
# 5. Cào ảnh + lưu vào database
# =========================
for folder, data in products_data.items():
    save_dir = f"assets/images/{folder}"

    print("------------------------------------")
    print(f"Đang cào ảnh cho thư mục: {folder}")
    print(f"Từ khóa tìm ảnh: {data['keyword']}")

    os.makedirs(save_dir, exist_ok=True)

    crawler = BingImageCrawler(
        downloader_threads=2,
        storage={
            "root_dir": save_dir
        }
    )

    crawler.crawl(
        keyword=data["keyword"],
        max_num=5,
        min_size=(300, 300),
        file_idx_offset="auto"
    )

    image_files = os.listdir(save_dir)

    if len(image_files) == 0:
        print(f"Không có ảnh trong thư mục: {save_dir}")
        continue

    for image_file in image_files:
        if image_file.lower().endswith((".jpg", ".jpeg", ".png", ".webp")):
            product_name = random.choice(data["names"])

            price_new = random.randint(
                data["price_range"][0],
                data["price_range"][1]
            )

            price_old = price_new + random.randint(50000, 500000)
            stock_quantity = random.randint(3, 20)

            # Lưu vào DB theo kiểu: dogs/000001.jpg
            image_url = f"{folder}/{image_file}"

            description = f"{product_name} phù hợp cho cửa hàng thú cưng PetShop."

            slug = create_slug(
                product_name + "-" + str(random.randint(1000, 9999))
            )

            insert_product(
                product_name=product_name,
                price_old=price_old,
                price_new=price_new,
                stock_quantity=stock_quantity,
                image_url=image_url,
                description=description,
                is_pet=data["is_pet"],
                slug=slug,
                category_id=data["category_id"]
            )


# =========================
# 6. Kiểm tra số sản phẩm sau khi chạy
# =========================
cursor.execute("SELECT COUNT(*) FROM products")
after_count = cursor.fetchone()[0]

print("------------------------------------")
print("Số sản phẩm sau khi chạy:", after_count)
print("Đã thêm mới:", after_count - before_count)

cursor.close()
conn.close()

print("Hoàn tất cào ảnh và lưu dữ liệu vào database.")