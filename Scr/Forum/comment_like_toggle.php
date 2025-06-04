<?php
// comment_like_toggle.php
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
$comment_id = $_POST['comment_id'] ?? null;

if (!$user_id || !$comment_id) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID and Comment ID are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id FROM comments_likes WHERE user_id = ? AND comment_id = ?");
    $stmt->execute([$user_id, $comment_id]);
    $alreadyLiked = $stmt->fetch();

    if ($alreadyLiked) {
        $stmt = $pdo->prepare("DELETE FROM comments_likes WHERE user_id = ? AND comment_id = ?");
        $stmt->execute([$user_id, $comment_id]);

        $action = 'unliked';
    } else {
        $stmt = $pdo->prepare("INSERT INTO comments_likes (user_id, comment_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $comment_id]);

        $action = 'liked';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) AS like_count FROM comments_likes WHERE comment_id = ?");
    $stmt->execute([$comment_id]);
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