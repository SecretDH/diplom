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
    // Получаем ID автора оригинального поста
    $stmt = $pdo->prepare("SELECT user_id FROM forum WHERE ID = ?");
    $stmt->execute([$post_id]);
    $originalPost = $stmt->fetch();

    if (!$originalPost) {
        http_response_code(404); // Пост не найден
        echo json_encode(['error' => 'Post not found']);
        exit;
    }

    $post_user_id = $originalPost['user_id'];

    // Проверяем, был ли репост
    $stmt = $pdo->prepare("SELECT id FROM reposts WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $alreadyReposted = $stmt->fetch();

    if ($alreadyReposted) {
        // Если репост уже был, удаляем его
        $stmt = $pdo->prepare("DELETE FROM reposts WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);

        $action = 'unreposted'; // Действие: убран репост
    } else {
        // Если репоста не было, добавляем его
        $stmt = $pdo->prepare("INSERT INTO reposts (user_id, post_id, post_user_id) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $post_user_id]);

        $action = 'reposted'; // Действие: добавлен репост
    }

    // Подсчитываем текущее количество репостов для поста
    $stmt = $pdo->prepare("SELECT COUNT(*) AS repost_count FROM reposts WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $updated = $stmt->fetch();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'new_repost_count' => $updated['repost_count']
    ]);
} catch (Exception $e) {
    http_response_code(500); // Ошибка сервера
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>