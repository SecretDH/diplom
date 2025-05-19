<?php
require __DIR__ . '/../db.php'; // Подключение к базе данных

// Получаем данные из запроса
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
$series_id = isset($_POST['series_id']) ? intval($_POST['series_id']) : 0;

if ($user_id <= 0 || $rating < 1 || $rating > 10 || ($movie_id <= 0 && $series_id <= 0)) {
    die("Некорректные данные.");
}

// Определяем, в какую таблицу добавлять или обновлять данные
if ($movie_id > 0) {
    $table = 'user_ratings';
    $column = 'movie_id';
    $id = $movie_id;
} elseif ($series_id > 0) {
    $table = 'user_series_ratings';
    $column = 'series_id';
    $id = $series_id;
}

// Проверяем, существует ли уже запись для данного пользователя и фильма/сериала
$sql_check = "SELECT 1 FROM $table WHERE user_id = ? AND $column = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) > 0) {
    // Если запись существует, обновляем рейтинг
    $sql_update = "UPDATE $table SET rating = ?, created_at = NOW() WHERE user_id = ? AND $column = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "iii", $rating, $user_id, $id);
    mysqli_stmt_execute($stmt_update);
    echo "Рейтинг обновлен.";
} else {
    // Если записи нет, добавляем новую
    $sql_insert = "INSERT INTO $table (user_id, $column, rating, created_at) VALUES (?, ?, ?, NOW())";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $id, $rating);
    mysqli_stmt_execute($stmt_insert);
    echo "Рейтинг добавлен.";
}

// Закрываем соединение
mysqli_close($conn);
?>