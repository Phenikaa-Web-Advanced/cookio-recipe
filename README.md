# Cookio - Mạng Xã Hội Ẩm Thực & Chia Sẻ Công Thức Nấu Ăn Gia Đình

Chào mừng bạn đến với **Cookio**! Đây là dự án website ẩm thực được nhóm phát triển cho đồ án môn **Phát triển Ứng dụng Web Nâng Cao**. Website được thiết kế với phong cách hiện đại, tinh tế lấy cảm hứng từ các nền tảng nấu ăn hàng đầu như *Cookpad*, *Tasty* và *Yummly*, kết hợp với văn hóa ẩm thực truyền thống Việt Nam.

---

## 📌 1. Giới thiệu tổng quan

Cookio được xây dựng nhằm giải quyết câu hỏi muôn thuở mỗi ngày: *"Hôm nay ăn gì?"*. Nền tảng không chỉ là nơi lưu trữ công thức nấu ăn, mà là một **mạng xã hội ẩm thực tương tác thực tế** dành cho các gia đình, người nội trợ và những bạn trẻ yêu bếp.

### Điểm nhấn công nghệ của dự án:
- **Backend:** PHP 8.2 thuần chuẩn MVC/modular, không phụ thuộc framework nặng nề, tốc độ phản hồi cực nhanh dưới 50ms.
- **Frontend:** Vanilla JavaScript (ES6+), HTML5 Semantic, CSS3 hiện đại với hiệu ứng mượt mà và hỗ trợ chế độ nền tối (Dark Mode).
- **Cơ sở dữ liệu:** MariaDB 10.11 / MySQL 8.0, phân tầng bảng rõ ràng, quan hệ khóa ngoại toàn vẹn và dữ liệu tương tác thực 100%.
- **Môi trường triển khai:** Đóng gói toàn bộ bằng **Docker** và **Docker Compose**, chạy độc lập trên cổng riêng biệt, không làm ảnh hưởng hay xung đột dữ liệu với bất kỳ dự án nào khác trên máy.

---

## 🚀 2. Hướng dẫn cài đặt & Khởi chạy nhanh bằng Docker

Để đảm bảo môi trường mới tinh, độc lập và không xung đột cổng hoặc database với các dự án khác trên máy của bạn, dự án đã được cấu hình chạy toàn bộ trên Docker:

- **Web Server:** Cổng `8088` (truy cập tại: `http://localhost:8088`)
- **MariaDB Database:** Cổng `3308` (tránh cổng 3306 mặc định của XAMPP/MySQL)
- **Database Volume:** `webnangcao_cooking_db_data` (lưu trữ độc lập)

### Các bước chạy:

1. **Khởi động containers:**
   Mở terminal tại thư mục gốc của dự án (`cooking-webnangcao-main`), chạy lệnh:
   ```bash
   docker compose up -d --build
   ```
2. **Truy cập ứng dụng:**
   Mở trình duyệt web và truy cập địa chỉ:
   ```
   http://localhost:8088
   ```
   *Cơ sở dữ liệu sẽ tự động được khởi tạo và nạp đầy đủ toàn bộ dữ liệu mẫu ban đầu từ tệp `sql/cookio_db.sql`.*

3. **Dừng container khi không sử dụng:**
   ```bash
   docker compose down
   ```

---

## 🔑 3. Danh sách tài khoản thử nghiệm hệ thống

Tất cả các tài khoản dưới đây đều đã được nạp sẵn dữ liệu thật, bao gồm công thức đã đăng, lượt tương tác thả tim, bình luận và theo dõi chéo. Để thuận tiện nhất cho việc chấm bài và đánh giá, bạn có thể đăng nhập vào **bất kỳ tài khoản nào** bằng mật khẩu nhanh: **`1`** (hoặc `123456`):

