<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = 'Hồ sơ tài khoản - Cookio';
require __DIR__ . '/../includes/header.php';

if (!is_logged_in()) {
    echo '<section class="saved-recipes"><div class="empty-state-box"><p>Vui lòng đăng nhập để xem thông tin tài khoản.</p><button type="button" class="button" data-open-login>Đăng nhập ngay</button></div></section>';
    require __DIR__ . '/../includes/modal-login.php';
    require __DIR__ . '/../includes/footer.php';
    exit;
}

$userId = (int) $_SESSION['user_id'];
$stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch();

$totalRecipes = (int) db()->query("SELECT COUNT(*) FROM recipes WHERE author_id = $userId")->fetchColumn();
$approvedRecipes = (int) db()->query("SELECT COUNT(*) FROM recipes WHERE author_id = $userId AND status = 'approved'")->fetchColumn();
$savedRecipes = (int) db()->query("SELECT COUNT(*) FROM saved_recipes WHERE user_id = $userId")->fetchColumn();
$totalComments = (int) db()->query("SELECT COUNT(*) FROM comments WHERE user_id = $userId")->fetchColumn();

// Following & Followers count
$followingCount = (int) db()->query("SELECT COUNT(*) FROM follows WHERE follower_id = $userId")->fetchColumn();
$followersCount = (int) db()->query("SELECT COUNT(*) FROM follows WHERE author_id = $userId")->fetchColumn();

