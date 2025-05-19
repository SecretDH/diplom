<?php
require __DIR__ . '../../db.php';

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
    
    echo '<div class="series_item" id="series_item_' . $seriesId . '" data-related-id="' . $seriesId . '">';
    echo '<img src="../../Image/pin.svg" class="series_pin">';
    echo '<img src="../../Image/eye.svg" class="series_eye">';
    echo '<img src="' . $seriesPoster . '" class="series_image" alt="' . $seriesTitle . '">';
    echo '<div class="series_date">' . $seriesYear . '</div>';
    echo '<div class="series_duration">' . ($seriesDuration ?: 'No duration available') . ' minutes</div>';

    // Добавляем скрытый шаблон
    echo '<div class="info_box_template" style="display: none;">';
    echo '<div class="info_box_series">';
    echo '<div class="info_box_title_series">Pins</div>';
    $user_id = $_GET['user_id'] ?? null;
    $pin_type = 'series';
    $related_id = $seriesId;

    if (!$user_id) {
        die("ID пользователя не передан.");
    }

    $_GET['pin_type'] = $pin_type;
    $_GET['related_id'] = $related_id;
    include 'get_pins.php';
    echo '</div>';
    echo '</div>';

    echo '</div>';
}
?>