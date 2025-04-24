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
$post_id = $_POST['post_id'] ?? null;

// Проверяем наличие необходимых данных
if (!$user_id || !$post_id) {
    http_response_code(400); // Неверный запрос
    echo json_encode(['error' => 'User ID and Post ID are required']);
    exit;
}

try {
    // Проверяем, был ли лайк
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $alreadyLiked = $stmt->fetch();

    if ($alreadyLiked) {
        // Если лайк уже был, удаляем его
        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);

        // Минусуем счётчик лайков
        $stmt = $pdo->prepare("UPDATE forum SET post_like = post_like - 1 WHERE ID = ?");
        $stmt->execute([$post_id]);

        $action = 'unliked'; // Действие: убран лайк
    } else {
        // Если лайка не было, добавляем его
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $post_id]);

        // Плюсуем счётчик лайков
        $stmt = $pdo->prepare("UPDATE forum SET post_like = post_like + 1 WHERE ID = ?");
        $stmt->execute([$post_id]);

        $action = 'liked'; // Действие: поставлен лайк
    }

    // Возвращаем обновлённое количество лайков
    $stmt = $pdo->prepare("SELECT post_like FROM forum WHERE ID = ?");
    $stmt->execute([$post_id]);
    $updated = $stmt->fetch();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'new_like_count' => $updated['post_like']
    ]);
} catch (Exception $e) {
    http_response_code(500); // Ошибка сервера
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>