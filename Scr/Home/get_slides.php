<?php
require __DIR__ . '/../db.php';

// Получаем топ-15 фильмов и сериалов по рейтингу
$sql = "
    SELECT m.id, m.title, m.poster AS img_src, m.description, m.big_poster, 
           COALESCE(v.average_rating, 0) AS average_rating, 
           COALESCE(v.ratings_count, 0) AS ratings_count,
           'movie' AS type
    FROM movies m
    LEFT JOIN movie_ratings_view v ON m.id = v.movie_id

    UNION ALL

    SELECT s.id, s.title, s.poster AS img_src, s.description, s.big_poster, 
           COALESCE(v.average_rating, 0) AS average_rating, 
           COALESCE(v.ratings_count, 0) AS ratings_count,
           'series' AS type
    FROM series s
    LEFT JOIN series_ratings_view v ON s.id = v.series_id

    ORDER BY average_rating DESC
    LIMIT 15
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo "Ошибка запроса к базе данных.";
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $id = (int)$row['id'];
    $img_src = htmlspecialchars($row['img_src']);
    $title = htmlspecialchars($row['title']);
    $type = htmlspecialchars($row['type']);
    $description = isset($row['description']) ? htmlspecialchars($row['description']) : '';
    $big_poster = isset($row['big_poster']) ? htmlspecialchars($row['big_poster']) : '';
    $average_rating = isset($row['average_rating']) ? htmlspecialchars($row['average_rating']) : '0';
    $ratings_count = isset($row['ratings_count']) ? htmlspecialchars($row['ratings_count']) : '0';

    echo '<div class="slide">';
    echo '  <div class="slide_img"'
        . ' id="' . $id . '"'
        . ' data-title="' . $title . '"'
        . ' data-type="' . $type . '"'
        . ' data-description="' . $description . '"'
        . ' data-big_poster="' . $big_poster . '"'
        . ' data-average_rating="' . $average_rating . '"'
        . ' data-ratings_count="' . $ratings_count . '"'
        . '>';
    echo '    <img src="' . $img_src . '" draggable="false">';
    echo '  </div>';
    echo '</div>';
}

mysqli_free_result($result);
mysqli_close($conn);
?>