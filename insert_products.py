import mysql.connector
import os
import random
import re
import unicodedata

MAX_INSERT = 100
inserted_count = 0
# =========================
# 1. Kết nối database
# =========================
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="petshop_db"
)

cursor = conn.cursor()
print("Kết nối database thành công!")

# Đếm số sản phẩm trước khi insert
cursor.execute("SELECT COUNT(*) FROM products")
before_count = cursor.fetchone()[0]
print("Số sản phẩm trước khi chạy:", before_count)


# =========================
# 2. Hàm xử lý slug
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
# 3. Dữ liệu sản phẩm theo folder ảnh
# Lưu ý: category_id phải khớp với bảng categories
# =========================
products_data = {
    "dog_food": {
        "category_id": 3,
        "is_pet": 0,
        "names": [
            "Thức ăn cho chó Poodle",
            "Hạt dinh dưỡng cho chó",
            "Pate cho chó",
            "Bánh thưởng cho chó"
        ],
        "price_range": (50000, 500000),
        "description": "Sản phẩm thức ăn dành cho thú cưng, phù hợp sử dụng hằng ngày."
    },

    "cat_litter": {
        "category_id": 3,
        "is_pet": 0,
        "names": [
            "Cát vệ sinh cho mèo",
            "Cát mèo khử mùi",
            "Cát vệ sinh vón cục",
            "Cát mèo hương tự nhiên"
        ],
        "price_range": (80000, 300000),
        "description": "Cát vệ sinh cho mèo, hỗ trợ khử mùi và giữ không gian sạch sẽ."
    },

    "fish_food": {
        "category_id": 3,
        "is_pet": 0,
        "names": [
            "Thức ăn cho cá cảnh",
            "Cám cá Betta",
            "Thức ăn cá vàng",
            "Thức ăn cá Koi mini"
        ],
        "price_range": (30000, 200000),
        "description": "Thức ăn dành cho cá cảnh, hỗ trợ cá phát triển khỏe mạnh."
    },

    "bird_food": {
        "category_id": 3,
        "is_pet": 0,
        "names": [
            "Thức ăn cho chim cảnh",
            "Hạt dinh dưỡng cho vẹt",
            "Thức ăn cho chim yến phụng",
            "Hạt tổng hợp cho chim"
        ],
        "price_range": (40000, 250000),
        "description": "Thức ăn dành cho chim cảnh, bổ sung dinh dưỡng hằng ngày."
    },

    "geckos": {
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Tắc Kè Cảnh",
            "Leopard Gecko",
            "Gecko Mini",
            "Tắc Kè Đốm"
        ],
        "price_range": (300000, 2000000),
        "description": "Bò sát cảnh độc đáo, phù hợp với người yêu thú cưng lạ."
    },

    "goldfish": {
        "category_id": 1,
        "is_pet": 1,
        "names": [
            "Cá Vàng",
            "Cá Vàng Đuôi Quạt",
            "Cá Vàng Ranchu",
            "Cá Vàng Mini"
        ],
        "price_range": (30000, 500000),
        "description": "Cá cảnh đẹp, phù hợp nuôi trong bể cá gia đình."
    },

    "rabbit_food": {
        "category_id": 3,
        "is_pet": 0,
        "names": [
            "Thức ăn cho thỏ",
            "Cỏ khô Timothy",
            "Viên nén dinh dưỡng cho thỏ",
            "Hạt tổng hợp cho thỏ"
        ],
        "price_range": (50000, 300000),
        "description": "Thức ăn dành cho thỏ cảnh, hỗ trợ tiêu hóa và phát triển khỏe mạnh."
    }
}


# =========================
# 4. Hàm kiểm tra ảnh hợp lệ
# =========================
def is_image_file(file_name):
    return file_name.lower().endswith((".jpg", ".jpeg", ".png", ".webp"))


# =========================
# 5. Hàm insert sản phẩm
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
for folder, data in products_data.items():
    folder_path = f"assets/images/{folder}"

    print("------------------------------------")
    print(f"Đang xử lý thư mục: {folder_path}")

    if not os.path.exists(folder_path):
        print(f"Không tìm thấy thư mục: {folder_path}")
        continue

    image_files = [
        file for file in os.listdir(folder_path)
        if is_image_file(file)
    ]

    if len(image_files) == 0:
        print(f"Không có ảnh hợp lệ trong thư mục: {folder_path}")
        continue

    for image_file in image_files:
        if inserted_count >= MAX_INSERT:
            break

        image_url = f"{folder}/{image_file}"

        # Kiểm tra ảnh này đã có trong database chưa
        cursor.execute(
            "SELECT COUNT(*) FROM products WHERE image_url = %s",
            (image_url,)
        )
        exists = cursor.fetchone()[0]

        if exists > 0:
            print(f"Bỏ qua ảnh đã tồn tại: {image_url}")
            continue

        product_name = random.choice(data["names"])

        price_new = random.randint(
            data["price_range"][0],
            data["price_range"][1]
        )

        price_old = price_new + random.randint(50000, 500000)
        stock_quantity = random.randint(3, 20)

        description = data["description"]

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

        inserted_count += 1

    if inserted_count >= MAX_INSERT:
        break
# =========================
# 7. Kiểm tra số sản phẩm sau khi insert
# =========================
cursor.execute("SELECT COUNT(*) FROM products")
after_count = cursor.fetchone()[0]

print("------------------------------------")
print("Số sản phẩm sau khi chạy:", after_count)
print("Đã thêm mới:", after_count - before_count)

cursor.close()
conn.close()

print("Hoàn tất insert sản phẩm vào database.")