<?php
require __DIR__ . '../../db.php';

// Получаем данные из AJAX-запроса
$data = json_decode(file_get_contents('php://input'), true);

$pin_id = $data['pin_id'] ?? null;
$pin_type = $data['pin_type'] ?? null;
$related_id = $data['related_id'] ?? null; // ID фильма или сериала

if (!$pin_id || !$pin_type || !$related_id) {
    echo json_encode(['success' => false, 'message' => 'Некорректные данные.']);
    exit;
}

// Определяем таблицу и поле в зависимости от типа пина
if ($pin_type === 'movie') {
    $table = 'pin_movie';
    $related_field = 'movie_id';
} elseif ($pin_type === 'series') {
    $table = 'pin_series';
    $related_field = 'series_id';
} else {
    echo json_encode(['success' => false, 'message' => 'Некорректный тип пина.']);
    exit;
}

try {
    // Проверяем, существует ли запись
    $query = "SELECT COUNT(*) FROM $table WHERE pin_id = ? AND $related_field = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$pin_id, $related_id]);
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
        // Если запись существует, удаляем её
        $query = "DELETE FROM $table WHERE pin_id = ? AND $related_field = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$pin_id, $related_id]);
        echo json_encode(['success' => true, 'action' => 'removed']);
    } else {
        // Если записи нет, добавляем её
        $query = "INSERT INTO $table (pin_id, $related_field) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$pin_id, $related_id]);
        echo json_encode(['success' => true, 'action' => 'added']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>