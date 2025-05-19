<?php
require __DIR__ . '../../db.php';

if (!isset($id) || !isset($type) || $id <= 0) {
    die("Некорректный ID или тип.");
}

// Определяем таблицу и поле для запроса
if ($type === 'movie') {
    $table = 'movie_actors';
    $column = 'movie_id';
} elseif ($type === 'series') {
    $table = 'series_actors';
    $column = 'series_id';
} else {
    die("Некорректный тип.");
}

// Выполняем запрос для получения актеров
$sql = "
    SELECT 
        actors.id, 
        actors.name, 
        actors.photo,
        COALESCE(actor_movie_count.movie_count, 0) AS movie_count,
        COALESCE(actor_series_count.series_count, 0) AS series_count
    FROM 
        actors
    LEFT JOIN 
        actor_movie_count ON actors.id = actor_movie_count.actor_id
    LEFT JOIN 
        actor_series_count ON actors.id = actor_series_count.actor_id
    INNER JOIN 
        $table ON actors.id = $table.actor_id
    WHERE 
        $table.$column = ?
";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo "Ошибка при получении данных: " . mysqli_error($conn);
    exit;
}

// Вывод данных
while ($row = mysqli_fetch_assoc($result)) {
    $actorId = htmlspecialchars($row['id']);
    $actorName = htmlspecialchars($row['name']);
    $actorPhoto = htmlspecialchars($row['photo']);
    $actorsMovieCount = htmlspecialchars($row['movie_count']);
    $actorsSeriesCount = htmlspecialchars($row['series_count']);

    echo '<a href="actor_page.php?actor_id=' . $actorId . '" class="actor_link">';
    echo '<div class="actor_item">';
    echo '<img src="' . $actorPhoto . '" alt="' . $actorName . '" class="actor_image">';
    echo '<p class="actor_name">' . $actorName . '</p>';
    echo '<div class="actor_statistics">';
    echo '' . $actorsMovieCount . ' films ' . $actorsSeriesCount . ' series';
    echo '</div>';
    echo '</div>';
    echo '</a>';
}
?>