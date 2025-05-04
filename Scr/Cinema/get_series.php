<?php
require __DIR__ . '../../db.php';

// Проверяем, что пользователь авторизован (если требуется)
// if (!isset($user_id)) {
//     echo "Ошибка: ID пользователя не передан.";
//     exit;
// }

// Запрос к таблице series
$sql = "
    SELECT 
        series.id, 
        series.title,
        series.duration,
        series.year, 
        series.poster, 
        series.big_poster, 
        series.created_at
    FROM 
        series
    ORDER BY 
        series.created_at DESC
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

    echo '<a href="movie_series_page.php?series_id=' . $seriesId . '" class="movie_series_page_link">';
    echo '<div class="series_item" id="series_item_' . $seriesId . '">';
    echo '<img src="../../Image/pin.svg" class="series_pin">';
    echo '<img src="../../Image/eye.svg" class="series_eye">';
    echo '<img src="' . $seriesPoster . '" class="series_image" alt="' . $seriesTitle . '">';
    echo '<div class="series_date">' . $seriesYear . '</div>';
    echo '<div class="series_duration">' . ($seriesDuration ?: 'No duration available') . ' minutes </div>';
    echo '</div>';
    echo '</a>';
}
?>