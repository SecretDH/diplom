<?php
// comic_rate_handler.php
require __DIR__ . '/../db.php';

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$comic_id = isset($_POST['comic_id']) ? intval($_POST['comic_id']) : 0;

if ($user_id <= 0 || $rating < 1 || $rating > 10 || $comic_id <= 0) {
    die("Некорректные данные.");
}

// Используем таблицу comic_rating
$sql_check = "SELECT 1 FROM comic_rating WHERE user_id = ? AND comic_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $comic_id);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) > 0) {
    $sql_update = "UPDATE comic_rating SET rating = ?, rate_at = NOW() WHERE user_id = ? AND comic_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "iii", $rating, $user_id, $comic_id);
    mysqli_stmt_execute($stmt_update);
    echo "Рейтинг обновлен.";
    mysqli_stmt_close($stmt_update);
} else {
    $sql_insert = "INSERT INTO comic_rating (user_id, comic_id, rating, rate_at) VALUES (?, ?, ?, NOW())";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $comic_id, $rating);
    mysqli_stmt_execute($stmt_insert);
    echo "Рейтинг добавлен.";
    mysqli_stmt_close($stmt_insert);
}

mysqli_stmt_close($stmt_check);
mysqli_close($conn);
?>