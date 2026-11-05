<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/daily_engagement.php';
require_once __DIR__ . '/../cron/daily_community_bot.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Run silent daily engagement and autonomous community bot check (tối ưu: chỉ kiểm tra 1 lần/giờ theo phiên để đăng nhập và tải trang cực nhanh)
if (empty($_SESSION['daily_simulation_checked']) || (time() - (int)$_SESSION['daily_simulation_checked']) > 3600) {
    run_daily_engagement();
    runDailyCommunityBot();
    $_SESSION['daily_simulation_checked'] = time();
}

// Counters for Cookpad sidebar
$sidebarTotal = (int) db()->query("SELECT COUNT(*) FROM recipes WHERE status = 'approved'")->fetchColumn();
$sidebarSaved = 0;
$sidebarMy = 0;
$sidebarLive = 0;
if (isset($_SESSION['user_id'])) {
    $uid = (int) $_SESSION['user_id'];
    $stmtS = db()->prepare("SELECT COUNT(*) FROM saved_recipes WHERE user_id = ?");
    $stmtS->execute([$uid]);
    $sidebarSaved = (int) $stmtS->fetchColumn();

    $stmtM = db()->prepare("SELECT COUNT(*) FROM recipes WHERE author_id = ?");
    $stmtM->execute([$uid]);
    $sidebarMy = (int) $stmtM->fetchColumn();

    $stmtL = db()->prepare("SELECT COUNT(*) FROM recipes WHERE author_id = ? AND status = 'approved'");
    $stmtL->execute([$uid]);
    $sidebarLive = (int) $stmtL->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Cookio - Nấu ngon mỗi ngày', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css?v=<?= file_exists(__DIR__ . '/../assets/css/style.css') ? filemtime(__DIR__ . '/../assets/css/style.css') : '20261106' ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/user.css?v=<?= file_exists(__DIR__ . '/../assets/css/user.css') ? filemtime(__DIR__ . '/../assets/css/user.css') : '20261106' ?>">
    <script>
        window.BASE_URL = '<?= BASE_URL ?>';
        window.CSRF_TOKEN = '<?= csrf_token() ?>';
    </script>
    <script src="<?= BASE_URL ?>/assets/js/enterprise-features.js?v=<?= file_exists(__DIR__ . '/../assets/js/enterprise-features.js') ? filemtime(__DIR__ . '/../assets/js/enterprise-features.js') : '20261106' ?>" defer></script>
</head>
<body>
<?php require_once __DIR__ . '/modal-login.php'; ?>

<!-- COOKPAD STYLE MINIMALIST SIDEBAR DRAWER (MATCHING IMAGE 1) -->
<div class="cookpad-sidebar-overlay" id="cookpadOverlay" onclick="toggleCookpadSidebar(false)"></div>
<aside class="cookpad-sidebar" id="cookpadSidebar" aria-label="Menu điều hướng Cookio">
    <!-- Header: Logo + Collapse Arrow -->
    <div class="cookpad-sidebar-header">
        <a href="<?= BASE_URL ?>/index.php" class="cookpad-brand" aria-label="Cookio">
            <div class="cookpad-hat-circle">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/>
                    <line x1="6" y1="17" x2="18" y2="17"/>
                </svg>
            </div>
            <span class="cookpad-brand-text">Cookio</span>
        </a>
        <button type="button" class="cookpad-collapse-btn" id="btnCollapseSidebar" onclick="toggleCookpadSidebar(false)" title="Thu gọn" aria-label="Thu gọn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="11 17 6 12 11 7"/>
                <polyline points="18 17 13 12 18 7"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Items with Minimalist Outline Stroke Icons (Image 1) -->
    <nav class="cookpad-nav-list">
        <!-- 1. Tìm kiếm (Active Orange Style) -->
        <a href="<?= BASE_URL ?>/index.php" class="cookpad-nav-item is-search-active" onclick="focusHeaderSearch(event)">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <span style="color: #ea580c; font-weight: 700;">Tìm kiếm</span>
        </a>

        <!-- 2. Premium (Ribbon bookmark with P) -->
        <a href="<?= BASE_URL ?>/views/cookbooks.php" class="cookpad-nav-item">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                <text x="12" y="13" font-size="9" font-family="sans-serif" font-weight="900" text-anchor="middle" fill="#64748b" stroke="none">P</text>
            </svg>
            <span>Premium</span>
        </a>

        <!-- 3. Thống Kê Bếp (Bar chart) -->
        <a href="<?= BASE_URL ?>/views/my-recipes.php" class="cookpad-nav-item">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/>
                <line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <span>Thống Kê Bếp</span>
        </a>

        <!-- 4. Thử Thách (Award medal with ribbon) -->
        <a href="<?= BASE_URL ?>/views/smart-fridge.php" class="cookpad-nav-item">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            <span>Thử Thách</span>
        </a>

        <!-- 5. Tương Tác (Notification Bell) -->
        <a href="javascript:void(0)" class="cookpad-nav-item" onclick="toggleCookpadSidebar(false); toggleNotificationsDropdown();">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span>Tương Tác</span>
        </a>

        <!-- 6. Mẹo Vặt Nhà Bếp (YummyDay Kitchen Tips) -->
        <a href="<?= BASE_URL ?>/views/kitchen-tips.php" class="cookpad-nav-item">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18h6"/>
                <path d="M10 22h4"/>
                <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7z"/>
            </svg>
            <span>Mẹo Vặt Bếp</span>
        </a>

        <!-- 6. KHO MÓN NGON CỦA BẠN (Book section) -->
        <div class="cookpad-section-divider"></div>
        <div class="cookpad-section-header">
            <svg class="cookpad-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                <circle cx="12" cy="8" r="2"/>
            </svg>
            <strong>Kho Món Ngon Của Bạn</strong>
        </div>

        <!-- Mini Search in Repository -->
        <div class="cookpad-mini-search">
            <form method="get" action="<?= BASE_URL ?>/index.php">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" placeholder="Tìm trong kho món ngon" autocomplete="off">
            </form>
        </div>

        <!-- 4 Sub-Categories with Rounded Square Icon Containers (Image 1) -->
        <div class="cookpad-sub-list">
            <!-- Tất Cả -->
            <a href="<?= BASE_URL ?>/index.php" class="cookpad-sub-item">
                <div class="cookpad-sub-icon-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <div class="cookpad-sub-text">
                    <span class="sub-name">Tất Cả</span>
                    <span class="sub-count"><?= $sidebarTotal ?> món</span>
                </div>
            </a>

            <!-- Đã Lưu -->
            <a href="<?= BASE_URL ?>/views/saved-recipes.php" class="cookpad-sub-item">
                <div class="cookpad-sub-icon-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div class="cookpad-sub-text">
                    <span class="sub-name">Đã Lưu</span>
                    <span class="sub-count"><?= $sidebarSaved ?> món</span>
                </div>
            </a>

            <!-- Món Của Tôi -->
            <a href="<?= BASE_URL ?>/views/my-recipes.php" class="cookpad-sub-item">
                <div class="cookpad-sub-icon-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="cookpad-sub-text">
                    <span class="sub-name">Món Của Tôi</span>
                    <span class="sub-count"><?= $sidebarMy ?> món</span>
                </div>
            </a>

            <!-- Đã lên sóng -->
            <a href="<?= BASE_URL ?>/views/my-recipes.php" class="cookpad-sub-item">
                <div class="cookpad-sub-icon-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="2" y1="12" x2="22" y2="12"/>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                </div>
                <div class="cookpad-sub-text">
                    <span class="sub-name">Đã lên sóng</span>
                    <span class="sub-count"><?= $sidebarLive ?> món</span>
                </div>
            </a>
        </div>
    </nav>
</aside>

<!-- MAIN SITE HEADER (COOKIO BRAND & STREAMLINED NAVIGATION) -->
<header class="yummy-site-header">
    <!-- Top Row: Logo Cookio & Pill Search Input -->
    <div class="yummy-top-bar">
        <div class="yummy-top-container">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <button type="button" class="btn-sidebar-toggle" id="btnToggleCookpadSidebar" onclick="toggleCookpadSidebar(true)" title="Menu mở rộng" aria-label="Menu">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <a href="<?= BASE_URL ?>/index.php" class="cookio-brand" aria-label="Cookio Trang chủ">
                    <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="Cookio" class="cookio-logo-img" style="height: 44px; width: auto; display: block;">
                </a>
            </div>

            <!-- Top Search Pill (Đã xóa nút tròn màu nâu theo yêu cầu) -->
            <div class="yummy-top-search-wrap">
                <form method="get" action="<?= BASE_URL ?>/index.php" class="yummy-search-form" id="yummySearchForm" style="padding: 0.45rem 1.25rem;">
                    <svg class="y-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="q" placeholder="Tìm theo tên món" value="<?= e($_GET['q'] ?? '') ?>" autocomplete="off" style="font-size: 0.95rem; width: 100%;">
                </form>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Navigation Menu Bar -->
    <div class="yummy-nav-bar">
        <div class="yummy-nav-container">
            <?php
            $currScript = basename($_SERVER['PHP_SELF'] ?? '');
            $currUri = $_SERVER['REQUEST_URI'] ?? '';
            $currCat = trim((string)($_GET['cat'] ?? ''));
            $currQ = trim((string)($_GET['q'] ?? ''));

            $isHomeActive = ($currScript === 'index.php' && $currCat === '' && $currQ === '');
            $isDishesActive = ($currCat !== '');
            $isTipsActive = str_contains($currUri, 'kitchen-tips.php');
            $isFridgeActive = str_contains($currUri, 'smart-fridge.php');
            $isSavedActive = str_contains($currUri, 'saved-recipes.php');
            ?>
            <nav class="yummy-main-nav">
                <!-- 1. Trang chủ -->
                <a href="<?= BASE_URL ?>/index.php" class="y-nav-item <?= $isHomeActive ? 'is-active' : '' ?>">
                    <?= $isHomeActive ? '<span class="y-dot">•</span> ' : '' ?>Trang chủ
                </a>

                <!-- 2. Món ngon (Dropdown) -->
                <div class="y-nav-dropdown-wrap">
                    <a href="javascript:void(0)" class="y-nav-item <?= $isDishesActive ? 'is-active' : '' ?>">
                        <?= $isDishesActive ? '<span class="y-dot">•</span> ' : '' ?>Món ngon
                        <svg class="y-nav-chevron" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <div class="y-dropdown-menu">
                        <a href="<?= BASE_URL ?>/index.php?cat=Món+xào">Món xào</a>
                        <a href="<?= BASE_URL ?>/index.php?cat=Món+canh">Món canh</a>
                        <a href="<?= BASE_URL ?>/index.php?cat=Món+kho">Món kho</a>
                        <a href="<?= BASE_URL ?>/index.php?cat=Món+hấp">Món hấp</a>
                        <a href="<?= BASE_URL ?>/index.php?cat=Món+chiên">Món chiên</a>
                    </div>
                </div>

                <!-- 3. Kinh nghiệm hay -->
                <a href="<?= BASE_URL ?>/views/kitchen-tips.php" class="y-nav-item <?= $isTipsActive ? 'is-active' : '' ?>">
                    <?= $isTipsActive ? '<span class="y-dot">•</span> ' : '' ?>Kinh nghiệm hay
                </a>

                <!-- 4. Nguyên liệu (Tách riêng chức năng tủ lạnh thông minh ở giữa Kinh nghiệm hay và Món yêu thích) -->
                <a href="<?= BASE_URL ?>/views/smart-fridge.php" class="y-nav-item <?= $isFridgeActive ? 'is-active' : '' ?>">
                    <?= $isFridgeActive ? '<span class="y-dot">•</span> ' : '' ?>Nguyên liệu
                </a>

                <!-- 5. Món yêu thích (Đổi tên từ Món đã lưu) -->
                <a href="<?= BASE_URL ?>/views/saved-recipes.php" class="y-nav-item <?= $isSavedActive ? 'is-active' : '' ?>">
                    <?= $isSavedActive ? '<span class="y-dot">•</span> ' : '' ?>Món yêu thích
                </a>
            </nav>

            <!-- Right Action Buttons: Viết món mới & Nút vào phòng quản lý & Notification Bell & Auth -->
            <div class="yummy-nav-actions" style="display: flex; align-items: center; gap: 0.65rem;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php
                    $headerUserId = (int) $_SESSION['user_id'];
                    $headerUnreadCount = (int) db()->query("SELECT COUNT(*) FROM notifications WHERE user_id = $headerUserId AND is_read = 0")->fetchColumn();
                    $stmtHN = db()->prepare("
                        SELECT n.*, u.username AS actor_name
                        FROM notifications n
                        JOIN users u ON u.id = n.actor_id
                        WHERE n.user_id = ?
                        ORDER BY n.created_at DESC
                        LIMIT 30
                    ");
                    $stmtHN->execute([$headerUserId]);
                    $headerNotifs = $stmtHN->fetchAll();
                    ?>
                    <a href="<?= BASE_URL ?>/views/create-recipe.php" class="button button-create" style="padding: 0.45rem 1.1rem; border-radius: 9999px; font-weight: 700; font-size: 0.88rem;">
                        + Viết món mới
                    </a>

                    <!-- Nút vào phòng quản lý của admin (Sửa hình tròn trắng thành nút phòng quản lý theo đúng yêu cầu) -->
                    <a href="<?= BASE_URL ?>/admin/index.php" class="btn-admin-room" title="Vào phòng quản lý của Admin" style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.45rem 1.1rem; border-radius: 9999px; background: #3e1713; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 0.88rem; box-shadow: 0 3px 10px rgba(62, 23, 19, 0.2); transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#ea580c';" onmouseout="this.style.background='#3e1713';">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="3" x2="9" y2="21"></line>
                        </svg>
                        <span>Phòng quản lý</span>
                    </a>

                    <!-- Notification Bell (Khớp 100% Ảnh chiếc chuông đen, có quả lắc tách rời, pre-rendered dữ liệu không bao giờ bị mất) -->
                    <div class="notification-wrapper" style="position: relative;">
                        <button type="button" class="notification-btn" id="btnNotifications" title="Thông báo" aria-label="Thông báo" onclick="toggleNotificationsDropdown(event)" style="width: 42px; height: 42px; border-radius: 50%; background: #ffffff; border: 2px solid #ea580c; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; position: relative; box-shadow: 0 2px 10px rgba(0,0,0,0.12); flex-shrink: 0;">
                            <svg class="cookio-bell-icon" width="22" height="22" viewBox="0 0 24 24" style="display: block; width: 22px; height: 22px; pointer-events: none;">
                                <path d="M12 2a2 2 0 0 0-2 2c0 .18.02.35.07.52C7.38 5.43 5.5 8.24 5.5 11.5v4.25c0 .4-.16.78-.45 1.07l-1.3 1.3A1 1 0 0 0 4.46 20h15.08a1 1 0 0 0 .71-1.71l-1.3-1.3a1.5 1.5 0 0 1-.45-1.07V11.5c0-3.26-1.88-6.07-4.57-6.98.05-.17.07-.34.07-.52a2 2 0 0 0-2-2z" fill="#3e1713"></path>
                                <path d="M9.5 21a2.5 2.5 0 0 0 5 0h-5z" fill="#3e1713"></path>
                            </svg>
                            <span class="notif-badge" id="notifBadge" style="<?= $headerUnreadCount > 0 ? 'display: flex;' : 'display: none;' ?>">
                                <?= $headerUnreadCount > 9 ? '9+' : $headerUnreadCount ?>
                            </span>
                        </button>
                        <div class="notification-dropdown" id="notificationDropdown" style="display: none; position: absolute; top: calc(100% + 12px); right: 0; width: 360px; max-width: 90vw; background: #ffffff; border: 1.5px solid #fed7aa; border-radius: 18px; box-shadow: 0 12px 36px rgba(0,0,0,0.15); z-index: 10000; overflow: hidden;">
                            <div class="notification-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; background: #fffaf5;">
                                <span style="font-weight: 800; color: #3e1713; font-size: 0.95rem;">Thông báo của bạn</span>
                                <button type="button" class="btn-mark-all-read" onclick="markAllNotificationsRead()" style="background: none; border: none; color: #ea580c; font-size: 0.8rem; font-weight: 700; cursor: pointer;">Đã đọc tất cả</button>
                            </div>
                            <div class="notification-tabs" style="display: flex; background: #f8fafc; padding: 6px; gap: 4px; border-bottom: 1px solid #e2e8f0;">
                                <button type="button" class="notif-tab is-active" data-filter="all" onclick="filterNotifications('all', this)">Tất cả</button>
                                <button type="button" class="notif-tab" data-filter="like" onclick="filterNotifications('like', this)">Yêu thích</button>
                                <button type="button" class="notif-tab" data-filter="comment" onclick="filterNotifications('comment', this)">Bình luận</button>
                                <button type="button" class="notif-tab" data-filter="follow" onclick="filterNotifications('follow', this)">Theo dõi</button>
                            </div>
                            <div class="notification-list" id="notificationList" style="max-height: 380px; overflow-y: auto;">
                                <?php if (empty($headerNotifs)): ?>
                                    <div id="notifEmptyNotice" style="padding: 2.5rem 1rem; text-align: center; color: #94a3b8; font-size: 0.88rem;">Chưa có thông báo nào.</div>
                                <?php else: ?>
                                    <?php foreach ($headerNotifs as $n): ?>
                                        <?php
                                        $nType = $n['type'];
                                        $nIcon = match ($nType) {
                                            'like' => '❤️',
                                            'comment' => '💬',
                                            'cooksnap' => '📸',
                                            'follow' => '👥',
                                            default => '🔔'
                                        };
                                        $nTargetUrl = '#';
                                        if ($nType === 'follow') {
                                            $nTargetUrl = BASE_URL . '/views/author.php?id=' . (int) $n['actor_id'];
                                        } elseif (!empty($n['target_id'])) {
                                            $nTargetUrl = BASE_URL . '/views/recipe-detail.php?id=' . (int) $n['target_id'] . ($nType === 'comment' ? '#comments' : '');
                                        }
                                        ?>
                                        <a href="<?= $nTargetUrl ?>" class="notification-item <?= empty($n['is_read']) ? 'is-unread' : '' ?>" data-type="<?= e($nType) ?>" style="display: flex; gap: 0.75rem; padding: 0.85rem 1.15rem; border-bottom: 1px solid #f8fafc; text-decoration: none; color: inherit; transition: background 0.15s;" onmouseover="this.style.background='#fff7ed';" onmouseout="this.style.background='transparent';">
                                            <span class="notif-icon" style="font-size: 1.25rem; flex-shrink: 0; margin-top: 2px;"><?= $nIcon ?></span>
                                            <div class="notif-body" style="flex: 1; font-size: 0.88rem; line-height: 1.45;">
                                                <strong style="color: #1e293b;"><?= e($n['actor_name']) ?></strong> 
                                                <span style="color: #475569;"><?= e($n['content']) ?></span>
                                                <span class="notif-time" style="display: block; font-size: 0.76rem; color: #94a3b8; margin-top: 0.25rem;">
                                                    🕒 <?= date('d/m/Y H:i', strtotime((string)$n['created_at'])) ?>
                                                </span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div id="notifEmptyFilterNotice" style="display: none; padding: 2.5rem 1rem; text-align: center; color: #94a3b8; font-size: 0.88rem;">Chưa có thông báo nào trong mục này.</div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= BASE_URL ?>/views/profile.php" class="user-menu-chip" title="Xem hồ sơ">
                        <span class="user-avatar-circle"><?= mb_substr((string) $_SESSION['username'], 0, 1) ?></span>
                        <span><?= e((string) $_SESSION['username']) ?></span>
                    </a>

                    <a href="<?= BASE_URL ?>/logout.php" class="btn-header-logout" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; transition: all 0.2s;" title="Đăng xuất khỏi tài khoản">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </a>
                <?php else: ?>
                    <!-- Nút Viết món mới khi click vào sẽ bật form/modal đăng nhập và tự động chuyển trang khi đăng nhập thành công -->
                    <button type="button" class="button button-create" onclick="openLoginForCreateRecipe()" style="padding: 0.45rem 1.1rem; border-radius: 9999px; font-weight: 700; font-size: 0.88rem;">
                        + Viết món mới
                    </button>

                    <!-- Nút vào phòng quản lý của admin (Sửa hình tròn trắng thành nút phòng quản lý theo đúng yêu cầu) -->
                    <a href="<?= BASE_URL ?>/admin/index.php" class="btn-admin-room" title="Vào phòng quản lý của Admin" style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.45rem 1.1rem; border-radius: 9999px; background: #3e1713; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 0.88rem; box-shadow: 0 3px 10px rgba(62, 23, 19, 0.2); transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#ea580c';" onmouseout="this.style.background='#3e1713';">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="3" x2="9" y2="21"></line>
                        </svg>
                        <span>Phòng quản lý</span>
                    </a>

                    <!-- Nút Chuông Thông Báo (Khớp 100% Ảnh chiếc chuông đen, có quả lắc tách rời, tương phản cao) -->
                    <button type="button" class="notification-btn" title="Thông báo" aria-label="Thông báo" data-open-login style="width: 42px; height: 42px; border-radius: 50%; background: #ffffff; border: 2px solid #ea580c; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; position: relative; box-shadow: 0 2px 10px rgba(0,0,0,0.12); flex-shrink: 0;">
                        <svg class="cookio-bell-icon" width="22" height="22" viewBox="0 0 24 24" style="display: block; width: 22px; height: 22px; pointer-events: none;">
                            <path d="M12 2a2 2 0 0 0-2 2c0 .18.02.35.07.52C7.38 5.43 5.5 8.24 5.5 11.5v4.25c0 .4-.16.78-.45 1.07l-1.3 1.3A1 1 0 0 0 4.46 20h15.08a1 1 0 0 0 .71-1.71l-1.3-1.3a1.5 1.5 0 0 1-.45-1.07V11.5c0-3.26-1.88-6.07-4.57-6.98.05-.17.07-.34.07-.52a2 2 0 0 0-2-2z" fill="#3e1713"></path>
                            <path d="M9.5 21a2.5 2.5 0 0 0 5 0h-5z" fill="#3e1713"></path>
                        </svg>
                    </button>

                    <!-- Nút Đăng nhập -->
                    <button type="button" class="y-pill-btn-brown" data-open-login style="padding: 0.45rem 1.15rem; font-size: 0.88rem;">
                        Đăng nhập
                    </button>
                <?php endif; ?>

                <!-- Dark Mode Toggle Button -->
                <button type="button" class="dark-mode-toggle" id="btnToggleDarkMode" title="Chuyển chế độ sáng/tối" aria-label="Chuyển chế độ sáng/tối">
                    <span class="theme-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- HORIZONTAL FULL-WIDTH LIVE SEARCH OVERLAY -->
    <div class="horizontal-search-overlay" id="horizontalSearchOverlay" style="display: none;">
        <div class="horizontal-search-backdrop" onclick="closeHorizontalSearch()"></div>
        <div class="horizontal-search-container">
            <div class="horizontal-search-bar">
                <svg class="h-search-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="horizontalSearchInput" class="horizontal-search-input" placeholder="Tìm kiếm món ăn, nguyên liệu, cách nấu..." autocomplete="off" oninput="handleHorizontalSearchInput(this.value)">
                <button type="button" id="hSearchClear" class="btn-h-search-clear" onclick="clearHorizontalSearch()" title="Xóa tìm kiếm" style="display: none;">&times;</button>
                <button type="button" class="btn-h-search-close" onclick="closeHorizontalSearch()" title="Đóng tìm kiếm (Esc)">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="horizontal-search-body">
                <!-- Recent Searches -->
                <div id="hRecentWrap" class="h-suggestions-section" style="display: none;">
                    <div class="h-section-title">Lịch sử tìm kiếm gần đây</div>
                    <div id="hRecentTags" class="h-tags-flex"></div>
                </div>

                <!-- Trending Topics / Shortcuts -->
                <div class="h-suggestions-section">
                    <div class="h-section-title">Gợi ý tìm kiếm phổ biến</div>
                    <div class="h-tags-flex">
                        <a href="<?= BASE_URL ?>/index.php?q=gà" class="h-tag-pill">Thịt gà</a>
                        <a href="<?= BASE_URL ?>/index.php?q=bò" class="h-tag-pill">Thịt bò</a>
                        <a href="<?= BASE_URL ?>/index.php?q=sườn" class="h-tag-pill">Sườn non</a>
                        <a href="<?= BASE_URL ?>/index.php?q=canh" class="h-tag-pill">Món canh</a>
                        <a href="<?= BASE_URL ?>/index.php?q=nộm" class="h-tag-pill">Món nộm</a>
                        <a href="<?= BASE_URL ?>/index.php?q=cơm+chiên" class="h-tag-pill">Cơm chiên</a>
                        <a href="<?= BASE_URL ?>/index.php?cat=Món+kho" class="h-tag-pill">Món kho đưa cơm</a>
                    </div>
                </div>

                <!-- Live Results -->
                <div id="hLiveResultsWrap" class="h-live-results-wrap" style="display: none;">
                    <div class="h-results-header">
                        <span class="h-section-title">Kết quả gợi ý</span>
                        <span id="hResultsCount" class="h-results-badge">(0 món)</span>
                    </div>
                    <div id="hResultsGrid" class="h-results-grid"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function openCookioLogin(redirectPath = '') {
        const redirectInput = document.getElementById('loginRedirectTo');
        if (redirectInput) {
            redirectInput.value = redirectPath;
        }
        const modal = document.getElementById('loginModal');
        if (modal) {
            if (typeof modal.showModal === 'function') {
                modal.showModal();
            } else {
                modal.setAttribute('open', '');
            }
        }
    }

    function openLoginForCreateRecipe() {
        openCookioLogin('views/create-recipe.php');
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('[data-open-login]');
        if (btn) {
            e.preventDefault();
            const redirectTo = btn.getAttribute('data-redirect') || '';
            openCookioLogin(redirectTo);
        }
        const closeBtn = e.target.closest('[data-close-modal]');
        if (closeBtn) {
            e.preventDefault();
            const modal = document.getElementById('loginModal');
            if (modal) {
                if (typeof modal.close === 'function') {
                    modal.close();
                } else {
                    modal.removeAttribute('open');
                }
            }
        }
    });
    </script>
</header>
<main class="page-content">
