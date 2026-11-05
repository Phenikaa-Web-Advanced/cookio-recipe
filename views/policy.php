<?php

declare(strict_types=1);

$tab = trim((string) ($_GET['tab'] ?? 'about'));
$validTabs = ['about', 'ads', 'privacy', 'disclaimer'];
if (!in_array($tab, $validTabs, true)) {
    $tab = 'about';
}

$pageTitle = match ($tab) {
    'ads' => 'Chính Sách Quảng Cáo - Cookio',
    'privacy' => 'Chính Sách Bảo Mật - Cookio',
    'disclaimer' => 'Miễn Trừ Trách Nhiệm - Cookio',
    default => 'Giới Thiệu & Bản Quyền Độc Quyền - Cookio',
};

require_once __DIR__ . '/../includes/header.php';
?>

<main class="container py-10" style="max-width: 1000px; margin: 0 auto; padding: 2.5rem 1rem;">
    <!-- Breadcrumb -->
    <nav class="breadcrumb mb-6" style="font-size: 0.9rem; color: #6b7280; display: flex; gap: 0.5rem; align-items: center;">
        <a href="<?= BASE_URL ?>/index.php" style="color: #ea580c; text-decoration: none; font-weight: 600;">Trang chủ</a>
        <span>&rsaquo;</span>
        <span style="font-weight: 700; color: #374151;">Chính sách & Thông tin Cookio</span>
    </nav>

    <!-- Header Box -->
    <div class="policy-hero-card" style="background: linear-gradient(135deg, #3e1713 0%, #240d0a 100%); border-radius: 20px; padding: 2.5rem 2rem; color: #ffffff; margin-bottom: 2.5rem; box-shadow: 0 10px 30px rgba(62,23,19,0.18); position: relative; overflow: hidden;">
        <div style="max-width: 680px; position: relative; z-index: 2;">
            <span style="display: inline-block; background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 0.8rem; font-weight: 800; padding: 0.35rem 0.85rem; border-radius: 9999px; margin-bottom: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">
                ⭐ TÁC QUYỀN ĐỘC QUYỀN PHAN XUÂN TỨ (TUNO)
            </span>
            <h1 style="font-size: 2.15rem; font-weight: 800; margin: 0 0 0.75rem; line-height: 1.3;">
                Thông Tin Pháp Lý & Chính Sách Nền Tảng Cookio
            </h1>
            <p style="font-size: 1rem; color: #fed7aa; margin: 0; line-height: 1.6;">
                Mô phỏng tiêu chuẩn quản trị nội dung của YummyDay, xác lập quyền tác giả độc quyền và minh bạch mọi quy chuẩn bảo mật ẩm thực.
            </p>
        </div>
    </div>

    <!-- Navigation Tabs (Mô phỏng 4 phần của YummyDay: Ảnh 4) -->
    <div class="policy-tabs-nav" style="display: flex; gap: 0.75rem; margin-bottom: 2rem; flex-wrap: wrap; border-bottom: 2px solid #fed7aa; padding-bottom: 0.75rem;">
        <a href="<?= BASE_URL ?>/views/policy.php?tab=about" class="policy-tab-item <?= $tab === 'about' ? 'is-active' : '' ?>" style="padding: 0.65rem 1.4rem; border-radius: 12px; font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: all 0.2s; <?= $tab === 'about' ? 'background: #ea580c; color: #ffffff; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);' : 'background: #f8fafc; color: #475569;' ?>">
            📖 Giới thiệu & Bản quyền
        </a>
        <a href="<?= BASE_URL ?>/views/policy.php?tab=ads" class="policy-tab-item <?= $tab === 'ads' ? 'is-active' : '' ?>" style="padding: 0.65rem 1.4rem; border-radius: 12px; font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: all 0.2s; <?= $tab === 'ads' ? 'background: #ea580c; color: #ffffff; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);' : 'background: #f8fafc; color: #475569;' ?>">
            📢 Chính sách quảng cáo
        </a>
        <a href="<?= BASE_URL ?>/views/policy.php?tab=privacy" class="policy-tab-item <?= $tab === 'privacy' ? 'is-active' : '' ?>" style="padding: 0.65rem 1.4rem; border-radius: 12px; font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: all 0.2s; <?= $tab === 'privacy' ? 'background: #ea580c; color: #ffffff; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);' : 'background: #f8fafc; color: #475569;' ?>">
            🛡️ Chính sách bảo mật
        </a>
        <a href="<?= BASE_URL ?>/views/policy.php?tab=disclaimer" class="policy-tab-item <?= $tab === 'disclaimer' ? 'is-active' : '' ?>" style="padding: 0.65rem 1.4rem; border-radius: 12px; font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: all 0.2s; <?= $tab === 'disclaimer' ? 'background: #ea580c; color: #ffffff; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);' : 'background: #f8fafc; color: #475569;' ?>">
            ⚖️ Miễn trừ trách nhiệm
        </a>
    </div>

    <!-- Content Sections -->
    <div class="policy-content-card" style="background: #ffffff; border-radius: 18px; padding: 2.5rem; border: 1px solid #fed7aa; box-shadow: 0 4px 20px rgba(0,0,0,0.04); line-height: 1.8; color: #334155;">

        <?php if ($tab === 'about'): ?>
            <!-- 1. GIỚI THIỆU & BẢN QUYỀN ĐỘC QUYỀN -->
            <div class="policy-section">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <span style="font-size: 2rem;">🏆</span>
                    <h2 style="font-size: 1.65rem; font-weight: 800; color: #1e293b; margin: 0;">Bản Quyền Độc Quyền & Tác Quyền Sản Phẩm</h2>
                </div>
                
                <div style="background: #fff7ed; border-left: 4px solid #ea580c; padding: 1.25rem 1.5rem; border-radius: 0 12px 12px 0; margin-bottom: 1.75rem;">
                    <p style="margin: 0 0 0.5rem; font-size: 1.05rem; font-weight: 800; color: #9a3412;">
                        TUYÊN BỐ SỞ HỮU TRÍ TUỆ ĐỘC QUYỀN (EXCLUSIVE INTELLECTUAL PROPERTY)
                    </p>
                    <p style="margin: 0; font-size: 0.95rem; color: #7c2d12;">
                        Toàn bộ ý tưởng kiến trúc, cấu trúc cơ sở dữ liệu, giao diện người dùng và mã nguồn của nền tảng <strong>Cookio Platform</strong> thuộc quyền sở hữu trí tuệ độc quyền của:
                    </p>
                    <ul style="margin: 0.75rem 0 0; padding-left: 1.25rem; font-weight: 700; color: #1e293b;">
                        <li>Tác giả sáng lập: <strong>Phan Xuân Tứ (Tuno)</strong></li>
                        <li>Mã số sinh viên: <strong>23010538</strong></li>
                        <li>Đơn vị: <strong>Khoa Công nghệ Thông tin - Trường Đại học Phenikaa (Phenikaa University)</strong></li>
                        <li>Đồ án học phần: <strong>Web Nâng Cao</strong></li>
                        <li>Năm phát triển: <strong>2026</strong></li>
                    </ul>
                </div>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">1. Sứ mệnh kiến tạo nền tảng</h3>
                <p>
                    Lấy cảm hứng từ những nền tảng ẩm thực chuẩn mực toàn cầu như <em>Cookpad</em>, <em>Tasty</em> và <em>Yummly</em>, tác giả <strong>Phan Xuân Tứ</strong> đã xây dựng Cookio nhằm số hóa kho tàng ẩm thực gia đình Việt Nam. Cookio không đơn thuần là một website công thức, mà là một không gian bếp ấm cúng kết nối cộng đồng, nơi mỗi bí quyết gia truyền đều được lưu giữ nguyên bản và khoa học.
                </p>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">2. Triết lý Know - Love - Share</h3>
                <ul>
                    <li><strong>Know:</strong> Nắm vững kỹ thuật nấu nướng, tỷ lệ gia vị chuẩn mực và phân tích giá trị dinh dưỡng của từng món ăn.</li>
                    <li><strong>Love:</strong> Đặt tâm huyết, sự tỉ mỉ vào từng khâu sơ chế, nâng niu bữa cơm gia đình đầm ấm.</li>
                    <li><strong>Share:</strong> Lan tỏa niềm hạnh phúc bếp nhà đến hàng triệu người yêu ẩm thực trên toàn quốc.</li>
                </ul>
            </div>

        <?php elseif ($tab === 'ads'): ?>
            <!-- 2. CHÍNH SÁCH QUẢNG CÁO -->
            <div class="policy-section">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <span style="font-size: 2rem;">📢</span>
                    <h2 style="font-size: 1.65rem; font-weight: 800; color: #1e293b; margin: 0;">Chính Sách Quảng Cáo Minh Bạch (Advertising Policy)</h2>
                </div>

                <p>
                    Để duy trì hạ tầng máy chủ và bảo đảm trải nghiệm miễn phí trọn đời cho người dùng, Cookio hợp tác cùng các đối tác thương hiệu theo các nguyên tắc kiểm duyệt khắt khe:
                </p>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">1. Nguyên tắc Không Rác - Không Xâm Lấn</h3>
                <p>
                    Cookio cam kết tuyệt đối không triển khai các định dạng quảng cáo dạng pop-up che khuất màn hình, tự động bật âm thanh hoặc chuyển hướng lừa đảo. Mọi vị trí tài trợ đều được dán nhãn <strong>[Tài trợ]</strong> hoặc <strong>[Quảng cáo]</strong> rõ ràng.
                </p>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">2. Ưu tiên Thực phẩm Sạch & Nông sản Việt</h3>
                <p>
                    Chúng tôi chỉ chấp thuận hợp tác với các nhà cung ứng thiết bị bếp uy tín, gia vị truyền thống có kiểm định an toàn vệ sinh thực phẩm và nông sản đạt tiêu chuẩn <strong>VietGAP / GlobalGAP / OCOP</strong>. Tuyệt đối nghiêm cấm các sản phẩm thuốc không rõ nguồn gốc, chất kích thích hoặc thực phẩm biến đổi gen độc hại.
                </p>
            </div>

        <?php elseif ($tab === 'privacy'): ?>
            <!-- 3. CHÍNH SÁCH BẢO MẬT -->
            <div class="policy-section">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <span style="font-size: 2rem;">🛡️</span>
                    <h2 style="font-size: 1.65rem; font-weight: 800; color: #1e293b; margin: 0;">Chính Sách Bảo Mật Thông Tin (Privacy Policy)</h2>
                </div>

                <p>
                    Bảo vệ quyền riêng tư của từng đầu bếp và thành viên là ưu tiên hàng đầu tại Cookio. Nền tảng áp dụng các tiêu chuẩn an toàn bảo mật nghiêm ngặt:
                </p>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">1. Thu thập và Mã hóa Dữ liệu</h3>
                <ul>
                    <li><strong>Mật khẩu tài khoản:</strong> Được băm một chiều bằng thuật toán <code>bcrypt</code> kết hợp muối ngẫu nhiên trước khi lưu vào MariaDB. Ngay cả quản trị viên cũng không thể đọc mật khẩu thô của bạn.</li>
                    <li><strong>Thông tin liên hệ:</strong> Số điện thoại và email được mã hóa, chỉ dùng cho việc kích hoạt tài khoản và nhận thông báo bếp.</li>
                    <li><strong>Token CSRF:</strong> Mọi thao tác thêm món, thả tim, bình luận đều được ký điện tử nhằm triệt tiêu hoàn toàn rủi ro tấn công giả mạo yêu cầu.</li>
                </ul>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">2. Cam kết Không Chia Sẻ Dữ Liệu</h3>
                <p>
                    Cookio cam kết 100% không bán, không cho thuê hoặc chuyển nhượng dữ liệu cá nhân của người dùng cho bất kỳ bên thứ ba nào vì mục đích thương mại.
                </p>
            </div>

        <?php else: ?>
            <!-- 4. MIỄN TRỪ TRÁCH NHIỆM -->
            <div class="policy-section">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <span style="font-size: 2rem;">⚖️</span>
                    <h2 style="font-size: 1.65rem; font-weight: 800; color: #1e293b; margin: 0;">Tuyên Bố Miễn Trừ Trách Nhiệm (Disclaimer)</h2>
                </div>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">1. Tính chất thông tin tham khảo</h3>
                <p>
                    Toàn bộ công thức nấu nướng, tỷ lệ gia vị và kinh nghiệm mẹo vặt đăng tải trên Cookio được tổng hợp từ thực tế trải nghiệm của cộng đồng đầu bếp gia đình. Mặc dù đội ngũ kiểm duyệt cố gắng đảm bảo độ chính xác tối đa, kết quả thành phẩm có thể thay đổi tùy thuộc vào chất lượng nguyên liệu, độ nóng của bếp và kỹ năng thao tác cá nhân.
                </p>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">2. Cảnh báo an toàn Dị ứng Thực phẩm</h3>
                <p>
                    Người dùng có trách nhiệm tự kiểm tra thành phần nguyên liệu đối với các trường hợp bản thân hoặc thành viên gia đình có tiền sử mẫn cảm hoặc dị ứng (như dị ứng hải sản, tôm cua, đậu phộng, các loại hạt hoặc gluten).
                </p>

                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 1.5rem 0 0.75rem;">3. An toàn lao động trong gian bếp</h3>
                <p>
                    Người dùng cần tuân thủ các quy tắc an toàn cháy nổ đối với bình gas, bếp từ, dao kéo sắc nhọn và dầu ăn sôi nhiệt độ cao. Tác giả <strong>Phan Xuân Tứ</strong> và Cookio được miễn trừ trách nhiệm trước bất kỳ tổn thất hoặc sự cố ngoài ý muốn phát sinh từ việc thực hành công thức tại nhà.
                </p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
