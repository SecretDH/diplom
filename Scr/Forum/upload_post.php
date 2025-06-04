<?php
// upload_post.php
require __DIR__ . '../../db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$text = $_POST['text'] ?? '';
$user_id = $_POST['user_id'] ?? null;
$date = date('Y-m-d H:i:s');

if (!$user_id || !$text) {
    echo json_encode(['status' => 'error', 'message' => 'Отсутствует user_id или текст']);
    exit;
}

$uploaded_paths = [];

if (!empty($_FILES['images']['name'][0])) {
    $upload_dir = '../../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
        $file_type = mime_content_type($tmp_name);
        if (in_array($file_type, $allowed_types)) {
            $filename = basename($_FILES['images']['name'][$index]);
            $target_path = $upload_dir . time() . '_' . $filename;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $uploaded_paths[] = $target_path;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Недопустимый тип файла: ' . $file_type]);
            exit;
        }
    }
}

$image_paths = json_encode($uploaded_paths);

$sql = "INSERT INTO forum (user_id, post_text, post_image, post_date)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'isss', $user_id, $text, $image_paths, $date);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Пост успешно добавлен!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка при добавлении поста']);
}
?>