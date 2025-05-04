<?php
require __DIR__ . '../../db.php';

if (!isset($actor_id) || $actor_id <= 0) {
    die("Некорректный ID актера.");
}

// Запрос к таблице series
$sql = "
    SELECT 
        series.id AS id, 
        series.title AS title,
        series.duration AS duration,
        series.year AS year, 
        series.poster AS poster, 
        series.big_poster AS big_poster, 
        series.created_at AS created_at
    FROM 
        series
    INNER JOIN 
        series_actors ON series.id = series_actors.series_id
    WHERE 
        series_actors.actor_id = $actor_id

    UNION ALL

    SELECT 
        movies.id AS id, 
        movies.title AS title,
        movies.duration AS duration,
        movies.year AS year, 
        movies.poster AS poster, 
        movies.big_poster AS big_poster, 
        movies.created_at AS created_at
    FROM 
        movies
    INNER JOIN 
        movie_actors ON movies.id = movie_actors.movie_id
    WHERE 
        movie_actors.actor_id = $actor_id

    ORDER BY 
        created_at DESC
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Ошибка при получении данных: " . mysqli_error($conn);
    exit;
}

// Вывод данных
while ($row = mysqli_fetch_assoc($result)) {
    $seriesId = htmlspecialchars($row['id']);
    $seriesTitle = htmlspecialchars($row['title']);
    $seriesDuration = htmlspecialchars($row['duration']);
    $seriesYear = htmlspecialchars($row['year']);
    $seriesPoster = htmlspecialchars($row['poster']);
    $seriesBigPoster = htmlspecialchars($row['big_poster']);
    $seriesCreatedAt = htmlspecialchars($row['created_at']);

    echo '<div class="series_item" id="series_item_' . $seriesId . '">';
    echo '<img src="../../Image/pin.svg" class="series_pin">';
    echo '<img src="../../Image/eye.svg" class="series_eye">';
    echo '<img src="' . $seriesPoster . '" class="series_image" alt="' . $seriesTitle . '">';
    echo '<div class="series_date">' . $seriesYear . '</div>';
    echo '<div class="series_duration">' . ($seriesDuration ?: 'No duration available') . ' minutes </div>';
    echo '</div>';
}
?>