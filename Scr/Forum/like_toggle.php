<?php
// like_toggle.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '../../db.php';

header('Content-Type: application/json');

if (!isset($pdo)) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection not established']);
    exit;
}

$user_id = $_POST['user_id'] ?? null;
$post_id = $_POST['post_id'] ?? null;

if (!$user_id || !$post_id) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID and Post ID are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $alreadyLiked = $stmt->fetch();

    if ($alreadyLiked) {
        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);

        $action = 'unliked';
    } else {
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $post_id]);

        $action = 'liked';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $updated = $stmt->fetch();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'new_like_count' => $updated['like_count']
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>