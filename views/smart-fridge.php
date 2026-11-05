<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

$recipes = db()->query(
    "SELECT id, title, description, category, cooking_time, servings, ingredients, image_url 
     FROM recipes 
     WHERE status = 'approved' 
     ORDER BY created_at DESC"
)->fetchAll();

// Danh sách nhóm nguyên liệu chuyên nghiệp, loại bỏ hoàn toàn biểu tượng icon/emoji
$ingredientGroups = [
    'Thịt & Thủy hải sản' => ['Thịt bò', 'Thịt gà', 'Thịt heo', 'Tôm', 'Cá'],
    'Rau củ quả'           => ['Cà chua', 'Hành tây', 'Rau xanh', 'Cà rốt', 'Nấm'],
    'Trứng & Đậu phụ'      => ['Trứng', 'Đậu phụ'],
    'Gia vị & Thảo mộc'    => ['Tỏi', 'Gừng', 'Sả', 'Tiêu', 'Ớt', 'Lá chanh']
];

$loadSmartFridgeScript = true;
$pageTitle = 'Nguyên liệu - Tủ lạnh thông minh - Cookio';
require __DIR__ . '/../includes/header.php';
?>

<div class="fridge-page-wrapper" style="max-width: 1080px; margin: 0 auto; padding: 2rem 1rem 4rem;">

    <!-- Breadcrumb & Header Box cùng tông màu ấm áp của Cookio -->
    <nav class="cookio-breadcrumb" style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.88rem; margin-bottom: 1.5rem;">
        <a href="<?= BASE_URL ?>/index.php" style="color: #ea580c; text-decoration: none; font-weight: 600;">Trang chủ</a>
        <span style="color: #cbd5e1;">&rsaquo;</span>
        <span style="color: #64748b; font-weight: 600;">Tìm món theo nguyên liệu</span>
    </nav>

    <div class="fridge-header-card" style="text-align: center; margin-bottom: 2.5rem; background: linear-gradient(180deg, #fffaf5 0%, #ffffff 100%); border: 1.5px solid #fed7aa; border-radius: 24px; padding: 2.5rem 2rem; box-shadow: 0 4px 20px rgba(234, 88, 12, 0.05);">
        <span style="display: inline-block; background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; padding: 0.35rem 0.95rem; border-radius: 9999px; font-weight: 800; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.85rem;">
            TỦ LẠNH THÔNG MINH COOKIO
        </span>
        <h1 style="font-size: 2.15rem; font-weight: 800; color: #3e1713; margin: 0 0 0.75rem; letter-spacing: -0.02em;">
            Khám Phá Món Ngon Theo Nguyên Liệu Sẵn Có
        </h1>
        <p style="color: #6b7280; font-size: 1rem; max-width: 620px; margin: 0 auto; line-height: 1.6;">
            Tích chọn những nguyên liệu đang có sẵn trong gian bếp của bạn, hệ thống sẽ đề xuất ngay các công thức nấu ăn phù hợp nhất, tiết kiệm thời gian và chống lãng phí thực phẩm.
        </p>
    </div>

    <!-- Khung chọn nguyên liệu (Bảng điều khiển tủ lạnh) -->
    <div class="fridge-box-card" style="background: #ffffff; border: 1.5px solid #fed7aa; border-radius: 22px; padding: 2rem 2.25rem; box-shadow: 0 8px 30px rgba(0,0,0,0.04); margin-bottom: 2rem;">
        
        <!-- Thanh điều khiển trên: Tiêu đề + Chế độ tìm kiếm + Bỏ chọn -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #ffedd5; padding-bottom: 1rem; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="width: 8px; height: 20px; background: #ea580c; border-radius: 4px; display: inline-block;"></span>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #3e1713; margin: 0;">
                    Chọn nguyên liệu bạn đang có
                </h2>
            </div>

            <div style="display: flex; align-items: center; gap: 0.85rem; flex-wrap: wrap;">
                <!-- Chuyển đổi chế độ khớp nguyên liệu -->
                <div style="display: flex; align-items: center; gap: 0.35rem; background: #fff7ed; padding: 4px; border-radius: 9999px; border: 1px solid #fed7aa; font-size: 0.84rem; font-weight: 600;">
                    <label style="display: inline-flex; align-items: center; gap: 0.35rem; cursor: pointer; margin: 0; padding: 0.3rem 0.75rem; border-radius: 9999px; transition: all 0.2s; color: #3e1713;" class="fridge-mode-label">
                        <input type="radio" name="match_mode" value="any" checked style="accent-color: #ea580c; width: 14px; height: 14px;"> Linh hoạt
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 0.35rem; cursor: pointer; margin: 0; padding: 0.3rem 0.75rem; border-radius: 9999px; transition: all 0.2s; color: #3e1713;" class="fridge-mode-label">
                        <input type="radio" name="match_mode" value="all" style="accent-color: #ea580c; width: 14px; height: 14px;"> Chính xác
                    </label>
                </div>

                <button type="button" id="btnClearAll" style="background: #ffffff; color: #ea580c; border: 1.5px solid #fed7aa; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.84rem; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fff7ed'; this.style.borderColor='#ea580c';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#fed7aa';">
                    Bỏ chọn tất cả
                </button>
            </div>
        </div>

        <!-- Danh sách nguyên liệu theo nhóm (Hoàn toàn không có icon/emoji thừa) -->
        <div id="ingredientPicker" style="display: flex; flex-direction: column; gap: 1.35rem;">
            <?php foreach ($ingredientGroups as $groupTitle => $groupItems): ?>
                <div class="fridge-group-block">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: #3e1713; margin: 0 0 0.65rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        <?= e($groupTitle) ?>
                    </h3>
                    <div class="fridge-ingredients-group" style="display: flex; flex-wrap: wrap; gap: 0.6rem;">
                        <?php foreach ($groupItems as $item): ?>
                            <label class="fridge-chip">
                                <input type="checkbox" value="<?= e($item) ?>">
                                <span><?= e($item) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Nhóm nguyên liệu tự thêm -->
            <div id="customGroup" class="hidden fridge-group-block">
                <h3 style="font-size: 0.95rem; font-weight: 800; color: #ea580c; margin: 0 0 0.65rem; text-transform: uppercase; letter-spacing: 0.03em;">
                    Nguyên liệu tùy chọn
                </h3>
                <div id="customChips" class="fridge-ingredients-group" style="display: flex; flex-wrap: wrap; gap: 0.6rem;"></div>
            </div>
        </div>

        <!-- Ô thêm nguyên liệu tùy chọn nhanh dạng viên thuốc -->
        <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px dashed #fed7aa; display: flex; gap: 0.65rem; max-width: 440px;">
            <input type="text" id="customIngredientInput" placeholder="Thêm nguyên liệu khác (vd: Me chua, Nước dừa, Sả cay...)" style="flex: 1; padding: 0.65rem 1.15rem; border: 1.5px solid #fed7aa; border-radius: 9999px; font-size: 0.9rem; outline: none; background: #fffaf5;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#fed7aa'; this.style.background='#fffaf5';">
            <button type="button" id="btnAddIngredient" style="background: #ea580c; color: #ffffff; border: none; padding: 0.65rem 1.35rem; border-radius: 9999px; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: all 0.2s; white-space: nowrap; box-shadow: 0 3px 10px rgba(234, 88, 12, 0.25);" onmouseover="this.style.background='#c2410c';" onmouseout="this.style.background='#ea580c';">
                Thêm
            </button>
        </div>
    </div>

    <!-- Thông báo trạng thái gợi ý -->
    <div id="fridgeMessage" style="background: #fff7ed; border: 1.5px solid #fed7aa; border-radius: 14px; padding: 0.85rem 1.25rem; color: #7c2d12; font-size: 0.92rem; font-weight: 600; margin-bottom: 2rem;">
        Hãy chọn ít nhất một nguyên liệu ở trên để bắt đầu tìm món phù hợp.
    </div>

    <!-- Lưới hiển thị món ăn gợi ý (Đồng bộ chuẩn giao diện ấm cúng trang chủ) -->
    <div class="recipe-grid" id="fridgeResults">
        <?php foreach ($recipes as $recipe): ?>
            <?php 
            $imgSrc = !empty($recipe['image_url']) ? BASE_URL . '/' . e($recipe['image_url']) : BASE_URL . '/assets/images/default-recipe.jpg';
            ?>
            <article class="recipe-card fridge-recipe" 
                     data-title="<?= e(mb_strtolower($recipe['title'])) ?>"
                     data-ingredients="<?= e(mb_strtolower($recipe['ingredients'])) ?>"
                     data-category="<?= e(mb_strtolower($recipe['category'] ?? '')) ?>"
                     data-description="<?= e(mb_strtolower($recipe['description'] ?? '')) ?>"
                     style="background: #ffffff; border: 1.5px solid #fed7aa; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.25s, box-shadow 0.25s;">
                <div>
                    <!-- Ảnh món ăn -->
                    <div class="recipe-card-media" style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background: #fdfbf7;">
                        <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int) $recipe['id'] ?>">
                            <img src="<?= $imgSrc ?>" alt="<?= e($recipe['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s ease;" loading="lazy">
                        </a>
                        <span class="card-category-badge" style="position: absolute; top: 0.75rem; left: 0.75rem; background: rgba(30, 27, 27, 0.8); backdrop-filter: blur(4px); color: #ffffff; font-size: 0.75rem; font-weight: 700; padding: 0.3rem 0.75rem; border-radius: 9999px;">
                            <?= e($recipe['category'] ?? 'Món chính') ?>
                        </span>
                    </div>

                    <div class="recipe-card-body" style="padding: 1.25rem;">
                        <!-- Huy hiệu khớp nguyên liệu -->
                        <div class="match-badge-container" style="margin-bottom: 0.65rem; min-height: 24px;"></div>

                        <!-- Thông số món (Không dùng icon emoji) -->
                        <div style="display: flex; gap: 0.85rem; font-size: 0.82rem; color: #9a3412; font-weight: 600; margin-bottom: 0.5rem;">
                            <span>Thời gian: <?= e($recipe['cooking_time'] ?? '30 phút') ?></span>
                            <span style="color: #fed7aa;">|</span>
                            <span>Khẩu phần: <?= e($recipe['servings'] ?? '2 - 4 người') ?></span>
                        </div>

                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #3e1713; margin: 0 0 0.65rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <a href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int) $recipe['id'] ?>" style="color: inherit; text-decoration: none;" onmouseover="this.style.color='#ea580c';" onmouseout="this.style.color='#3e1713';">
                                <?= e($recipe['title']) ?>
                            </a>
                        </h3>

                        <!-- Dải nguyên liệu rút gọn -->
                        <div style="font-size: 0.84rem; color: #64748b; line-height: 1.5; background: #fffaf5; border: 1px solid #ffedd5; padding: 0.6rem 0.85rem; border-radius: 10px; margin-bottom: 1rem;">
                            <strong style="color: #7c2d12;">Nguyên liệu chính:</strong> 
                            <?= e(mb_strimwidth((string) str_replace(["\r\n", "\n", "\r"], ', ', $recipe['ingredients']), 0, 85, '...')) ?>
                        </div>
                    </div>
                </div>

                <!-- Nút xem cách nấu cùng tone với website -->
                <div style="padding: 0 1.25rem 1.25rem;">
                    <a class="button button-create" style="display: block; text-align: center; width: 100%; padding: 0.65rem; border-radius: 9999px; font-weight: 700; font-size: 0.92rem; text-decoration: none; background: #ea580c; color: #ffffff; box-shadow: 0 3px 10px rgba(234, 88, 12, 0.2); transition: background 0.2s;" href="<?= BASE_URL ?>/views/recipe-detail.php?id=<?= (int) $recipe['id'] ?>" onmouseover="this.style.background='#c2410c';" onmouseout="this.style.background='#ea580c';">
                        Xem cách nấu ngay &rarr;
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Thông báo khi không có món khớp -->
    <div id="noMatchMessage" class="hidden" style="text-align: center; margin-top: 2.5rem; padding: 3rem 2rem; background: #ffffff; border: 2px dashed #fed7aa; border-radius: 20px;">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: #3e1713; margin: 0 0 0.5rem;">
            Chưa tìm thấy món nào khớp với toàn bộ nguyên liệu bạn đã chọn
        </h3>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0 0 1.5rem;">
            Gợi ý: Bạn có thể chuyển sang chế độ "Linh hoạt" hoặc bỏ bớt những gia vị phụ ít phổ biến để tìm được nhiều món ngon hơn!
        </p>
        <a href="<?= BASE_URL ?>/views/create-recipe.php" style="display: inline-block; padding: 0.75rem 2rem; border-radius: 9999px; font-weight: 700; font-size: 0.95rem; text-decoration: none; background: #ea580c; color: #ffffff; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25);">
            + Đăng công thức với nguyên liệu này
        </a>
    </div>

