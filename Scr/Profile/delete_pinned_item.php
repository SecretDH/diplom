<?php
//delete_pinned_item.php
require __DIR__ . '/../db.php';

header('Content-Type: application/json');

$related_id = $_POST['related_id'] ?? null;
$pin_type = $_POST['pin_type'] ?? null;

if (!$related_id || !$pin_type) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'error' => 'ID элемента и тип пина обязательны.']);
    exit;
}

try {
    if ($pin_type === 'movie') {
        $table = 'pin_movie';
        $field = 'movie_id';
    } elseif ($pin_type === 'series') {
        $table = 'pin_series';
        $field = 'series_id';
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Неверный тип пина.']);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM $table WHERE $field = ?");
    $stmt->execute([$related_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'error' => 'Элемент не найден или уже удален.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Ошибка сервера: ' . $e->getMessage()]);
}
?>