| STT | Tên tài khoản | Mật khẩu tiện ích | Vai trò | Mô tả & Dữ liệu sẵn có |
|:---:|:---|:---:|:---|:---|
| 1 | **`admin1111`** | `1` hoặc `admin1111` | Quản trị viên (Admin) | Tác giả của 11 công thức nấu ăn đặc sắc. Có quyền duyệt bài, quản trị bài viết, người dùng và sở hữu **17 thông báo tương tác thật** từ cộng đồng. |
| 2 | **`chef_lan`** | `1` hoặc `123456` | Bếp trưởng (User) | Tác giả 6 món xào và món ngon nổi tiếng (Bò xào hành tây, Thịt gà hấp...). Đang theo dõi và tương tác sôi nổi với admin1111. |
| 3 | **`me_bong`** | `1` hoặc `123456` | Bếp cơm gia đình | Mẹ Bống chuyên các món cơm nhà ấm cúng (Sườn xào chua ngọt, Nộm hoa chuối tai heo...). |
| 4 | **`chu_nam_cook`** | `1` hoặc `123456` | Đặc sản Nam Bộ | Chú Năm Cook chuyên món kho tộ, cá linh bông điên điển, canh chua cá lóc đậm vị miền Tây. |
| 5 | **`bep_hoa`** | `1` hoặc `123456` | Bếp truyền thống | Chuyên gia phở bò Hà Nội gia truyền, nem rán truyền thống và cá bống kho tiêu gừng. |
| 6 | **`lan_anh_kitchen`** | `1` hoặc `123456` | Healthy & Eat Clean | Tác giả công thức Salad ức gà sốt mè rang, Bò né hoa thiên lý ít dầu mỡ, tính toán calo chuẩn. |
| 7 | **`an_ngon_moingay`** | `1` hoặc `123456` | Món nhanh 15-20p | Chuyên thực đơn bữa sáng và bữa cơm nhanh gọn cho dân văn phòng (Bánh mì chảo xíu mại...). |
| 8 | **`user1111`** | `1` hoặc `123456` | Thành viên mới | Tài khoản người dùng trải nghiệm lưu món, bình luận học nấu ăn và theo dõi các bếp trưởng. |

---

## 🌟 4. Chi tiết các tính năng nổi bật đã hoàn thiện

### 1. Đồng bộ ảnh món ăn thực tế (100% Ảnh Thật Chuẩn Xác)
- Các mục hiển thị đầu trang như **Kinh nghiệm hay**, **Bí quyết nhà bếp** và danh sách gợi ý đều được đồng bộ hóa với ảnh chụp món ăn thật chất lượng cao, đúng 100% với tên món:
  - *Thịt heo quay giòn bì tại nhà*: Ảnh chụp cận cảnh miếng thịt heo quay bì nổ cốm vàng giòn rụm.
  - *Chân gà sốt Thái chua cay đậm đà*: Chân gà rút xương ngấm sốt me chua cay, sả tắc đỏ au.
  - *Gà cúng cánh tiên da vàng óng*: Con gà ta luộc buộc cánh tiên da bóng mỡ nghệ, không nứt.
  - *Nước màu kho thịt cá lên màu tự nhiên*: Nồi cá kho tộ lên màu nâu cánh gián óng ả thơm nức.
  - *Bò né hoa thiên lý, phở bò Hà Nội, canh chua cá lóc, bún chả...* đều có ảnh chân thực đúng món.

### 2. Giao diện Đăng nhập / Đăng ký hiện đại chuẩn nền tảng lớn
- Hộp thoại (Modal) đăng nhập được thiết kế lại tối giản, sang trọng:
  - Loại bỏ hoàn toàn khối tài khoản đăng nhập nhanh cũ, thay bằng form nhập liệu chuẩn mực với icon trực quan.
  - Chuyển đổi mượt mà giữa hai tab **Đăng nhập** và **Đăng ký mới**.
  - Tính năng bật/tắt hiển thị mật khẩu bằng mắt thần (Eye toggle) mượt mà.
  - Hỗ trợ ghi nhớ trạng thái và bảo vệ chống tấn công CSRF.