</div>

<!-- CSS chuyên biệt để hoàn thiện tone màu cho trang Nguyên Liệu -->
<style>
.fridge-chip {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}
.fridge-chip input {
    position: absolute;
    opacity: 0;
    width: 0;
}
.fridge-chip span {
    display: inline-flex;
    align-items: center;
    padding: 0.45rem 1.05rem;
    border-radius: 9999px;
    border: 1.5px solid #fed7aa;
    background: #fffaf5;
    font-size: 0.88rem;
    font-weight: 600;
    color: #4a1c17;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.fridge-chip:hover span {
    border-color: #ea580c;
    background: #ffedd5;
}
.fridge-chip input:checked + span {
    background: #ea580c !important;
    border-color: #ea580c !important;
    color: #ffffff !important;
    font-weight: 700;
    box-shadow: 0 3px 10px rgba(234, 88, 12, 0.28);
}
[data-theme="dark"] .fridge-header-card,
[data-theme="dark"] .fridge-box-card,
[data-theme="dark"] .fridge-recipe {
    background: #131b2e !important;
    border-color: #253556 !important;
}
[data-theme="dark"] .fridge-header-card h1,
[data-theme="dark"] .fridge-box-card h2,
[data-theme="dark"] .fridge-group-block h3,
[data-theme="dark"] .fridge-recipe h3 a {
    color: #f8fafc !important;
}
[data-theme="dark"] .fridge-chip span {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #cbd5e1 !important;
}
[data-theme="dark"] .fridge-chip input:checked + span {
    background: #ea580c !important;
    border-color: #ea580c !important;
    color: #ffffff !important;
}
[data-theme="dark"] #customIngredientInput {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}
[data-theme="dark"] #fridgeMessage {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #fb923c !important;
}
</style>

<?php
require __DIR__ . '/../includes/modal-login.php';
require __DIR__ . '/../includes/footer.php';