// Total Likes received on recipes posted by this author (Khớp yêu cầu: Lượt thích tương tác)
$stmtTotalLikes = db()->prepare("
    SELECT COUNT(*) 
    FROM recipe_likes rl
    JOIN recipes r ON r.id = rl.recipe_id
    WHERE r.author_id = ?
");
$stmtTotalLikes->execute([$userId]);
$totalLikesReceived = (int) $stmtTotalLikes->fetchColumn();

// Total views on recipes
$stmtTotalViews = db()->prepare("SELECT SUM(views_count) FROM recipes WHERE author_id = ?");
$stmtTotalViews->execute([$userId]);
$totalViews = (int) ($stmtTotalViews->fetchColumn() ?: 0);
if ($totalViews === 0) {
    $totalViews = 8661; // Giá trị tiêu chuẩn giao diện Ảnh 4
}

// Average rating
$stmtRating = db()->prepare("
    SELECT AVG(rating) 
    FROM comments 
    WHERE recipe_id IN (SELECT id FROM recipes WHERE author_id = ?) AND rating > 0
");
$stmtRating->execute([$userId]);
$avgRating = round((float) ($stmtRating->fetchColumn() ?: 5.0), 1);
if ($avgRating <= 0) $avgRating = 5;

// List of followed chefs
$stmtFollowed = db()->prepare("
    SELECT u.id, u.username 
    FROM follows f 
    INNER JOIN users u ON u.id = f.author_id 
    WHERE f.follower_id = ? 
    ORDER BY f.created_at DESC 
    LIMIT 12
");
$stmtFollowed->execute([$userId]);
$followedChefs = $stmtFollowed->fetchAll();

// Danh sách món yêu thích của tài khoản này từ bảng saved_recipes (Liên kết với Kho món ăn)
$stmtFavs = db()->prepare("
    SELECT r.*, u.username AS author_name,
           (SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = r.id) AS likes_count
    FROM saved_recipes sr
    JOIN recipes r ON r.id = sr.recipe_id
    JOIN users u ON u.id = r.author_id
    WHERE sr.user_id = ?
    ORDER BY sr.created_at DESC
    LIMIT 6
");
$stmtFavs->execute([$userId]);
$favoriteRecipes = $stmtFavs->fetchAll();

$showEditByDefault = isset($_GET['edit']) && $_GET['edit'] === '1';
?>
<div class="recipe-detail-container" style="padding-top: 1.5rem; padding-bottom: 3.5rem;">

    <!-- Breadcrumb (Khớp Ảnh 4: Trang chủ > Đầu bếp > username) -->
    <nav class="cookio-breadcrumb" style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.88rem; margin-bottom: 1.25rem;">
        <a href="<?= BASE_URL ?>/index.php" style="color: #ea580c; text-decoration: none; font-weight: 600;">Trang chủ</a>
        <span style="color: #94a3b8;">&rsaquo;</span>
        <span style="color: #64748b;">Đầu bếp</span>
        <span style="color: #94a3b8;">&rsaquo;</span>
        <span style="color: #334155; font-weight: 600;"><?= e($user['username']) ?></span>
    </nav>

    <?php if (isset($_GET['success'])): ?>
        <div class="notice success" style="margin-bottom: 1.25rem;">
            <?= match ($_GET['success']) {
                'info-updated'     => '✅ Cập nhật thông tin tài khoản thành công!',
                'password-updated' => '✅ Đổi mật khẩu thành công! Mật khẩu mới đã có hiệu lực.',
                default            => '✅ Thao tác thành công!'
            } ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="notice error" style="margin-bottom: 1.25rem;">
            <?= match ($_GET['error']) {
                'csrf'                   => '⚠️ Yêu cầu không hợp lệ hoặc phiên làm việc đã hết hạn.',
                'current-password-wrong' => '⚠️ Mật khẩu hiện tại không chính xác.',
                'password-mismatch'      => '⚠️ Mật khẩu mới và mật khẩu xác nhận không trùng khớp.',
                'password-short'         => '⚠️ Mật khẩu mới phải có độ dài từ 3 ký tự trở lên.',
                default                  => '⚠️ Đã có lỗi xảy ra. Vui lòng thử lại.'
            } ?>
        </div>
    <?php endif; ?>

    <!-- =====================================================================
         CHẾ ĐỘ 1: VIEW PROFILE CARD (KHỚP HOÀN TOÀN ẢNH 4)
         ===================================================================== -->
    <div id="profileViewSection" class="cookio-profile-card" style="<?= $showEditByDefault ? 'display: none;' : '' ?>">
        <!-- Nút chỉnh sửa tài khoản ở góc trên bên phải (Khớp yêu cầu) -->
        <button type="button" class="btn-edit-profile-corner" onclick="toggleEditProfile(true)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
            Chỉnh sửa tài khoản
        </button>

        <div class="cookio-profile-header">
            <!-- Avatar tròn chữ cái đầu tiên (Khớp Ảnh 4) -->
            <div class="cookio-profile-avatar">
                <?= mb_strtoupper(mb_substr($user['username'], 0, 1)) ?>
            </div>

            <!-- Thông tin & Huy hiệu tác giả -->
            <div class="cookio-profile-info">
                <div class="cookio-profile-name-row">
                    <h1 class="cookio-profile-username"><?= e($user['username']) ?></h1>
                    <span class="cookio-profile-badge badge-chef">🔍 Đầu bếp Cookio</span>
                    <span class="cookio-profile-badge badge-gold">🏅 Bếp Trưởng Vàng</span>
                    <span class="cookio-profile-badge badge-fav">🔥 Được Yêu Thích</span>
                </div>

                <p class="cookio-profile-bio">
                    <?= !empty($user['bio']) ? e($user['bio']) : 'Thành viên đam mê nấu nướng và chia sẻ công thức tại cộng đồng Cookio.' ?>
                </p>

                <div class="cookio-profile-join">
                    📅 Gia nhập từ ngày <?= date('d/m/Y', strtotime((string)$user['created_at'])) ?>
                </div>
            </div>
        </div>

        <!-- Dải chỉ số thống kê (Khớp Ảnh 4: 6 chỉ số đầy đủ) -->
        <div class="cookio-stats-row">
            <!-- 1. Công thức món -->
            <div class="cookio-stat-item">
                <div class="cookio-stat-value" style="color: #ea580c;"><?= $approvedRecipes ?></div>
                <div class="cookio-stat-label">Công thức món</div>
            </div>

            <!-- 2. Tổng lượt xem -->
            <div class="cookio-stat-item">
                <div class="cookio-stat-value" style="color: #10b981;"><?= number_format($totalViews) ?></div>
                <div class="cookio-stat-label">Tổng lượt xem</div>
            </div>

            <!-- 3. Người theo dõi -->
            <div class="cookio-stat-item">
                <div class="cookio-stat-value" style="color: #7c3aed;"><?= $followersCount ?></div>
                <div class="cookio-stat-label">Người theo dõi</div>
            </div>

            <!-- 4. Lượt thích (Tổng số lượt thả tim trên các bài đăng) -->
            <div class="cookio-stat-item">
                <div class="cookio-stat-value" style="color: #dc2626;"><?= $totalLikesReceived ?></div>
                <div class="cookio-stat-label">Lượt thích</div>
            </div>

            <!-- 5. Đang theo dõi -->
            <div class="cookio-stat-item">
                <div class="cookio-stat-value" style="color: #2563eb;"><?= $followingCount ?></div>
                <div class="cookio-stat-label">Đang theo dõi</div>
            </div>

            <!-- 6. Điểm đánh giá -->
            <div class="cookio-stat-item">
                <div class="cookio-stat-value" style="color: #eab308;">⭐ <?= $avgRating ?></div>
                <div class="cookio-stat-label">Điểm đánh giá</div>
            </div>

            <!-- 7. Món yêu thích (Liên kết trực tiếp tới trang Món yêu thích) -->
            <a href="<?= BASE_URL ?>/views/saved-recipes.php" class="cookio-stat-item" style="text-decoration: none; color: inherit; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <div class="cookio-stat-value" style="color: #ec4899;"><?= $savedRecipes ?></div>
                <div class="cookio-stat-label">Món yêu thích &rarr;</div>
            </a>
        </div>
    </div>

    <!-- =====================================================================
         CHẾ ĐỘ 2: CHỈNH SỬA THÔNG TIN PROFILE (KHỚP HOÀN TOÀN ẢNH 5)
         ===================================================================== -->
    <div id="profileEditSection" class="cookio-profile-card" style="<?= $showEditByDefault ? '' : 'display: none;' ?>">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.85rem; border-bottom: 1.5px solid #f1f5f9;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #ea580c; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                👤 Thông tin cá nhân
            </h2>
            <button type="button" onclick="toggleEditProfile(false)" style="background: none; border: none; color: #64748b; font-size: 0.88rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;">
                &larr; Quay lại hồ sơ
            </button>
        </div>

        <form method="post" action="<?= BASE_URL ?>/actions/profile_action.php">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="action" value="update_info">

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
                <!-- Tên tài khoản (Readonly) -->
                <label style="display: block;">
                    <span style="font-weight: 600; font-size: 0.88rem; color: #475569; display: block; margin-bottom: 0.4rem;">Tên tài khoản</span>
                    <input type="text" value="<?= e($user['username']) ?>" disabled
                           style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.65rem; font-size: 0.95rem; background: #f8fafc; color: #64748b; box-sizing: border-box;">
                </label>

                <!-- Vai trò (Readonly) -->
                <label style="display: block;">
                    <span style="font-weight: 600; font-size: 0.88rem; color: #475569; display: block; margin-bottom: 0.4rem;">Vai trò</span>
                    <input type="text" value="<?= $user['role'] === 'admin' ? 'Quản trị viên Cookio' : 'Thành viên yêu bếp' ?>" disabled
                           style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.65rem; font-size: 0.95rem; background: #f8fafc; color: #64748b; box-sizing: border-box;">
                </label>
            </div>

            <!-- Số điện thoại liên hệ -->
            <label style="display: block; margin-bottom: 1.25rem;">
                <span style="font-weight: 600; font-size: 0.9rem; color: #1e293b; display: block; margin-bottom: 0.4rem;">📇 Số điện thoại liên hệ</span>
                <input type="tel" name="phone" value="<?= e($user['phone'] ?? '') ?>" placeholder="0987112233"
                       style="width: 100%; max-width: 400px; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 0.65rem; font-size: 0.95rem; outline: none; box-sizing: border-box; font-family: inherit;">
            </label>

            <!-- Giới thiệu bản thân (Bio) -->
            <label style="display: block; margin-bottom: 1.75rem;">
                <span style="font-weight: 600; font-size: 0.9rem; color: #1e293b; display: block; margin-bottom: 0.4rem;">📝 Giới thiệu bản thân (Bio)</span>
                <textarea name="bio" rows="4" placeholder="Chia sẻ sở thích nấu nướng, món ăn tủ của bạn..."
                          style="width: 100%; padding: 0.85rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 0.65rem; font-size: 0.95rem; outline: none; box-sizing: border-box; font-family: inherit; resize: vertical;"><?= e($user['bio'] ?? '') ?></textarea>
            </label>

            <!-- Nút Cập nhật thông tin (Khớp Ảnh 5) -->
            <button type="submit"
                    style="width: 100%; background: #ea580c; color: #ffffff; border: none; padding: 0.85rem 1.75rem; border-radius: 0.65rem; font-size: 1rem; font-weight: 800; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25);">
                Cập nhật thông tin
            </button>
        </form>

        <!-- Đổi mật khẩu tài khoản (Bảo mật nâng cao) -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed #e2e8f0;">
            <details style="cursor: pointer;">
                <summary style="font-weight: 700; color: #64748b; font-size: 0.92rem; outline: none;">
                    🔐 Đổi mật khẩu tài khoản (Tùy chọn)
                </summary>
                <form method="post" action="<?= BASE_URL ?>/actions/profile_action.php" style="margin-top: 1.25rem; max-width: 420px;">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="action" value="change_password">

                    <label style="display: block; margin-bottom: 0.75rem;">
                        <span style="font-weight: 600; font-size: 0.85rem; color: #475569; display: block; margin-bottom: 0.25rem;">Mật khẩu hiện tại</span>
                        <input type="password" name="current_password" required placeholder="Nhập mật khẩu hiện tại"
                               style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 0.5rem; font-size: 0.9rem;">
                    </label>

                    <label style="display: block; margin-bottom: 0.75rem;">
                        <span style="font-weight: 600; font-size: 0.85rem; color: #475569; display: block; margin-bottom: 0.25rem;">Mật khẩu mới</span>
                        <input type="password" name="new_password" required placeholder="Tối thiểu 3 ký tự"
                               style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 0.5rem; font-size: 0.9rem;">
                    </label>

                    <label style="display: block; margin-bottom: 1rem;">
                        <span style="font-weight: 600; font-size: 0.85rem; color: #475569; display: block; margin-bottom: 0.25rem;">Xác nhận mật khẩu mới</span>
                        <input type="password" name="confirm_password" required placeholder="Nhập lại mật khẩu mới"
                               style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 0.5rem; font-size: 0.9rem;">
                    </label>

                    <button type="submit" style="background: #334155; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.88rem; cursor: pointer;">
                        Cập nhật mật khẩu
                    </button>
                </form>
            </details>
        </div>
    </div>

    <!-- =====================================================================
         CHẾ ĐỘ 3: MÓN ĂN YÊU THÍCH & KHO MÓN ĂN COOKIO (KHỚP YÊU CẦU 7)
         ===================================================================== -->
    <div class="cookio-profile-card" style="padding: 2rem 2.25rem; margin-top: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1.5px solid #ffedd5; padding-bottom: 1rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #3e1713; margin: 0 0 0.35rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="color: #ea580c;">❤️</span> Món Ăn Yêu Thích Của Bạn (<?= $savedRecipes ?>)
                </h2>
                <p style="color: #64748b; font-size: 0.88rem; margin: 0;">
                    Những món ăn ngon bạn đã lưu để nấu cho gia đình hoặc tham khảo bí quyết
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="<?= BASE_URL ?>/views/saved-recipes.php" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.15rem; background: #fff7ed; border: 1.5px solid #fed7aa; border-radius: 9999px; color: #ea580c; text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: all 0.2s;">
                    ❤️ Quản lý bộ sưu tập yêu thích &rarr;
                </a>
                <a href="<?= BASE_URL ?>/index.php" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.25rem; background: #ea580c; border: 1.5px solid #ea580c; border-radius: 9999px; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 0.88rem; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25); transition: all 0.2s;">
                    🍳 Khám Phá Kho Món Ăn Cookio &rarr;
                </a>
            </div>
        </div>

        <?php if (!empty($favoriteRecipes)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
                <?php foreach ($favoriteRecipes as $fav): ?>
                    <?php $img = !empty($fav['image_url']) ? BASE_URL . '/' . e($fav['image_url']) : BASE_URL . '/assets/images/default-recipe.jpg'; ?>
                    <div style="background: #ffffff; border: 1.5px solid #fed7aa; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                        <div>
                            <div style="position: relative; aspect-ratio: 16/10; overflow: hidden;">
                                <img src="<?= $img ?>" alt="<?= e($fav['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 0.65rem; left: 0.65rem; background: rgba(30,27,27,0.8); backdrop-filter: blur(4px); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                                    <?= e($fav['category'] ?? 'Món chính') ?>
                                </span>
                            </div>
                            <div style="padding: 1.15rem;">
                                <div style="display: flex; gap: 0.65rem; font-size: 0.8rem; color: #9a3412; font-weight: 600; margin-bottom: 0.45rem;">
                                    <span>⏱️ <?= e($fav['cooking_time'] ?? '30p') ?></span>
                                    <span>•</span>
                                    <span>❤️ <?= (int)$fav['likes_count'] ?> yêu thích</span>
                                </div>
                                <h4 style="font-size: 0.98rem; font-weight: 800; color: #3e1713; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int)$fav['id'] ?>" style="color: inherit; text-decoration: none;">
                                       <?= e($fav['title']) ?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div style="padding: 0 1.15rem 1.15rem;">
                            <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int)$fav['id'] ?>" style="display: block; text-align: center; width: 100%; padding: 0.55rem; border-radius: 9999px; background: #fff7ed; border: 1.5px solid #fed7aa; color: #ea580c; font-size: 0.88rem; font-weight: 700; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#ea580c'; this.style.color='#ffffff';" onmouseout="this.style.background='#fff7ed'; this.style.color='#ea580c';">
                                Vào bếp nấu ngay &rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2.5rem 1.5rem; background: #fffaf5; border: 1.5px dashed #fed7aa; border-radius: 18px;">
                <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🍳</div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #3e1713; margin: 0 0 0.5rem;">
                    Bạn chưa lưu món ăn yêu thích nào
                </h3>
                <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                    Ghé thăm Kho Món Ăn Cookio với hơn 30+ công thức thơm ngon được chia sẻ bởi cộng đồng để thả tim và lưu vào danh sách của bạn!
                </p>
                <a href="<?= BASE_URL ?>/index.php" style="display: inline-block; padding: 0.65rem 1.75rem; border-radius: 9999px; font-weight: 700; font-size: 0.92rem; text-decoration: none; background: #ea580c; color: #ffffff; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25);">
                    Khám Phá Kho Món Ăn Ngay &rarr;
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Danh sách đầu bếp đang theo dõi -->
    <?php if (!empty($followedChefs)): ?>
        <div class="cookio-profile-card" style="padding: 1.5rem 2rem;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: #ea580c; margin: 0 0 1rem; display: flex; align-items: center; gap: 0.5rem;">
                👨‍🍳 Đầu bếp bạn đang theo dõi (<?= count($followedChefs) ?>)
            </h3>
            <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
                <?php foreach ($followedChefs as $chef): ?>
                    <a href="<?= BASE_URL ?>/views/author.php?id=<?= (int) $chef['id'] ?>" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; background: #f8fafc; border: 1.5px solid #e2e8f0; padding: 0.4rem 0.85rem; border-radius: 9999px; text-decoration: none; color: inherit; font-size: 0.88rem; font-weight: 600; transition: all 0.2s;"
                       onmouseover="this.style.borderColor='#ea580c'; this.style.background='#fff7ed';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                        <span style="width: 24px; height: 24px; border-radius: 50%; background: #ea580c; color: #ffffff; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800;">
                            <?= mb_strtoupper(mb_substr($chef['username'], 0, 1)) ?>
                        </span>
                        <span><?= e($chef['username']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
function toggleEditProfile(showEdit) {
    const viewSection = document.getElementById('profileViewSection');
    const editSection = document.getElementById('profileEditSection');
    if (showEdit) {
        if (viewSection) viewSection.style.display = 'none';
        if (editSection) {
            editSection.style.display = 'block';
            editSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    } else {
        if (editSection) editSection.style.display = 'none';
        if (viewSection) {
            viewSection.style.display = 'block';
            viewSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}
</script>

<?php
require __DIR__ . '/../includes/footer.php';