### 3. Nâng cấp bộ máy Tìm kiếm thông minh (Smart Search Engine)
- **Khắc phục triệt để lỗi tìm kiếm tiếng Việt:** Trước đây, tìm "bò" thường bị dính các món có từ "bông", "bống", "bột", hay "gà" bị dính "gia vị".
- **Bộ lọc RegEx phân tách từ chính xác:** Áp dụng biểu thức chính quy ranh giới từ `[[:<:]]keyword[[:>:]]` kết hợp cờ không phân biệt chữ hoa thường `(?i)`:
  - Khi tìm từ khóa **`bò`**: Kết quả chỉ trả về chính xác các món có chứa từ "bò" (*Bò xào hành tây*, *Canh thịt bò*, *Phở bò Hà Nội*, *Bò né hoa thiên lý*, *Thịt bò xào tỏi*, *Nộm thịt bò*). Tuyệt đối không bị lẫn bánh bông lan hay cá bống.
  - Khi tìm từ khóa **`gà`**: Chỉ trả về đúng các món làm từ thịt gà (*Gà hấp lá chanh*, *Salad ức gà*, *Cơm chiên gà xối mỡ*, *Súp gà cho bé*, *Gà hấp hành*, *Miến xào lòng gà*, *Gà xào hạt điều*).
  - Hỗ trợ tìm kiếm từ khóa kép như *gà xào*, *thịt bò*, *canh chua* vô cùng chuẩn xác.
  - Gợi ý tìm kiếm trực tiếp (Quick Live Search) phản hồi tức thì ngay khi gõ phím.

### 4. Hệ thống Tương tác Mạng Xã Hội Thực Tế & Lượt Thả Tim Thật 100%
- **Số lượng tym hoàn toàn là dữ liệu thật:** Tổng số tim hiển thị trên từng món ăn được tính toán dựa trên số bản ghi thực tế trong bảng `recipe_likes`, không sử dụng số ảo ngẫu nhiên.
- **Tương tác đa chiều giữa các thành viên:**
  - Hệ thống bình luận (`comments`): Đánh giá sao (1-5 sao) kèm nhận xét chia sẻ trải nghiệm nấu ăn thực tế.
  - Hệ thống theo dõi (`follows`): Các tài khoản theo dõi lẫn nhau để cập nhật công thức mới.
  - Món đã lưu & Ghi chú cá nhân (`saved_recipes`): Từng tài khoản lưu lại các món tủ kèm ghi chú kinh nghiệm của riêng mình.
- **Trung tâm thông báo hình Chiếc Chuông (Bell Notification):**
  - Biểu tượng thông báo trên thanh điều hướng được chuẩn hóa thành **hình chiếc chuông sắc nét**.
  - Có huy hiệu màu đỏ hiển thị số lượng thông báo mới chưa đọc.
  - Tài khoản **`admin1111`** sở hữu bảng thông báo phong phú gồm lượt thả tim, bình luận và theo dõi mới từ `chef_lan`, `me_bong`, `chu_nam_cook`, `bep_hoa`...
  - Hỗ trợ lọc thông báo theo từng danh mục: *Tất cả*, *Yêu thích (tym)*, *Bình luận*, *Theo dõi* và tính năng đánh dấu đã đọc 1-Click.

### 5. Chi tiết món ăn & Bí quyết nhà bếp (Kitchen Tips Modal)
- Khi bấm vào bất kỳ mẹo vặt nào trong trang **Kinh nghiệm hay**, popup chi tiết sẽ hiển thị đầy đủ hình ảnh thực tế, phần tóm tắt ngắn và từng bước hướng dẫn cụ thể kèm tỷ lệ gia vị chuẩn chỉ.
- Trang chi tiết công thức (`views/recipe-detail.php`) hiển thị đầy đủ nguyên liệu, các bước làm kèm ảnh minh họa, bảng tính calo/dinh dưỡng, nút tăng giảm khẩu phần ăn theo số người và chế độ nấu rảnh tay (Full-screen Cooking Mode).

