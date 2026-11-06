<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

if (!is_logged_in()) {
    $returnUrl = (string) ($_POST['return_url'] ?? 'index.php');
    redirect($returnUrl . (str_contains($returnUrl, '?') ? '&' : '?') . 'error=login-required');
}

$csrfToken = (string) ($_POST['csrf_token'] ?? '');
$returnUrl = (string) ($_POST['return_url'] ?? 'index.php');

if (!verify_csrf_token($csrfToken)) {
    redirect($returnUrl . (str_contains($returnUrl, '?') ? '&' : '?') . 'error=csrf');
}

$recipeId = filter_input(INPUT_POST, 'recipe_id', FILTER_VALIDATE_INT);
if (!$recipeId) {
    redirect($returnUrl . (str_contains($returnUrl, '?') ? '&' : '?') . 'error=invalid-recipe');
}

$action = (string) ($_POST['action'] ?? 'toggle');
$userId = (int) $_SESSION['user_id'];
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || isset($_POST['ajax']);

if ($action === 'save_note') {
    $note = trim((string) ($_POST['note'] ?? ''));
    // If not saved yet, save it with note
    $stmtCheck = db()->prepare('SELECT id FROM saved_recipes WHERE user_id = ? AND recipe_id = ?');
    $stmtCheck->execute([$userId, $recipeId]);
    $saved = $stmtCheck->fetch();

    if ($saved) {
        $stmtUpdate = db()->prepare('UPDATE saved_recipes SET note = ? WHERE id = ?');
        $stmtUpdate->execute([$note !== '' ? $note : null, $saved['id']]);
    } else {
        $stmtInsert = db()->prepare('INSERT INTO saved_recipes (user_id, recipe_id, note) VALUES (?, ?, ?)');
        $stmtInsert->execute([$userId, $recipeId, $note !== '' ? $note : null]);
    }

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true, 'note' => $note, 'message' => 'Đã lưu ghi chú bếp thành công!']);
        exit;
    }

    redirect($returnUrl . (str_contains($returnUrl, '?') ? '&' : '?') . 'bookmark=note_saved');
}

$stmtCheck = db()->prepare('SELECT id FROM saved_recipes WHERE user_id = ? AND recipe_id = ?');
$stmtCheck->execute([$userId, $recipeId]);
$saved = $stmtCheck->fetch();

$stmtCheckL = db()->prepare('SELECT 1 FROM recipe_likes WHERE user_id = ? AND recipe_id = ?');
$stmtCheckL->execute([$userId, $recipeId]);
$liked = $stmtCheckL->fetch();

if ($saved || $liked) {
    // Xóa món khỏi danh sách yêu thích (Đồng bộ xóa cả trong saved_recipes và recipe_likes)
    $stmtDelete = db()->prepare('DELETE FROM saved_recipes WHERE user_id = ? AND recipe_id = ?');
    $stmtDelete->execute([$userId, $recipeId]);

    $stmtDeleteL = db()->prepare('DELETE FROM recipe_likes WHERE user_id = ? AND recipe_id = ?');
    $stmtDeleteL->execute([$userId, $recipeId]);

    $statusMsg = 'unsaved';
} else {
    // Thêm món vào danh sách yêu thích (Đồng bộ lưu cả vào saved_recipes và recipe_likes)
    $stmtInsert = db()->prepare('INSERT INTO saved_recipes (user_id, recipe_id) VALUES (?, ?)');
    $stmtInsert->execute([$userId, $recipeId]);

    $stmtInsertL = db()->prepare('INSERT INTO recipe_likes (user_id, recipe_id) VALUES (?, ?)');
    $stmtInsertL->execute([$userId, $recipeId]);

    $statusMsg = 'saved';
}

// Cập nhật lại tổng số likes_count thật cho món ăn
$countStmt = db()->prepare('SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = ?');
$countStmt->execute([$recipeId]);
$newLikesCount = (int) $countStmt->fetchColumn();
$upStmt = db()->prepare('UPDATE recipes SET likes_count = ? WHERE id = ?');
$upStmt->execute([$newLikesCount, $recipeId]);

if ($isAjax) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => true, 'status' => $statusMsg]);
    exit;
}

redirect($returnUrl . (str_contains($returnUrl, '?') ? '&' : '?') . 'bookmark=' . $statusMsg);

