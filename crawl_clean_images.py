from icrawler.builtin import BingImageCrawler
import os
from PIL import Image
import hashlib

# =========================
# Danh sách ảnh cần cào
# =========================
crawl_data = {
    "dogs": [
        "poodle dog isolated white background studio photo",
        "golden retriever puppy isolated white background",
        "husky dog isolated white background",
        "corgi dog isolated white background"
    ],
    "cats": [
        "british shorthair cat isolated white background",
        "persian cat isolated white background studio photo",
        "ragdoll cat isolated white background"
    ],
    "rabbits": [
        "cute rabbit isolated white background studio photo",
        "mini rabbit pet isolated white background"
    ],
    "hamsters": [
        "hamster pet isolated white background studio photo",
        "syrian hamster isolated white background"
    ],
    "birds": [
        "parrot pet isolated white background studio photo",
        "budgie bird isolated white background"
    ],
    "fish": [
        "betta fish isolated white background",
        "goldfish isolated white background"
    ]
}


# =========================
# Hàm kiểm tra ảnh có bị lỗi không
# =========================
def is_valid_image(image_path):
    try:
        with Image.open(image_path) as img:
            width, height = img.size

            if width < 300 or height < 300:
                return False

            img.verify()
            return True

    except Exception:
        return False


# =========================
# Hàm tạo hash để xóa ảnh trùng
# =========================
def get_file_hash(image_path):
    with open(image_path, "rb") as f:
        return hashlib.md5(f.read()).hexdigest()


# =========================
# Hàm lọc ảnh lỗi, ảnh nhỏ, ảnh trùng
# =========================
def clean_images(folder_path):
    seen_hashes = set()

    for file_name in os.listdir(folder_path):
        file_path = os.path.join(folder_path, file_name)

        if not file_name.lower().endswith((".jpg", ".jpeg", ".png", ".webp")):
            os.remove(file_path)
            continue

        if not is_valid_image(file_path):
            print("Xóa ảnh lỗi hoặc quá nhỏ:", file_name)
            os.remove(file_path)
            continue

        file_hash = get_file_hash(file_path)

        if file_hash in seen_hashes:
            print("Xóa ảnh trùng:", file_name)
            os.remove(file_path)
            continue

        seen_hashes.add(file_hash)


# =========================
# Cào ảnh
# =========================
for folder, keywords in crawl_data.items():
    save_dir = f"assets/images/{folder}"
    os.makedirs(save_dir, exist_ok=True)

    for keyword in keywords:
        print("-----------------------------------")
        print("Đang cào:", keyword)

        crawler = BingImageCrawler(
            downloader_threads=2,
            storage={
                "root_dir": save_dir
            }
        )

        crawler.crawl(
            keyword=keyword,
            max_num=25,
            min_size=(300, 300),
            file_idx_offset="auto"
        )

    print("Đang lọc ảnh trong thư mục:", save_dir)
    clean_images(save_dir)

print("Hoàn tất cào và lọc ảnh.")