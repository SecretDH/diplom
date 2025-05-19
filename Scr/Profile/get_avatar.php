<?php
require __DIR__ . '/../db.php';
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id <= 0) {
    echo json_encode(['avatar' => '../../Avatars/Defoult_avatar.png']);
    exit;
}

$stmt = $pdo->prepare("SELECT avatar FROM users WHERE ID = ?");
$stmt->execute([$user_id]);
$avatar = $stmt->fetchColumn();

if (!$avatar) $avatar = '../../Avatars/Defoult_avatar.png';

echo json_encode(['avatar' => $avatar]);
?>