<?php
// Debug: Выводим ошибки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$comment_id = $_POST['comment_id'] ?? null;

// Проверяем наличие необходимых данных
if (!$user_id || !$comment_id) {
    http_response_code(400); // Неверный запрос
    echo json_encode(['error' => 'User ID and Comment ID are required']);
    exit;
}

try {
    // Проверяем, был ли лайк
    $stmt = $pdo->prepare("SELECT id FROM comments_likes WHERE user_id = ? AND comment_id = ?");
    $stmt->execute([$user_id, $comment_id]);
    $alreadyLiked = $stmt->fetch();

    if ($alreadyLiked) {
        // Если лайк уже был, удаляем его
        $stmt = $pdo->prepare("DELETE FROM comments_likes WHERE user_id = ? AND comment_id = ?");
        $stmt->execute([$user_id, $comment_id]);

        $action = 'unliked'; // Действие: убран лайк
    } else {
        // Если лайка не было, добавляем его
        $stmt = $pdo->prepare("INSERT INTO comments_likes (user_id, comment_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $comment_id]);

        $action = 'liked'; // Действие: поставлен лайк
    }

    // Подсчитываем текущее количество лайков для комментария
    $stmt = $pdo->prepare("SELECT COUNT(*) AS like_count FROM comments_likes WHERE comment_id = ?");
    $stmt->execute([$comment_id]);
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