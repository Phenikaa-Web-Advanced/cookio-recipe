<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

$recipes = [];
$categories = [];
$allIngredientsText = '';
$selectedCat = trim((string) ($_GET['cat'] ?? ''));
$allSystemRecipes = [];
$favoriteIds = [];

if (is_logged_in()) {
    $uid = (int) $_SESSION['user_id'];
    
    // Fetch all categories for filter tabs (bao gồm cả món đã lưu và món đã thả tim)
    $stmtCats = db()->prepare("
        SELECT DISTINCT r.category 
        FROM recipes r 
        LEFT JOIN saved_recipes s ON s.recipe_id = r.id AND s.user_id = ?
        LEFT JOIN recipe_likes rl ON rl.recipe_id = r.id AND rl.user_id = ?
        WHERE (s.user_id = ? OR rl.user_id = ?) AND r.status = 'approved' AND r.category IS NOT NULL AND r.category != ''
        ORDER BY r.category ASC
    ");
    $stmtCats->execute([$uid, $uid, $uid, $uid]);
    $categories = $stmtCats->fetchAll(PDO::FETCH_COLUMN);

    $sql = "
        SELECT DISTINCT r.*, u.username AS author_name, COALESCE(s.note, '') AS personal_note,
               COALESCE(s.created_at, rl.created_at) AS saved_at,
               COALESCE((SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = r.id), r.likes_count, 0) AS likes_count,
               (SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = r.id AND user_id = ?) AS is_liked
        FROM recipes r 
        INNER JOIN users u ON u.id = r.author_id 
        LEFT JOIN saved_recipes s ON s.recipe_id = r.id AND s.user_id = ?
        LEFT JOIN recipe_likes rl ON rl.recipe_id = r.id AND rl.user_id = ?
        WHERE (s.user_id = ? OR rl.user_id = ?) AND r.status = 'approved'
    ";
    $params = [$uid, $uid, $uid, $uid, $uid];

    if ($selectedCat !== '') {
        $sql .= " AND r.category = ?";
        $params[] = $selectedCat;
    }

    $sql .= " ORDER BY saved_at DESC";

    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll();

    $favoriteIds = array_map(fn($r) => (int)$r['id'], $recipes);
    $allSystemRecipes = db()->query("
        SELECT id, title, category, image_url, cooking_time 
        FROM recipes 
        WHERE status = 'approved' 
        ORDER BY title ASC
    ")->fetchAll();
}

$pageTitle = 'Món Yêu Thích - Cookio';
require __DIR__ . '/../includes/header.php';
?>

<div class="saved-page-wrapper" style="max-width: 1100px; margin: 0 auto; padding: 2rem 1rem 4.5rem;">

    <!-- Breadcrumb -->
    <nav class="cookio-breadcrumb" style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.88rem; margin-bottom: 1.5rem;">
        <a href="<?= BASE_URL ?>/index.php" style="color: #ea580c; text-decoration: none; font-weight: 600;">Trang chủ</a>
        <span style="color: #cbd5e1;">&rsaquo;</span>
        <span style="color: #64748b; font-weight: 600;">Món yêu thích</span>
    </nav>

    <!-- Header Box cùng tông màu ấm áp của Cookio -->
    <div class="saved-header-card" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; background: linear-gradient(180deg, #fffaf5 0%, #ffffff 100%); border: 1.5px solid #fed7aa; border-radius: 24px; padding: 2.25rem 2.5rem; box-shadow: 0 6px 24px rgba(234, 88, 12, 0.05); margin-bottom: 2rem;">
        <div style="max-width: 600px;">
            <span style="display: inline-block; background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; padding: 0.35rem 0.95rem; border-radius: 9999px; font-weight: 800; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.85rem;">
                BỘ SƯU TẬP BẾP RIÊNG BẠN
            </span>
            <h1 style="font-size: 2.15rem; font-weight: 800; color: #3e1713; margin: 0 0 0.5rem; letter-spacing: -0.02em;">
                Món Ăn Yêu Thích & Ghi Chú
            </h1>
            <p style="margin: 0; color: #64748b; font-size: 0.98rem; line-height: 1.6;">
                Không gian lưu giữ những công thức tâm đắc, hỗ trợ ghi chú bí quyết gia giảm gia vị riêng và kết nối trực tiếp với kho món ăn Cookio.
            </p>
        </div>

        <?php if (is_logged_in()): ?>
            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <span style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.65rem 1.35rem; background: #fff1f2; border: 1.5px solid #fecdd3; border-radius: 9999px; color: #e11d48; font-weight: 800; font-size: 0.92rem; box-shadow: 0 2px 10px rgba(225, 29, 72, 0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#e11d48" stroke="#e11d48" stroke-width="1.5">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span><?= count($recipes) ?> Món Yêu Thích</span>
                </span>
                <button type="button" onclick="document.getElementById('modalAddFavorite').style.display='flex'" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.65rem 1.35rem; background: #ea580c; border: none; border-radius: 9999px; color: #ffffff; font-weight: 700; font-size: 0.92rem; cursor: pointer; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25); transition: background 0.2s;" onmouseover="this.style.background='#c2410c';" onmouseout="this.style.background='#ea580c';">
                    + Thêm món vào yêu thích
                </button>
                <a href="<?= BASE_URL ?>/index.php" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.65rem 1.35rem; background: #fffaf5; border: 1.5px solid #fed7aa; border-radius: 9999px; color: #ea580c; text-decoration: none; font-weight: 700; font-size: 0.92rem; transition: all 0.2s;" onmouseover="this.style.background='#fff7ed';" onmouseout="this.style.background='#fffaf5';">
                    Khám phá thêm &rarr;
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['bookmark'])): ?>
        <div class="notice success" style="background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46; border-radius: 14px; padding: 0.85rem 1.25rem; font-weight: 600; margin-bottom: 1.75rem;">
            <?= match ($_GET['bookmark']) {
                'saved' => 'Đã thêm món vào danh sách yêu thích thành công! ❤️',
                'unsaved' => 'Đã xóa món khỏi danh sách yêu thích thành công.',
                'note_saved' => 'Đã lưu ghi chú nhà bếp thành công.',
                default => 'Đã cập nhật danh sách món yêu thích.'
            } ?>
        </div>
    <?php endif; ?>

    <?php if (!is_logged_in()): ?>
        <!-- Trạng thái khi khách chưa đăng nhập -->
        <div class="saved-guest-card" style="text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: 24px; border: 1.5px solid #fed7aa; box-shadow: 0 8px 30px rgba(0,0,0,0.04);">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #fff7ed; margin: 0 auto 1.25rem; display: flex; align-items: center; justify-content: center; border: 1.5px solid #fed7aa;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
            </div>
            <h2 style="font-size: 1.45rem; font-weight: 800; color: #3e1713; margin: 0 0 0.5rem;">
                Đăng nhập để xem bộ sưu tập yêu thích
            </h2>
            <p style="color: #64748b; font-size: 0.98rem; max-width: 480px; margin: 0 auto 1.75rem; line-height: 1.55;">
                Đăng nhập tài khoản Cookio để đồng bộ các món ăn bạn đã thả tim, quản lý ghi chú bí quyết riêng và khám phá công thức yêu thích.
            </p>
            <button type="button" data-open-login style="background: #ea580c; color: #ffffff; border: none; padding: 0.8rem 2.2rem; border-radius: 9999px; font-weight: 700; font-size: 0.95rem; cursor: pointer; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25);">
                Đăng nhập ngay
            </button>
        </div>

    <?php elseif (empty($recipes) && $selectedCat === ''): ?>
        <!-- Trạng thái trống khi chưa có món yêu thích -->
        <div class="saved-empty-card" style="text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: 24px; border: 2px dashed #fed7aa;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #fff7ed; margin: 0 auto 1.25rem; display: flex; align-items: center; justify-content: center; border: 1.5px solid #fed7aa;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <h2 style="font-size: 1.45rem; font-weight: 800; color: #3e1713; margin: 0 0 0.5rem;">
                Danh sách món yêu thích đang trống
            </h2>
            <p style="color: #64748b; font-size: 0.98rem; max-width: 480px; margin: 0 auto 1.75rem; line-height: 1.55;">
                Bạn chưa lưu hoặc thả tim món ăn nào. Hãy dạo quanh kho tàng ẩm thực Cookio để khám phá và thêm món vào gian bếp nhé!
            </p>
            <a href="<?= BASE_URL ?>/index.php" style="display: inline-block; background: #ea580c; color: #ffffff; padding: 0.8rem 2.2rem; border-radius: 9999px; font-weight: 700; font-size: 0.95rem; text-decoration: none; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25);">
                Khám phá món ngon ngay
            </a>
        </div>

    <?php else: ?>

        <!-- Dải lọc chuyên mục dạng viên thuốc bo tròn cùng tone -->
        <?php if (!empty($categories)): ?>
            <div class="saved-cat-tabs" style="display: flex; gap: 0.65rem; margin-bottom: 1.75rem; overflow-x: auto; padding-bottom: 0.5rem;">
                <a href="<?= BASE_URL ?>/views/saved-recipes.php" 
                   style="padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.9rem; font-weight: 700; text-decoration: none; transition: all 0.2s; white-space: nowrap; <?= $selectedCat === '' ? 'background: #ea580c; color: #ffffff; box-shadow: 0 3px 10px rgba(234, 88, 12, 0.25);' : 'background: #fffaf5; color: #4a1c17; border: 1.5px solid #fed7aa;' ?>">
                    Tất cả (<?= count($recipes) ?>)
                </a>
                <?php foreach ($categories as $catName): ?>
                    <a href="<?= BASE_URL ?>/views/saved-recipes.php?cat=<?= urlencode($catName) ?>" 
                       style="padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.9rem; font-weight: 700; text-decoration: none; transition: all 0.2s; white-space: nowrap; <?= $selectedCat === $catName ? 'background: #ea580c; color: #ffffff; box-shadow: 0 3px 10px rgba(234, 88, 12, 0.25);' : 'background: #fffaf5; color: #4a1c17; border: 1.5px solid #fed7aa;' ?>">
                        <?= e($catName) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Lưới món ăn yêu thích -->
        <div class="recipe-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.75rem;">
            <?php foreach ($recipes as $recipe): ?>
                <?php 
                $imgSrc = !empty($recipe['image_url']) ? BASE_URL . '/' . e($recipe['image_url']) : BASE_URL . '/assets/images/default-recipe.jpg';
                $hasNote = !empty($recipe['personal_note']);
                ?>
                <article class="saved-recipe-card" style="background: #ffffff; border: 1.5px solid #fed7aa; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 18px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.25s, box-shadow 0.25s;">
                    <div>
                        <!-- Ảnh món & Nút bỏ lưu tinh tế -->
                        <div style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background: #fdfbf7;">
                            <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int) $recipe['id'] ?>">
                                <img src="<?= $imgSrc ?>" alt="<?= e($recipe['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s ease;" loading="lazy">
                            </a>
                            
                            <?php if (!empty($recipe['category'])): ?>
                                <span style="position: absolute; top: 0.75rem; left: 0.75rem; background: rgba(30, 27, 27, 0.8); backdrop-filter: blur(4px); color: #ffffff; font-size: 0.75rem; font-weight: 700; padding: 0.3rem 0.75rem; border-radius: 9999px;">
                                    <?= e($recipe['category']) ?>
                                </span>
                            <?php endif; ?>

                            <!-- Nút gỡ món khỏi danh sách với biểu tượng trái tim tinh tế -->
                            <form method="post" action="<?= BASE_URL ?>/actions/saved_action.php" style="position: absolute; top: 0.65rem; right: 0.65rem; z-index: 2;">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="recipe_id" value="<?= (int) $recipe['id'] ?>">
                                <input type="hidden" name="return_url" value="views/saved-recipes.php<?= $selectedCat !== '' ? '?cat=' . urlencode($selectedCat) : '' ?>">
                                <button type="submit" title="Xóa món này khỏi yêu thích"
                                    onclick="return confirm('Xóa món «<?= e(addslashes($recipe['title'])) ?>» khỏi bộ sưu tập yêu thích?')"
                                    style="width: 36px; height: 36px; border-radius: 50%; background: #ffffff; border: 1.5px solid #fed7aa; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; line-height: 1; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.12); transition: all 0.2s;"
                                    onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                    ❤️
                                </button>
                            </form>
                        </div>

                        <!-- Thân card -->
                        <div style="padding: 1.25rem;">
                            <!-- Tác giả, Thời gian & Dữ liệu lượt yêu thích (Tym) -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; font-size: 0.82rem; color: #9a3412; font-weight: 600;">
                                <div style="display: flex; align-items: center; gap: 0.4rem;">
                                    <span style="width: 22px; height: 22px; border-radius: 50%; background: #ea580c; color: #ffffff; font-size: 0.72rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center;">
                                        <?= mb_strtoupper(mb_substr($recipe['author_name'], 0, 1)) ?>
                                    </span>
                                    <a href="<?= BASE_URL ?>/views/author.php?id=<?= (int)$recipe['author_id'] ?>" style="color: inherit; text-decoration: none; font-weight: 700;" onmouseover="this.style.color='#ea580c';" onmouseout="this.style.color='inherit';">
                                        <?= e($recipe['author_name']) ?>
                                    </a>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem;">
                                    <?php if (!empty($recipe['cooking_time'])): ?>
                                        <span>⏱️ <?= e($recipe['cooking_time']) ?></span>
                                        <span>•</span>
                                    <?php endif; ?>
                                    <span style="color: #e11d48; font-weight: 700; display: inline-flex; align-items: center; gap: 0.2rem;">
                                        ❤️ <?= (int)$recipe['likes_count'] ?>
                                    </span>
                                </div>
                            </div>

                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #3e1713; margin: 0 0 0.75rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int) $recipe['id'] ?>" style="color: inherit; text-decoration: none;" onmouseover="this.style.color='#ea580c';" onmouseout="this.style.color='#3e1713';">
                                    <?= e($recipe['title']) ?>
                                </a>
                            </h3>

                            <!-- Hộp ghi chú bếp cá nhân chuyên nghiệp -->
                            <div class="personal-note-box" id="personal-note-box-<?= (int) $recipe['id'] ?>" style="background: #fffaf5; border: 1.5px solid #fed7aa; border-radius: 12px; padding: 0.85rem; margin-bottom: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem; font-size: 0.8rem; font-weight: 700; color: #7c2d12;">
                                    <span>Ghi chú riêng của bạn</span>
                                    <?php if ($hasNote): ?>
                                        <span style="font-size: 0.72rem; color: #059669; font-weight: 700;">Đã lưu</span>
                                    <?php endif; ?>
                                </div>
                                <textarea class="personal-note-textarea" placeholder="Thêm lưu ý riêng (vd: giảm cay, nấu 15p, thêm tiêu...)" style="width: 100%; border: 1px solid #fed7aa; border-radius: 8px; padding: 0.45rem 0.65rem; font-size: 0.84rem; outline: none; background: #ffffff; resize: vertical; min-height: 52px; font-family: inherit; box-sizing: border-box;"><?= e($recipe['personal_note'] ?? '') ?></textarea>
                                <div style="display: flex; justify-content: flex-end; margin-top: 0.4rem;">
                                    <button type="button" class="personal-note-save-btn" onclick="saveRecipeNote(<?= (int) $recipe['id'] ?>, this)" style="background: #ea580c; color: #ffffff; border: none; padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.78rem; font-weight: 700; cursor: pointer; transition: background 0.2s;">
                                        Lưu ghi chú
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thanh nút bấm chân card: Nút Vào bếp nấu và Nút Tym yêu thích (Đã xóa mục gom nguyên liệu theo đúng yêu cầu) -->
                    <div style="padding: 0 1.25rem 1.25rem; display: flex; gap: 0.65rem; align-items: center;">
                        <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int) $recipe['id'] ?>" style="flex: 1.3; font-size: 0.88rem; padding: 0.65rem 0.85rem; text-decoration: none; text-align: center; font-weight: 700; background: #ea580c; color: #ffffff; border-radius: 9999px; transition: background 0.2s; box-shadow: 0 3px 10px rgba(234, 88, 12, 0.25); white-space: nowrap;" onmouseover="this.style.background='#c2410c';" onmouseout="this.style.background='#ea580c';">
                            Vào bếp nấu &rarr;
                        </a>
                        <form method="post" action="<?= BASE_URL ?>/actions/like_action.php" style="flex: 1.1; margin: 0;">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="recipe_id" value="<?= (int) $recipe['id'] ?>">
                            <input type="hidden" name="return_url" value="views/saved-recipes.php<?= $selectedCat !== '' ? '?cat=' . urlencode($selectedCat) : '' ?>">
                            <button type="submit" title="Thả tim hoặc bỏ thích món này" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; padding: 0.65rem 0.75rem; font-size: 0.86rem; font-weight: 700; background: #fff1f2; color: #e11d48; border: 1.5px solid #fecdd3; border-radius: 9999px; cursor: pointer; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#ffe4e6'; this.style.borderColor='#f43f5e'; this.style.transform='scale(1.02)';" onmouseout="this.style.background='#fff1f2'; this.style.borderColor='#fecdd3'; this.style.transform='none';">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#e11d48" stroke="#e11d48" stroke-width="1.5">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                <span>❤️ <?= (int)$recipe['likes_count'] ?> Tym</span>
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<!-- CSS cho chế độ Ban đêm (Dark Mode) hoàn hảo -->
<style>
[data-theme="dark"] .saved-header-card,
[data-theme="dark"] .saved-recipe-card,
[data-theme="dark"] .saved-guest-card,
[data-theme="dark"] .saved-empty-card {
    background: #131b2e !important;
    border-color: #253556 !important;
}
[data-theme="dark"] .saved-header-card h1,
[data-theme="dark"] .saved-recipe-card h3 a,
[data-theme="dark"] .saved-guest-card h2,
[data-theme="dark"] .saved-empty-card h2 {
    color: #f8fafc !important;
}
[data-theme="dark"] .personal-note-box {
    background: #1e293b !important;
    border-color: #334155 !important;
}
[data-theme="dark"] .personal-note-textarea {
    background: #0f172a !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}
[data-theme="dark"] .saved-cat-tabs a {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #cbd5e1 !important;
}
[data-theme="dark"] .saved-recipe-card form button {
    background: #1e293b !important;
    border-color: #881337 !important;
    color: #fb7185 !important;
}
[data-theme="dark"] .saved-recipe-card form button:hover {
    background: #2d1525 !important;
    border-color: #f43f5e !important;
}
</style>

<!-- Modal thêm món ăn vào mục yêu thích -->
<div id="modalAddFavorite" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 999999; align-items: center; justify-content: center; padding: 1.5rem;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background: #ffffff; border-radius: 24px; max-width: 600px; width: 100%; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.2); border: 1.5px solid #fed7aa;" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.75rem; border-bottom: 1.5px solid #ffedd5; background: #fffaf5;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.35rem;">❤️</span>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #3e1713;">Thêm Món Vào Mục Yêu Thích</h3>
            </div>
            <button type="button" onclick="document.getElementById('modalAddFavorite').style.display='none'" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: #64748b;">&times;</button>
        </div>
        <div style="padding: 1rem 1.75rem; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
            <input type="text" id="favSearchInput" placeholder="Tìm kiếm món ăn cần thêm (vd: bò, gà, sườn...)..." oninput="filterFavModalList(this.value)" style="width: 100%; padding: 0.65rem 1.2rem; border-radius: 9999px; border: 1.5px solid #fed7aa; font-size: 0.92rem; outline: none; background: #fffaf5;">
        </div>
        <div id="favModalList" style="flex: 1; overflow-y: auto; padding: 1rem 1.75rem; display: flex; flex-direction: column; gap: 0.75rem; max-height: 50vh;">
            <?php if (!empty($allSystemRecipes)): ?>
                <?php foreach ($allSystemRecipes as $sysR): ?>
                    <?php 
                    $isFav = in_array((int)$sysR['id'], $favoriteIds, true);
                    $sysImg = !empty($sysR['image_url']) ? BASE_URL . '/' . e($sysR['image_url']) : BASE_URL . '/assets/images/default-recipe.jpg';
                    ?>
                    <div class="fav-modal-item" data-title="<?= e(mb_strtolower($sysR['title'])) ?>" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.65rem 0.85rem; border: 1px solid #ffedd5; border-radius: 14px; background: #ffffff;">
                        <div style="display: flex; align-items: center; gap: 0.85rem; flex: 1; min-width: 0;">
                            <img src="<?= $sysImg ?>" alt="<?= e($sysR['title']) ?>" style="width: 48px; height: 48px; border-radius: 10px; object-fit: cover; flex-shrink: 0;" loading="lazy">
                            <div style="min-width: 0;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 0.92rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= e($sysR['title']) ?></div>
                                <div style="font-size: 0.78rem; color: #94a3b8;"><?= e($sysR['category'] ?? 'Món ngon') ?> • <?= e($sysR['cooking_time'] ?? '30p') ?></div>
                            </div>
                        </div>
                        <form method="post" action="<?= BASE_URL ?>/actions/saved_action.php" style="margin: 0; flex-shrink: 0;">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="recipe_id" value="<?= (int)$sysR['id'] ?>">
                            <input type="hidden" name="return_url" value="views/saved-recipes.php">
                            <?php if ($isFav): ?>
                                <button type="submit" title="Bấm để xóa khỏi yêu thích" style="padding: 0.4rem 0.85rem; border-radius: 9999px; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; font-size: 0.82rem; font-weight: 700; cursor: pointer; white-space: nowrap;">
                                    ❤️ Đã lưu (Xóa)
                                </button>
                            <?php else: ?>
                                <button type="submit" title="Bấm để thêm vào yêu thích" style="padding: 0.4rem 0.85rem; border-radius: 9999px; background: #ea580c; color: #ffffff; border: none; font-size: 0.82rem; font-weight: 700; cursor: pointer; white-space: nowrap;">
                                    + Thêm món
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function filterFavModalList(val) {
    const q = val.trim().toLowerCase();
    document.querySelectorAll('#favModalList .fav-modal-item').forEach(el => {
        const title = el.getAttribute('data-title') || '';
        el.style.display = (q === '' || title.includes(q)) ? 'flex' : 'none';
    });
}
</script>

<?php
require __DIR__ . '/../includes/modal-login.php';
require __DIR__ . '/../includes/footer.php';
