<?php
require __DIR__ . '../../db.php'; // Убедитесь, что путь к db.php корректный

header('Content-Type: application/json');

// Проверяем, что подключение к базе данных установлено
if (!isset($pdo)) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection not established']);
    exit;
}

// Получаем данные из POST-запроса
$user_id = $_POST['user_id'] ?? null;
$pin_id = $_POST['pin_id'] ?? null;

// Проверяем наличие необходимых данных
if (!$user_id || !$pin_id) {
    http_response_code(400); // Неверный запрос
    echo json_encode(['error' => 'User ID and Pin ID are required']);
    exit;
}

try {
    // Проверяем, был ли лайк
    $stmt = $pdo->prepare("SELECT pin_id FROM pin_like WHERE user_id = ? AND pin_id = ?");
    $stmt->execute([$user_id, $pin_id]);
    $alreadyLiked = $stmt->fetch();

    if ($alreadyLiked) {
        // Если лайк уже был, удаляем его
        $stmt = $pdo->prepare("DELETE FROM pin_like WHERE user_id = ? AND pin_id = ?");
        $stmt->execute([$user_id, $pin_id]);

        $action = 'unliked'; // Действие: убран лайк
    } else {
        // Если лайка не было, добавляем его
        $stmt = $pdo->prepare("INSERT INTO pin_like (user_id, pin_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $pin_id]);

        $action = 'liked'; // Действие: поставлен лайк
    }

    // Подсчитываем текущее количество лайков для пина
    $stmt = $pdo->prepare("SELECT COUNT(*) AS like_count FROM pin_like WHERE pin_id = ?");
    $stmt->execute([$pin_id]);
    $updated = $stmt->fetch();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'new_like_count' => $updated['like_count']
    ]);
} catch (Exception $e) {
    http_response_code(500); // Ошибка сервера
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>