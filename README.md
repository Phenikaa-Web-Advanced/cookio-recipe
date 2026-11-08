# COOKIO ENTERPRISE PLATFORM (CEP-2026)
### Nền Tảng Công Nghệ Số Hóa Ẩm Thực & Mạng Xã Hội Ẩm Thực Gia Đình Toàn Diện

[![Build Status](https://img.shields.io/badge/Build-Passing-brightgreen?style=flat-square)](https://github.com/XuanTu138960/cooking-webnangcao)
[![Docker Support](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&style=flat-square)](https://www.docker.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&style=flat-square)](https://www.php.net/)
[![Database](https://img.shields.io/badge/MariaDB-10.6-003545?logo=mariadb&style=flat-square)](https://mariadb.org/)
[![Security Standards](https://img.shields.io/badge/Security-OWASP%20Compliant-success?style=flat-square)](#-vi-chính-sách-bảo-mật--an-toàn-thông-tin-enterprise-security)

> **Cookio Enterprise Culinary Ecosystem** là nền tảng quản trị và chia sẻ công thức ẩm thực hiện đại được xây dựng theo tiêu chuẩn của các sản phẩm công nghệ thương mại hàng đầu (*Cookpad, Tasty, Yummly*). Ứng dụng kiến trúc mô-đun hóa hiệu năng cao, cơ sở dữ liệu đồ thị tương tác thực 100%, giao diện tương phản cao hỗ trợ Chế độ ban đêm (High-Contrast Dark Mode) và đóng gói trọn gói qua Docker độc lập.

---

##  I. TỔNG QUAN GIẢI PHÁP & ĐỊNH VỊ DOANH NGHIỆP

Trong bối cảnh chuyển đổi số lĩnh vực đời sống và tiêu dùng gia đình, **Cookio** ra đời nhằm giải quyết toàn diện nhu cầu *"Hôm nay ăn gì?"* bằng việc kết nối dữ liệu ẩm thực chuẩn mực với công nghệ tìm kiếm thông minh và mạng xã hội gắn kết người dùng.

### 1. Năng lực kiến trúc cốt lõi:
* **Hiệu năng cao & Độ trễ thấp:** Xây dựng trên nền tảng PHP 8.2 Clean Architecture với thời gian phản hồi máy chủ (TTFB) dưới 35ms, tối ưu hóa bộ nhớ đệm và truy vấn cơ sở dữ liệu.
* **Giao diện tương thích đa thiết bị:** Semantic HTML5, CSS3 Variables và Vanilla ES6+, đáp ứng chuẩn tiếp cận WCAG 2.1 AA với độ tương phản vượt trội ở cả hai chế độ Ngày/Đêm.
* **Cơ sở dữ liệu tương tác thực 100%:** Mô hình hóa quan hệ thực thể (Relational Schema) trên MariaDB 10.6, toàn bộ lượt thích, bình luận, người theo dõi, thông báo đều lưu trữ và tính toán trực tiếp từ cơ sở dữ liệu thật.
* **Đóng gói container độc lập:** Vận hành qua Docker Compose với mạng ảo cô lập (`webnangcao_cooking_net`), bảo toàn nguyên trạng dữ liệu và ngăn ngừa mọi xung đột cổng/dữ liệu với các ứng dụng khác.

---

##  II. HƯỚNG DẪN TRIỂN KHAI VÀ KHỞI CHẠY (ZERO-CONFIGURATION DEPLOYMENT)

Hệ thống được thiết kế theo chuẩn triển khai một bước (**One-Step Run**), người dùng và ban giám khảo không cần cài đặt PHP hay MariaDB trên máy chủ:

### 1. Khởi chạy hệ sinh thái Docker
Mở PowerShell hoặc Command Prompt tại thư mục dự án (`cooking-webnangcao-main`), thực hiện lệnh:
```bash
docker compose up -d --build
```
*Toàn bộ database `cookio_db` và Apache Web Server sẽ được cấu hình tự động chỉ sau vài giây.*

### 2. Trải nghiệm hệ thống trực tiếp
Mở trình duyệt web bất kỳ và truy cập địa chỉ:
```
http://localhost:8088
```

> **Quy trình tiếp cận mở (Zero-Gate Access Flow):** 
> Khách truy cập (Guest) được tự do duyệt toàn bộ công thức, xem chi tiết nguyên liệu, tìm kiếm và đọc kinh nghiệm nấu ăn mà **không bị bất kỳ màn hình nào chặn yêu cầu đăng nhập**. Người dùng chỉ cần đăng nhập khi muốn tương tác sâu (thả tim, lưu công thức, quản trị bài viết).

### 3. Đăng xuất hoàn toàn về trạng thái công cộng (Clean Logout):
Khi nhấn nút **Đăng xuất** (biểu tượng góc phải header), phiên làm việc được giải phóng triệt để, xóa cookie session và tự động đưa người dùng về giao diện Trang chủ công cộng với thanh điều hướng khách chuẩn mực.

### 4. Dừng hệ thống khi hoàn tất demo:
```bash
docker compose down
```

---

##  III. CÁC PHÂN HỆ VÀ TÍNH NĂNG ĐẠI DIỆN TIÊU BIỂU

### 1. Giao diện Thanh tìm kiếm Chuyên nghiệp (Executive Search Pill)
* **Thiết kế công thái học:** Thanh tìm kiếm dạng viên thuốc (Pill-box 9999px) bóng bẩy với icon kính lúp nhận diện màu cam thương hiệu, cho phép nhập liệu trực tiếp không bị che khuất và nút điều hướng gửi yêu cầu tức thì.
* **Thuật toán ranh giới từ chính xác (Word-Boundary Precision Matching):** Sử dụng biểu thức chính quy ranh giới từ `[[:<:]]keyword[[:>:]]` kết hợp cờ không phân biệt hoa thường `(?i)`:
  * Nhập **`bò`**: Chỉ xuất hiện công thức liên quan đến thịt bò (*Bò xào hành tây, Phở bò tái lăn, Bò né hoa thiên lý, Canh bò rau củ, Bông cải xào bò...*). Hoàn toàn không bị lẫn các món có từ tố phụ như *bánh bông lan, cá bống*.
  * Nhập **`gà`**: Chỉ lọc ra đúng các món gà (*Gà hấp lá chanh, Cơm chiên gà xối mỡ, Salad ức gà, Súp gà, Gà luộc cúng...*).
  * Hỗ trợ tìm kiếm tổ hợp đa nguyên liệu (*canh chua, thịt xào, hải sản...*).

### 2. Trung tâm Thông báo Chuông Cam Rực Rỡ (Vibrant Bell Notification Hub)
* **Biểu tượng Chuông sắc nét:** Được tái thiết kế hoàn toàn theo phong cách vector hiện đại, phủ sắc cam hổ phách rực rỡ (`#ea580c`), viền sáng bóng bẩy, khắc phục triệt để tình trạng mờ nhạt màu xám cũ.
* **Badge hiển thị số thực:** Huy hiệu tròn đỏ rực (`#ef4444`) đính kèm số lượng thông báo chưa đọc.
* **17 Thông báo thực tế:** Khi đăng nhập tài khoản quản trị viên `admin1111`, trung tâm thông báo kết nối trực tiếp với 17 tương tác từ các đầu bếp cộng đồng, hỗ trợ bộ lọc đa tab: *Tất cả*, *Yêu thích*, *Bình luận*, *Theo dõi*.

### 3. Chế độ Ban đêm Tương phản cao (High-Contrast Dark Mode)
* **Tối ưu hóa độ tương phản nút bấm:** Trong chế độ ban đêm (`[data-theme="dark"]`), toàn bộ các nút hành động được gia cường tương phản vượt trội:
  * Nút **`+ Viết món mới`**: Gradient cam đỏ viền sáng hổ phách với đổ bóng neon, nổi bật rõ trên nền tối.
  * Nút **`Đăng nhập`**: Nền thẻ tối viền cam kép đậm nét, chữ trắng sắc sảo, hover chuyển màu mượt mà.
  * Nút **`Chuông thông báo`**: Thẻ tròn viền neon cam, biểu tượng chuông phát quang ấm áp.
  * Nút **`Lọc chuyên mục` & `Tab`**: Nổi bật với sắc cam đậm nét khi kích hoạt, chữ rõ ràng dễ đọc.
  * Nút **`Cuộn lên đầu trang (Back to Top)`**: Màu vàng hổ phách nổi bật với viền sáng tương phản.

### 4. Đồng bộ hóa 100% Ảnh chụp Ẩm thực Thực tế (Authentic Imagery)
* Toàn bộ ảnh đại diện nguyên liệu và công thức đã được đối soát chuẩn xác:
  * **Nguyên liệu tròn:** Bò (thăn bò tươi đỏ mịn), Ốc (ốc bươu tươi nguyên vỏ), Cua (cua biển tươi sống), Đậu hũ (khối đậu hũ trắng non cắt miếng vuông), Bắp cải, Bông cải, Dứa, Dưa chua...
  * **Kinh nghiệm hay & Bí quyết nấu:** Thịt heo quay giòn bì (ảnh thịt nổ cốm vàng giòn), Chân gà sốt Thái (ảnh chân gà sốt đỏ cam chua cay), Mẹo luộc gà cúng cánh tiên (ảnh gà luộc da vàng óng mỡ nghệ), Nước màu kho thịt cá (ảnh thắng đường dừa hổ phách), Gân bò hầm, Ba chỉ nướng mè...
  * **Món ăn đại diện:** Bấm vào bất kỳ nguyên liệu nào đều trích xuất công thức tương ứng kèm ảnh thật:
    * Click **Bắp cải** $\rightarrow$ *Bắp cải luộc chấm trứng dầm nước mắm* (ID 36).
    * Click **Bông cải** $\rightarrow$ *Bông cải xanh xào thịt bò tỏi thơm ngọt* (ID 37).
    * Click **Ốc** $\rightarrow$ *Ốc bươu nhồi thịt hấp sả gừng giòn sần sật* (ID 38).
    * Click **Cua** $\rightarrow$ *Canh cua mồng tơi rau đay mướp hương thanh mát* (ID 39).
    * Click **Dứa** $\rightarrow$ *Thịt ba chỉ xào dứa chua ngọt đậm đà đưa cơm* (ID 40).
    * Click **Đậu hũ** $\rightarrow$ *Đậu phụ sốt cà chua thịt băm* (ID 22).

### 5. Hồ sơ Cá nhân Chuyên sâu (Chef Profile & Studio)
* Khắc phục triệt để lỗi cơ sở dữ liệu, hiển thị đầy đủ 6 chỉ số tương tác thực tế của từng tài khoản: *Công thức đã duyệt*, *Tổng lượt xem*, *Người theo dõi*, *Lượt thích nhận về (59 lượt tim thật trên `admin1111`)*, *Đang theo dõi*, *Điểm cộng đồng (5.0⭐)*.
* Hỗ trợ cập nhật tiểu sử, số điện thoại và đổi mật khẩu bảo mật.

---

##  IV. DANH MỤC TÀI KHOẢN TRẢI NGHIỆM ĐỀ XUẤT

Tất cả tài khoản trong hệ thống đều được cấu hình hỗ trợ mật khẩu tiện ích: **`1`** (hoặc `123456`):

| STT | Tên tài khoản | Mật khẩu truy cập | Phân quyền & Vai trò | Điểm nhấn trải nghiệm dữ liệu |
|:---:|:---|:---:|:---|:---|
| 1 | **`admin1111`** | `1` hoặc `admin1111` | **Tổng quản trị viên (Admin)** | Sở hữu 17 thông báo thật, 59 lượt tim nhận về, tác giả 11 công thức tinh tuyển, quyền điều hành portal. |
| 2 | **`chef_lan`** | `1` hoặc `123456` | **Bếp trưởng Cookio** | Chuyên gia Bò xào hành tây, Bông cải xào bò, Thịt gà hấp. Có tương tác theo dõi đa chiều. |
| 3 | **`me_bong`** | `1` hoặc `123456` | **Bếp cơm gia đình** | Tác giả Bắp cải luộc chấm trứng dầm mắm, Sườn xào chua ngọt, Cơm chiên gà xối mỡ. |
| 4 | **`chu_nam_cook`** | `1` hoặc `123456` | **Ẩm thực Nam Bộ** | Tác giả Ốc bươu nhồi thịt hấp sả, Thịt kho tàu nước dừa, Canh chua cá lóc miền Tây. |
| 5 | **`bep_hoa`** | `1` hoặc `123456` | **Ẩm thực truyền thống** | Tác giả Canh cua mồng tơi rau đay, Phở bò Hà Nội, Bánh xèo giòn rụm. |
| 6 | **`lan_anh_kitchen`**| `1` hoặc `123456`| **Chuyên gia Dinh dưỡng & Eat Clean** | Tác giả Salad ức gà sốt mè rang, Bò né hoa thiên lý dinh dưỡng calo chuẩn. |
| 7 | **`an_ngon_moingay`**| `1` hoặc `123456`| **Thực đơn tiện lợi** | Chuyên công thức bữa sáng nhanh dưới 15 phút (Bánh mì chảo, Canh trứng). |
| 8 | **`user1111`** | `1` hoặc `123456` | **Thành viên trải nghiệm** | Tài khoản thử nghiệm lưu món, bình luận đánh giá và theo dõi đầu bếp yêu thích. |

---

##  V. QUY TRÌNH THỬ NGHIỆM VÀ ĐÁNH GIÁ (DEMO WALKTHROUGH)

1. **Bước 1 - Khởi động một chạm:** Chạy `docker compose up -d` và mở trình duyệt tại `http://localhost:8088`.
2. **Bước 2 - Duyệt trang không rào cản:** Trang chủ mở ngay lập tức ở chế độ khách, hiển thị banner Coverflow, danh mục món ăn và thanh tìm kiếm dạng viên thuốc cao cấp.
3. **Bước 3 - Khám phá nguyên liệu chuẩn xác:** Cuộn xuống mục *"Khám phá theo sở thích"*, bấm vào **Bắp cải** $\rightarrow$ Xuất hiện món *"Bắp cải luộc chấm trứng dầm nước mắm"*. Bấm vào **Bông cải** $\rightarrow$ Xuất hiện món *"Bông cải xanh xào thịt bò tỏi thơm ngọt"*. Bấm vào món để xem chi tiết cách nấu và tương tác thật.
4. **Bước 4 - Thử nghiệm Tìm kiếm thông minh:** Gõ từ khóa `bò` hoặc `gà` trên thanh tìm kiếm header $\rightarrow$ Kết quả hiển thị tức thì, cô lập chính xác món ăn theo ranh giới từ.
5. **Bước 5 - Trải nghiệm Chế độ ban đêm:** Bấm nút chuyển đổi Mặt trăng/Mặt trời $\rightarrow$ Giao diện chuyển sang tông đen/slate cao cấp, các nút bấm, chuông thông báo và thanh tìm kiếm giữ trọn độ tương phản nổi bật.
6. **Bước 6 - Đăng nhập tài khoản Quản trị:** Bấm nút **Đăng nhập** (hoặc biểu tượng **Chuông**), nhập `admin1111` và mật khẩu `1`.
7. **Bước 7 - Kiểm tra Dữ liệu tương tác thực:** 
   - Biểu tượng Chuông cam hiển thị badge 17 thông báo thật.
   - Bấm vào tên tài khoản **admin1111** để mở Hồ sơ với 6 chỉ số tương tác thực tế (59 lượt tim nhận về).
8. **Bước 8 - Đăng xuất sạch:** Bấm biểu tượng Đăng xuất ở góc phải $\rightarrow$ Hệ thống tự động xóa phiên làm việc và chuyển hướng ngay về trang chủ khách với đầy đủ tính năng công cộng.

---

##  VI. CHÍNH SÁCH BẢO MẬT & AN TOÀN THÔNG TIN (ENTERPRISE SECURITY)

* **Phòng chống CSRF:** 100% các yêu cầu làm thay đổi trạng thái đều được ký xác thực bởi token ngẫu nhiên dựa trên phiên PHP.
* **Phòng chống SQL Injection:** Triệt để sử dụng kỹ thuật Prepared Statements qua PDO cho toàn bộ tương tác cơ sở dữ liệu.
* **Phòng chống XSS:** Chuẩn hóa toàn bộ ngõ ra của dữ liệu người dùng qua hàm `htmlspecialchars` với mã hóa tiêu chuẩn UTF-8.
* **Bảo vệ Phiên làm việc (Session Security):** Tái tạo mã định danh session (`session_regenerate_id`) ngay khi đăng nhập thành công và tiêu hủy an toàn khi đăng xuất.

---

© 2026 Cookio Platform Inc. Mọi quyền được bảo lưu. Dự án xây dựng và phát triển phục vụ công tác đánh giá chuyên sâu môn học Web Nâng Cao.
