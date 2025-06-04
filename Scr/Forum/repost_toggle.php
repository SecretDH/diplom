<?php
// repost_toggle.php
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
    $stmt = $pdo->prepare("SELECT user_id FROM forum WHERE ID = ?");
    $stmt->execute([$post_id]);
    $originalPost = $stmt->fetch();

    if (!$originalPost) {
        http_response_code(404);
        echo json_encode(['error' => 'Post not found']);
        exit;
    }

    $post_user_id = $originalPost['user_id'];

    $stmt = $pdo->prepare("SELECT id FROM reposts WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $alreadyReposted = $stmt->fetch();

    if ($alreadyReposted) {
        $stmt = $pdo->prepare("DELETE FROM reposts WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);

        $action = 'unreposted';
    } else {
        $stmt = $pdo->prepare("INSERT INTO reposts (user_id, post_id, post_user_id) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $post_user_id]);

        $action = 'reposted';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) AS repost_count FROM reposts WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $updated = $stmt->fetch();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'new_repost_count' => $updated['repost_count']
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>