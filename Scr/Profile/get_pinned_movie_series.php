<?php
// get_pined_movie_series.php
require __DIR__ . '/../db.php';

$pin_id = isset($_GET['pin_id']) ? intval($_GET['pin_id']) : 0;

if ($pin_id <= 0) {
    die("Некорректный ID пина.");
}

$moviesQuery = "
    SELECT 
        movies.id AS id,
        movies.title AS title,
        movies.duration AS duration,
        movies.year AS year,
        movies.poster AS poster,
        pin_movie.created_at AS created_at,
        'movie' AS type
    FROM 
        pin_movie
    INNER JOIN 
        movies ON pin_movie.movie_id = movies.id
    WHERE 
        pin_movie.pin_id = ?
";

$seriesQuery = "
    SELECT 
        series.id AS id,
        series.title AS title,
        series.duration AS duration,
        series.year AS year,
        series.poster AS poster,
        pin_series.created_at AS created_at,
        'series' AS type
    FROM 
        pin_series
    INNER JOIN 
        series ON pin_series.series_id = series.id
    WHERE 
        pin_series.pin_id = ?
";

$moviesStmt = $pdo->prepare($moviesQuery);
$moviesStmt->execute([$pin_id]);
$movies = $moviesStmt->fetchAll(PDO::FETCH_ASSOC);

$seriesStmt = $pdo->prepare($seriesQuery);
$seriesStmt->execute([$pin_id]);
$series = $seriesStmt->fetchAll(PDO::FETCH_ASSOC);

$items = array_merge($movies, $series);

usort($items, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

echo '<div class="pinned_items">';
if (!empty($items)) {
    foreach ($items as $item) {
        echo '<div class="pinned_item" id="pinned_item_' . htmlspecialchars($item['id']) . '" data-related-id="' . htmlspecialchars($item['id']) . '" data-type="' . htmlspecialchars($item['type']) . '">';
        echo '<img src="../../Image/pinned.svg" class="pinned_pin">';
        echo '<img src="' . htmlspecialchars($item['poster']) . '" class="pinned_image" alt="' . htmlspecialchars($item['title']) . '">';
        echo '<div class="pinned_date">' . htmlspecialchars($item['year']) . '</div>';
        echo '<div class="pinned_duration">' . (htmlspecialchars($item['duration']) ?: 'No duration available') . ' minutes</div>';

        echo '</div>';
    }
} else {
    echo '<p class="no_elements"> No related items.</p>';
}
echo '</div>';
?>