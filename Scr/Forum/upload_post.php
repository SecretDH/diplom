<?php
require __DIR__ . '../../db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$text = $_POST['text'] ?? '';
$user_id = $_POST['user_id'] ?? null;
$user_name = $_POST['user_name'] ?? null;
$user_login = $_POST['user_login'] ?? null;
$user_avatar = $_POST['user_avatar'] ?? null;
$date = date('Y-m-d H:i:s');

$post_like = 0;
$post_comment = 0;
$post_retweet = 0;
$post_view = 0;

if (!$user_id || !$text) {
    echo json_encode(['status' => 'error', 'message' => 'Отсутствует user_id или текст']);
    exit;
}

$uploaded_paths = [];

if (!empty($_FILES['images']['name'][0])) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
        $filename = basename($_FILES['images']['name'][$index]);
        $target_path = $upload_dir . time() . '_' . $filename;

        if (move_uploaded_file($tmp_name, $target_path)) {
            $uploaded_paths[] = $target_path;
        }
    }
}

$image_paths = json_encode($uploaded_paths);

// ✨ Используем mysqli
$sql = "INSERT INTO forum (user_id, user_name, user_login, user_avatar, post_text, post_image, post_date, post_like, post_comment, post_retweet, post_view)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'issssssiiii', $user_id, $user_name, $user_login, $user_avatar, $text, $image_paths, $date, $post_like, $post_comment, $post_retweet, $post_view);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Пост успешно добавлен!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка при добавлении поста']);
}
?>