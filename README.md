# PetShop
🐾 PetShop Web Application
Dự án này là một ứng dụng web quản lý cửa hàng thú cưng, được phát triển bằng ngôn ngữ PHP theo mô hình lập trình Hướng đối tượng (OOP). Website cung cấp đầy đủ các tính năng từ quản lý sản phẩm, giỏ hàng đến hệ thống xác thực người dùng và phân quyền quản trị.

🚀 Tính năng nổi bật
-Xác thực bảo mật: Đăng ký và đăng nhập với mật khẩu được mã hóa (bcrypt).

-Phân quyền (RBAC): Tách biệt hoàn toàn giao diện và chức năng giữa ADMIN và CUSTOMER.

-Quản lý sản phẩm: Hiển thị danh sách sản phẩm động từ Database với giao diện lưới (Grid) hiện đại.

-Giỏ hàng & Thanh toán: Quy trình mua hàng khép kín từ thêm sản phẩm đến thanh toán đơn hàng.

-Giao diện Responsive: Tương thích hoàn hảo trên mọi thiết bị (Mobile, Tablet, Desktop) nhờ CSS Grid & Flexbox.

/PetShop
/assets/css/styles.css   # File định dạng giao diện chính (Custom CSS)

/auth                    # Xử lý Login, Register, Logout

/classes                 # Các lớp đối tượng OOP (Database.php, User.php)

/includes                # Thành phần dùng chung (Header, Footer, Helpers)

 /config/db.php            # Cấu hình kết nối MySQL (mysqli & PDO)
 
 /index.php                # Trang chủ ứng dụng
 
 /products.php             # Danh mục sản phẩm
 
  👥 Phân công nhiệm vụ (Project Members)
  Dự án được thực hiện với sự phối hợp chặt chẽ giữa các thành viên:
  Member 1: Database + Auth
  -Thiết kế CSDL, xử lý lớp Database.php, User.php, chức năng Login/Logout/Register và phân quyền Admin.

  Member 2: Logic nghiệp vụ
  -Xử lý logic giỏ hàng (cart.php), tính toán đơn hàng và quy trình thanh toán (checkout.php).

  Member 3:Frontend Development
  -Thiết kế giao diện trang chủ, danh sách sản phẩm và đảm bảo tính Responsive cho website.

  Member 4: Admin Dashboard
  -Xử lý các chức năng quản trị: Quản lý kho hàng (Thêm/Sửa/Xóa sản phẩm) và quản lý người dùng.

  🛠 Công nghệ sử dụng
Ngôn ngữ: PHP 7.4+.
Cơ sở dữ liệu: MySQL (Sử dụng PDO để chống SQL Injection).

Giao diện: HTML5, CSS3 (Sử dụng CSS Variables & Glassmorphism).

Quản lý phiên: PHP Session Management.

💻 Hướng dẫn cài đặt
1. Chuẩn bị môi trường: Sử dụng XAMPP, WAMP hoặc Laragon (Hỗ trợ PHP 7.4 trở lên).
2. Clone dự án: git clone https://github.com/username/PetShop.git
3. Cấu hình Database:
   -Tạo cơ sở dữ liệu petshop_db.
   -Cập nhật thông tin truy cập (host, user, pass) trong file /classes/Database.php.
4. Chạy ứng dụng:
   -Di chuyển thư mục dự án vào htdocs.
   -Truy cập đường dẫn: http://localhost/PetShop/.
