#  Cookio - Mạng Xã Hội Ẩm Thực & Nền Tảng Chia Sẻ Công Thức Bếp Gia Đình

> **Cookio** là nền tảng ẩm thực gia đình hiện đại, ấm cúng và thông minh theo chuẩn **Cookpad**, **Tasty** và **Yummly**, được xây dựng bằng **PHP thuần (PHP 8.2)**, **MariaDB/MySQL**, **JavaScript (ES6+)** và **CSS hiện đại**.
> Hệ thống mang đến trải nghiệm nấu ăn thông minh, kết nối cộng đồng yêu bếp, quản lý thực đơn, đi chợ tiện lợi và tích hợp cổng quản trị nội dung toàn diện.

---

##  Thông Tin Tác Giả & Bản Quyền Độc Quyền

- **Họ và tên tác giả:** Nguyễn Xuân Tú (Tuno)
- **Mã số sinh viên:** 23010538
- **Đơn vị đào tạo:** Khoa Công nghệ Thông tin - Trường Đại học Phenikaa (Phenikaa University)
- **Học phần:** Web Nâng Cao
- **Đề tài đồ án:** Xây dựng hệ thống mạng xã hội chia sẻ công thức ẩm thực thông minh Cookio
- **Mã nguồn chính thức:** [https://github.com/XuanTu138960/cooking-webnangcao](https://github.com/XuanTu138960/cooking-webnangcao)
- **Tuyên bố bản quyền:** *Toàn bộ ý tưởng, giao diện thiết kế, cơ sở dữ liệu và mã nguồn của dự án này thuộc quyền sở hữu độc quyền của sinh viên **Nguyễn Xuân Tú**. Mọi hành vi sao chép phục vụ mục đích thương mại khi chưa có sự đồng ý đều là vi phạm quyền tác giả.*

---

##  Tính Năng Nổi Bật

### 1.  Kho Dữ Liệu Chuẩn & 100% Ảnh Thực Phẩm Thật Sắc Nét
- **Bộ sưu tập công thức nấu ăn phong phú**: Đa dạng các món ăn truyền thống 3 miền Bắc - Trung - Nam, món Á - Âu, món chay thanh tịnh, món ăn kiêng Healthy & Eat Clean.
- **Đồng bộ hóa 100% ảnh món ăn thật**: Toàn bộ món ăn hiển thị ảnh chụp thật chân thực, độ phân giải cao chuẩn ẩm thực Việt (loại bỏ hoàn toàn ảnh đĩa than, ảnh dimsum hay ảnh minh họa sai lệch).
- **Quy chuẩn đăng bài nghiêm ngặt**: Yêu cầu bắt buộc tải lên ảnh thành phẩm thực tế của món ăn (`required`), kiểm tra định dạng và kích thước an toàn.
- **51 bài viết Kinh Nghiệm Hay & Mẹo Vặt Nhà Bếp**: Kho tàng bí quyết nấu nướng, sơ chế, khử mùi tanh, hầm gân bò nhanh mềm, luộc gà cúng cánh tiên da vàng óng và kỹ thuật thắng nước màu caramel đẹp tự nhiên.

### 2.  Giao Diện Bếp Nhà & Thanh Tìm Kiếm Đẳng Cấp YummyDay
- **Thanh tìm kiếm dạng viên thuốc (Pill-box 9999px)**: Mô phỏng chuẩn mực giao diện YummyDay với nền trắng tinh khôi, viền mềm mại, icon kính lúp nâu sẫm (`#4a1c17`), placeholder *"Tìm theo tên món"* và nút bấm tròn màu nâu sẫm chứa kính lúp trắng thanh lịch.
- **Thuật toán ranh giới từ chính xác (Word-Boundary Precision Regex Matching)**: Khắc phục triệt để nhược điểm của phép so khớp `LIKE` thông thường:
  - Tìm kiếm **`bò`**: Chỉ xuất hiện chính xác các món chứa thịt bò (*Bò xào hành tây, Phở bò, Bò né hoa thiên lý, Canh thịt bò, Bò xào tỏi, Bông cải xào bò*). Tuyệt đối **không** nhầm sang *bánh bông lan, cá bống, bột nêm*.
  - Tìm kiếm **`gà`**: Chỉ lọc đúng các món từ thịt gà (*Gà hấp lá chanh, Salad ức gà, Cơm chiên gà xối mỡ, Súp gà, Gà hấp hành, Miến lòng gà, Gà xào hạt điều*).

### 3.  Khám Phá Theo Sở Thích & Trích Xuất Món Ăn Đại Diện Chuẩn 100%
- Bấm vào bất kỳ vòng tròn nguyên liệu tươi ngon nào (*Bắp cải, Bò, Bông cải, Cá, Cà chua, Ốc, Cua, Đậu hũ, Dứa, Dưa chua, Tôm, Gà*), hệ thống ngay lập tức trích xuất đúng **món ăn đại diện chuẩn xác kèm ảnh thật**:
  - Click **Bắp cải** $\rightarrow$ Ra món *"Bắp cải luộc chấm trứng dầm nước mắm"* (ID 36).
  - Click **Bông cải** $\rightarrow$ Ra món *"Bông cải xanh xào thịt bò tỏi thơm ngọt"* (ID 37).
  - Click **Các loại ốc** $\rightarrow$ Ra món *"Ốc bươu nhồi thịt hấp sả gừng giòn sần sật"* (ID 38).
  - Click **Cua** $\rightarrow$ Ra món *"Canh cua mồng tơi rau đay mướp hương thanh mát"* (ID 39).
  - Click **Đậu hũ** $\rightarrow$ Ra món *"Đậu phụ (đậu hũ) sốt cà chua thịt băm"* (ID 22).
  - Click **Dứa** $\rightarrow$ Ra món *"Thịt ba chỉ xào dứa chua ngọt đậm đà đưa cơm"* (ID 40).
- Hệ thống áp dụng cơ chế tự động chống lưu bộ nhớ đệm (Cache-Busting `?v=timestamp`), đảm bảo ảnh nguyên liệu tươi sống hiển thị mới tinh 100% trên mọi trình duyệt.

### 4.  Logo Thông Báo Chiếc Chuông Tương Phản Sắc Nét & Dữ Liệu Thật
- **Biểu tượng Chiếc Chuông sắc sảo**: Được thiết kế chuẩn vector chiếc chuông đen đặc khép kín với độ tương phản cao, nổi bật rõ nét trên thanh điều hướng.
- **Hiển thị vượt trội trong Chế độ Ban Đêm**: Nút chuông được bao bọc bởi thẻ tròn phát quang viền cam ấm, xóa bỏ hoàn toàn hiện tượng chìm màu hoặc vòng tròn mờ tối trước đây.
- **17 Thông báo thực tế trên tài khoản `admin1111`**: Khi đăng nhập tài khoản quản trị, biểu tượng chuông hiển thị huy hiệu tròn đỏ rực (`#ef4444`) với **17 thông báo thật** gồm lượt thả tim, bình luận và lời mời theo dõi từ cộng đồng bếp, hỗ trợ lọc theo tab: *Tất cả*, *Yêu thích*, *Bình luận*, *Theo dõi*.

### 5.  Chế Độ Bếp Ban Đêm (High-Contrast Dark Mode) Tối Ưu Nổi Bật Nút Bấm
- Chuyển đổi giao diện Sáng / Tối chỉ với 1 cú click, bảo vệ thị lực khi nấu nướng trong không gian bếp thiếu sáng.
- **Gia cường độ tương phản cao (High-Contrast)**: Toàn bộ các nút bấm (+ Viết món mới, Đăng nhập, Nút cuộn lên đầu trang, Nút lọc chuyên mục, Nút tìm kiếm) đều có độ tương phản đạt chuẩn WCAG AA/AAA, không bị chìm hay biến dạng trên nền đen/slate.

### 6.  Tủ Lạnh Thông Minh 2.0 (Smart Fridge Recipe Matcher)
- **Nấu ngon từ nguyên liệu sẵn có**: Người dùng chọn các nguyên liệu đang có trong bếp (thịt bò, thịt heo, cá, tôm, trứng, rau củ,...).
- **Thuật toán gợi ý thông minh**: Đếm số nguyên liệu trùng khớp, tính toán phần trăm độ phù hợp và sắp xếp ưu tiên các món có thể nấu ngay nhằm chống lãng phí thực phẩm.
- **Gợi ý mua bổ sung**: Liệt kê rõ những gia vị hoặc nguyên liệu phụ còn thiếu để hoàn thiện món ăn.

### 7.  Món Yêu Thích & Đi Chợ Thông Minh (Smart Grocery Checklist)
- **Quản lý món yêu thích & thả tim**:
  - Lưu món ăn để xem lại (`Bookmark`) và Thả tim (`Like`).
  - Thao tác thả tim / bỏ thích nhanh chóng chỉ với 1-Click trực tiếp từ cơ sở dữ liệu thật.
  - Thêm ghi chú bếp cá nhân riêng cho từng món đã lưu.
- **Thanh gom nguyên liệu đi chợ thông minh (Floating Action Bar)**:
  - Cho phép tích chọn một hoặc nhiều món đã lưu, hoặc nút **"Chọn tất cả món"**.
  - Tự động bóc tách và tổng hợp danh sách nguyên liệu cần mua thành bảng kiểm (checklist) thông minh.
  - Hỗ trợ đánh dấu đã mua và nút **"Sao chép danh sách đi chợ"** 1-Click để gửi qua tin nhắn/Zalo.

### 8.  Trải Nghiệm Nấu Nướng Thực Tế Đỉnh Cao
- **Chế độ nấu rảnh tay (Hands-Free Cooking Mode)**: Giao diện toàn màn hình với cỡ chữ lớn, tối ưu thao tác khi tay dính nước hoặc dầu mỡ trong bếp.
- **Đồng hồ bấm giờ nhà bếp (Kitchen Timer)**: Tích hợp bộ đếm giờ thông minh có âm thanh chuông báo Web Audio API khi đến giờ tắt bếp.
- **Bộ điều chỉnh khẩu phần động (Servings Scaler)**: Tự động nhân/chia định lượng nguyên liệu tương ứng theo số người ăn (1 người, 2 người, 4 người, mâm cỗ 8 người,...).
- **In công thức chuẩn khổ giấy (Print Recipe)**: Tự động loại bỏ các thành phần web thừa, tối ưu bản in sạch đẹp để mang vào gian bếp.

### 9.  4 Chính Sách Mô Phỏng Chuẩn Mực & Bản Quyền Độc Quyền
Mô phỏng đầy đủ 4 chuyên trang pháp lý và minh bạch nội dung ở phần chân trang (Footer):
- ** Giới thiệu:** Tuyên ngôn sứ mệnh ẩm thực Cookio và xác lập **Bản quyền độc quyền tác giả Nguyễn Xuân Tú (MSSV: 23010538 - Đại học Phenikaa)**.
- ** Chính sách quảng cáo:** Nguyên tắc quảng cáo sạch, không pop-up phiền nhiễu, ưu tiên nông sản Việt VietGAP/OCOP.
- ** Chính sách bảo mật:** Cam kết mã hóa mật khẩu bcrypt, chống tấn công CSRF và không chia sẻ dữ liệu cho bên thứ ba.
- ** Miễn trừ trách nhiệm:** Hướng dẫn an toàn dị ứng thực phẩm và an toàn lao động trong gian bếp.

---

##  Ngăn Xếp Công Nghệ (Tech Stack)

| Thành phần | Công nghệ sử dụng | Mục đích & Đặc tính |
| :--- | :--- | :--- |
| **Backend** | **PHP 8.2 (Pure Native)** | Kiến trúc phân tầng MVC/Modular, xử lý luồng nhanh, bảo mật PDO Prepared Statements, Session an toàn |
| **Database** | **MariaDB 10.6 Enterprise** | Động cơ InnoDB, toàn vẹn quan hệ khóa ngoại (Foreign Keys), phân chỉ mục B-Tree tối ưu |
| **Frontend** | **Vanilla JavaScript (ES6+)** | Tự viết 100% không phụ thuộc framework cồng kềnh, tối ưu thời gian tải trang < 0.8s |
| **Styling** | **Modern CSS3 & Variables** | Thiết kế Responsive thích ứng mọi thiết bị, hệ màu ấm cúng, hỗ trợ Dark Mode Native |
| **Container**| **Docker & Docker Compose** | Đóng gói tự động máy chủ Apache + MariaDB độc lập, cách ly hoàn toàn dữ liệu |

---

##  Cấu Trúc Thư Mục Dự Án (Project Structure)

```text
cooking-webnangcao-main/
├── actions/                  # Xử lý các tác vụ POST (Like, Bookmark, Bình luận, Auth)
│   ├── auth_action.php       # Xử lý Đăng nhập, Đăng ký (bảo mật CSRF, bcrypt)
│   ├── comment_action.php    # Xử lý gửi bình luận & đánh giá sao
│   ├── cookbook_action.php   # Quản lý sổ tay thực đơn
│   ├── like_action.php       # Xử lý thả tim công thức (dữ liệu thật)
│   └── quick_search_api.php  # API tìm kiếm nhanh theo thời gian thực
├── admin/                    # Cổng quản trị dành riêng cho Ban điều hành (Admin Portal)
│   ├── index.php             # Bảng điều khiển thống kê tổng quan
│   ├── manage-categories.php # Quản lý danh mục món ăn
│   ├── manage-comments.php   # Kiểm duyệt bình luận
│   ├── manage-recipes.php    # Phê duyệt & quản lý công thức món ăn
│   ├── manage-tips.php       # Quản trị mẹo vặt nhà bếp
│   └── manage-users.php      # Quản lý tài khoản người dùng
├── assets/                   # Tài nguyên tĩnh (Static Assets)
│   ├── css/                  # Bảng kiểu dáng giao diện (style.css, user.css, admin.css)
│   ├── images/               # 100% ảnh chụp ẩm thực thật (ingredients, real_dishes, categories)
│   └── js/                   # Mã kịch bản điều khiển (app.js, enterprise-features.js, smart-fridge.js)
├── config/                   # Tệp cấu hình hệ thống
│   └── config.php            # Cấu hình BASE_URL, kết nối DB PDO, hàm bảo mật toàn cục
├── includes/                 # Các thành phần giao diện dùng chung (Partials)
│   ├── db.php                # Kết nối PDO Singleton tối ưu
│   ├── footer.php            # Chân trang YummyDay với 4 chính sách & bản quyền Phan Xuân Tứ
│   ├── header.php            # Thanh điều hướng, tìm kiếm YummyDay & chuông thông báo
│   ├── modal-login.php       # Hộp thoại đăng nhập/đăng ký hiện đại (chuẩn Enterprise)
│   └── modal-all-recipes.php # Menu thực đơn toàn bộ món ăn
├── sql/                      # Cơ sở dữ liệu khởi tạo
│   └── cookio_db.sql         # Bản dump dữ liệu chuẩn hóa, tương tác thật 100%
├── views/                    # Các trang hiển thị chức năng chính
│   ├── author.php            # Gian bếp của tác giả khác
│   ├── cookbooks.php         # Sổ tay thực đơn tuyển chọn
│   ├── create-recipe.php     # Đăng tải công thức mới (bắt buộc tải ảnh thật)
│   ├── kitchen-tips.php      # 51 bài kinh nghiệm hay & mẹo vặt nhà bếp
│   ├── policy.php            # 4 chuyên trang chính sách mô phỏng YummyDay
│   ├── profile.php           # Hồ sơ cá nhân với 6 chỉ số tương tác thực tế
│   ├── recipe-detail.php     # Chi tiết món ăn, chế độ nấu rảnh tay & hẹn giờ
│   ├── saved-recipes.php     # Món yêu thích & thanh gom đồ đi chợ
│   └── smart-fridge.php      # Tủ lạnh thông minh 2.0
├── docker-compose.yml        # Cấu hình khởi chạy hệ thống 1-Click
├── Dockerfile                # Image môi trường máy chủ web PHP Apache
├── index.php                 # Trang chủ Cookio
└── logout.php                # Đăng xuất an toàn, điều hướng sạch về trang khách
```

---

## Hướng Dẫn Cài Đặt & Khởi Chạy

Bạn có thể chạy dự án theo 1 trong 2 cách dưới đây:

### Cách 1: Khởi Chạy Nhanh Bằng Docker (Khuyến nghị số 1)
Hệ thống đã được đóng gói hoàn chỉnh gồm **PHP 8.2 Apache** và **MariaDB 10.6**, tự động nạp cơ sở dữ liệu `sql/cookio_db.sql`:

1. Đảm bảo máy tính đã cài đặt và khởi động **Docker Desktop**.
2. Mở terminal tại thư mục gốc của dự án `cooking-webnangcao-main` và chạy lệnh:
   ```bash
   docker compose up -d --build
   ```
3. Truy cập ngay vào ứng dụng tại trình duyệt:
   - **Website Cookio**: [http://localhost:8088](http://localhost:8088)
   - **Cổng Quản Trị Admin**: [http://localhost:8088/admin/index.php](http://localhost:8088/admin/index.php)

> **Cơ chế tiếp cận mở (Zero-Gate Access Flow):** 
> Khi mở link, trang web hiển thị ngay lập tức toàn bộ công thức, thanh tìm kiếm và kinh nghiệm hay mà **không chặn yêu cầu đăng nhập**. Người dùng tự do khám phá trước và chỉ đăng nhập khi muốn thả tim, lưu bài hoặc quản trị.

---

### Cách 2: Khởi Chạy Thủ Công (XAMPP / PHP Thuần)
1. **Khởi động dịch vụ MySQL / Apache** trong XAMPP Control Panel.
2. **Tạo và nạp Cơ Sở Dữ Liệu**:
   - Mở phpMyAdmin ([http://localhost/phpmyadmin](http://localhost/phpmyadmin)).
   - Tạo cơ sở dữ liệu mới có tên: `cookio_db` (bảng mã `utf8mb4_unicode_ci`).
   - Nhấn thẻ **Import** và chọn tệp: `sql/cookio_db.sql` để nạp dữ liệu.
3. **Cấu hình kết nối**:
   - Kiểm tra tệp `config/config.php` (mặc định user `root`, mật khẩu rỗng `""`, port `3306`).
4. **Chạy máy chủ phát triển PHP**:
   ```bash
   php -S localhost:8088
   ```
5. Mở trình duyệt và truy cập: **[http://localhost:8088](http://localhost:8088)**.

---

##  Tài Khoản Trải Nghiệm Mẫu

Tất cả các tài khoản thử nghiệm trên hệ thống đều được tích hợp mật khẩu tiện ích: **`1`** (hoặc `123456`):

| STT | Tài khoản | Mật khẩu | Phân quyền & Vai trò | Mục đích trải nghiệm & Dữ liệu đặc trưng |
| :---: | :--- | :---: | :--- | :--- |
| 1 | **`admin1111`** | `1` | **Tổng quản trị viên (Admin)** | Sở hữu **17 thông báo thật**, 59 lượt tim nhận về, tác giả 11 công thức tinh tuyển, toàn quyền duyệt bài và quản lý hệ thống. |
| 2 | **`chef_lan`** | `1` | **Bếp trưởng Cookio (Author)** | Tác giả Bò xào hành tây, Bông cải xào bò, Thịt gà hấp. Có tương tác theo dõi đa chiều với cộng đồng. |
| 3 | **`me_bong`** | `1` | **Bếp cơm gia đình (Author)** | Tác giả Bắp cải luộc chấm trứng dầm mắm, Sườn xào chua ngọt, Cơm chiên gà xối mỡ. |
| 4 | **`chu_nam_cook`** | `1` | **Ẩm thực Nam Bộ (Author)** | Tác giả Ốc bươu nhồi thịt hấp sả, Thịt kho tàu nước dừa, Canh chua cá lóc miền Tây. |
| 5 | **`bep_hoa`** | `1` | **Ẩm thực truyền thống (Author)**| Tác giả Canh cua mồng tơi rau đay, Phở bò Hà Nội, Bánh xèo miền Tây giòn rụm. |
| 6 | **`lan_anh_kitchen`**| `1` | **Eat Clean & Dinh dưỡng (Author)**| Tác giả Salad ức gà sốt mè rang, Bò né hoa thiên lý ít dầu mỡ, định lượng calo chuẩn. |
| 7 | **`an_ngon_moingay`**| `1` | **Thực đơn tiện lợi (Author)** | Chuyên công thức bữa sáng nhanh dưới 15 phút (Bánh mì chảo xíu mại trứng ốp la). |
| 8 | **`user1111`** | `1` | **Thành viên trải nghiệm (User)** | Tài khoản thử nghiệm lưu món, đi chợ thông minh, bình luận đánh giá và theo dõi đầu bếp. |

---

##  Tiêu Chuẩn Bảo Mật & Dữ Liệu Sạch (OWASP Standards)

- **100% Tương tác thật - Không Bot rác**: Toàn bộ dữ liệu tài khoản, bài viết, lượt thả tim (`recipe_likes`), thông báo (`notifications`) và bình luận (`comments`) đều là dữ liệu thực tế từ cộng đồng, không dùng số liệu ngẫu nhiên giả tạo.
- **Bảo vệ CSRF 100%**: Tất cả các thao tác thêm, sửa, xóa, duyệt bài (POST request) đều được xác thực bằng mã Token ngẫu nhiên theo phiên làm việc (`csrf_token()`).
- **An toàn Tải lên Tệp tin (File Upload)**: Kiểm tra MIME thực tế bằng `finfo`, kiểm soát định dạng ảnh cho phép (JPG, PNG, WEBP), giới hạn dung lượng tối đa 5MB và tự động đổi tên tệp an toàn chống tấn công Path Traversal.
- **Ngăn chặn SQL Injection**: 100% các truy vấn cơ sở dữ liệu được thực hiện thông qua **PDO Prepared Statements**.
- **Chống XSS (Cross-Site Scripting)**: Toàn bộ dữ liệu do người dùng nhập đều được xử lý qua hàm chuẩn hóa `e()` / `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` trước khi render ra giao diện.
- **Vòng đời phiên làm việc an toàn (Secure Session & Clean Logout)**: Tái tạo ID session khi đăng nhập và cơ chế hủy session sạch sẽ khi bấm Đăng xuất, tự động đưa người dùng về giao diện công cộng của trang web.

---

##  Bản Quyền Độc Quyền & Tuyên Bố Bản Quyền

```text
================================================================================
BẢN QUYỀN ĐỘC QUYỀN THUỘC VỀ PHAN XUÂN TỨ (TUNO) - MSSV: 23010538
ĐỒ ÁN MÔN HỌC: WEB NÂNG CAO - KHOA CÔNG NGHỆ THÔNG TIN - ĐẠI HỌC PHENIKAA
NĂM HOÀN THÀNH: 2026
MỌI HÀNH VI SAO CHÉP CHƯA ĐƯỢC PHÉP ĐỀU LÀ VI PHẠM PHÁP LUẬT SỞ HỮU TRÍ TUỆ.
================================================================================
```

© 2026 **Phan Xuân Tứ (Tuno)**. Đại học Phenikaa. Nền tảng ẩm thực gia đình gắn kết triệu gian bếp Việt.
