HƯỚNG DẪN CÀI ĐẶT WEBSITE MUA BÁN ĐỒ GỐM CŨ

1. Yêu cầu hệ thống
   
• Windows 10/11

• XAMPP (Apache, MySQL, PHP)

• Trình duyệt web (Chrome, Edge hoặc Firefox)

4. Cài đặt XAMPP
   
Bước 1: Tải và cài đặt XAMPP.

Bước 2: Mở XAMPP Control Panel.

Bước 3: Khởi động Apache và MySQL.

7. Sao chép mã nguồn
   
Giải nén thư mục dự án và chép thư mục source vào:

C:\xampp\htdocs\gom_cu

10. Tạo cơ sở dữ liệu
    
Bước 1: Truy cập http://localhost/phpmyadmin

Bước 2: Tạo cơ sở dữ liệu gom_shop.

Bước 3: Chọn Import.

Bước 4: Chọn file gom_shop.sql trong thư mục setup.

Bước 5: Nhấn Go để nhập dữ liệu.

13. Cấu hình kết nối
    
Kiểm tra file config.php:

$host='localhost';

$user='root';

$password='';

$db='gom_shop';

16. Chạy hệ thống
    
Mở trình duyệt và truy cập:

http://localhost/gom_cu

Hoặc thư mục source tương ứng của dự án.

19. Tài khoản mặc định
    
Đăng nhập bằng tài khoản đã có trong cơ sở dữ liệu hoặc tạo tài khoản mới.

22. Xử lý lỗi thường gặp
    
Apache không chạy: kiểm tra cổng 80.

MySQL không chạy: kiểm tra cổng 3306.

Lỗi kết nối CSDL: kiểm tra thông tin trong config.php.