### 6. Các tiện ích thông minh khác
- **Tủ lạnh thông minh (Smart Fridge):** Chọn những nguyên liệu còn sót lại trong tủ lạnh gia đình, hệ thống sẽ tự động đề xuất những món ăn nấu được ngay.
- **Sổ tay thực đơn tuyển chọn (Curated Cookbooks):** Menu 7 ngày cơm gia đình, thực đơn Eat Clean giảm mỡ tăng cơ, bữa sáng cấp tốc dưới 15 phút.
- **Chế độ sáng / tối (Dark Mode):** Chuyển đổi linh hoạt giữa giao diện ban ngày tươi sáng và giao diện ban đêm ấm áp, dịu mắt.
- **Bảo mật nhiều lớp:** Kiểm tra CSRF token cho tất cả form POST, lọc mã độc XSS bằng hàm `htmlspecialchars` (qua alias `e()`), chuẩn hóa đường dẫn chống Local File Inclusion (LFI).

---

## 📁 5. Cấu trúc thư mục dự án

```
cooking-webnangcao-main/
├── actions/                  # Xử lý các yêu cầu backend & API AJAX
│   ├── auth_action.php       # Đăng nhập, đăng ký, phiên làm việc
│   ├── notification_action.php # API danh sách & đánh dấu đọc thông báo
│   ├── quick_search_api.php  # API tìm kiếm nhanh & gợi ý trực tiếp
│   └── recipe_action.php     # Thêm/sửa công thức, thả tim, bình luận
├── admin/                    # Phân hệ Quản trị viên (Admin Portal)
│   ├── index.php             # Dashboard thống kê tổng quan
│   ├── manage-recipes.php    # Quản lý & kiểm duyệt công thức
│   ├── manage-comments.php   # Quản lý bình luận
│   └── manage-users.php      # Quản lý tài khoản thành viên
├── assets/                   # Tài nguyên giao diện
│   ├── css/                  # style.css, user.css, admin.css
│   ├── js/                   # enterprise-features.js, script.js
│   └── images/               # Logo SVG, ảnh nguyên liệu, thư mục real_dishes/
├── config/                   # Cấu hình hệ thống & kết nối DB
│   └── config.php
├── includes/                 # Các thành phần giao diện dùng chung
│   ├── db.php                # Kết nối PDO MariaDB/MySQL an toàn
│   ├── header.php            # Thanh điều hướng, chuông thông báo, menu
│   ├── footer.php            # Chân trang & liên kết hỗ trợ
│   ├── modal-login.php       # Popup đăng nhập / đăng ký hiện đại
│   └── admin-sidebar.php     # Sidebar quản trị
├── sql/                      # Cơ sở dữ liệu mẫu chuẩn
│   └── cookio_db.sql         # File nạp database tự động cho Docker
├── views/                    # Các trang chức năng người dùng
│   ├── cookbooks.php         # Sổ tay thực đơn tuyển chọn
│   ├── create-recipe.php     # Đăng tải công thức nấu ăn mới
│   ├── kitchen-tips.php      # Kinh nghiệm hay & mẹo vặt nhà bếp
│   ├── my-recipes.php        # Danh sách món của tôi & thống kê bếp
│   ├── recipe-detail.php     # Chi tiết công thức nấu & bình luận
│   ├── saved-recipes.php     # Kho món yêu thích & ghi chú
│   └── smart-fridge.php      # Tủ lạnh thông minh tìm món theo nguyên liệu
├── docker-compose.yml        # Cấu hình container PHP 8.2 + MariaDB 10.11
├── Dockerfile                # Build Apache + PHP Extensions (pdo_mysql)
├── index.php                 # Trang chủ Cookio
└── README.md                 # Hướng dẫn chi tiết dự án
```

---

## 👨‍💻 6. Tác giả & Bản quyền

Dự án được thực hiện nghiêm túc bởi sinh viên Phenikaa University cho học phần **Web Nâng Cao**. Mọi mã nguồn và cơ sở dữ liệu đều tuân thủ các quy tắc lập trình sạch (Clean Code), bảo mật và thân thiện với người dùng.

Chúc bạn có những trải nghiệm nấu nướng thật tuyệt vời cùng **Cookio**! 🍳🥘
