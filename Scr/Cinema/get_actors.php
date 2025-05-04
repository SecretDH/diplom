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
    ORDER BY 
        actors.id DESC
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Ошибка при получении данных: " . mysqli_error($conn);
    exit;
}

// Вывод данных
while ($row = mysqli_fetch_assoc($result)) {
    $actorsId = htmlspecialchars($row['id']);
    $actorsName = htmlspecialchars($row['name']);
    $actorsPhoto = htmlspecialchars($row['photo']);
    $actorsMovieCount = htmlspecialchars($row['movie_count']);
    $actorsSeriesCount = htmlspecialchars($row['series_count']);

    echo '<a href="actor_page.php?actor_id=' . $actorsId . '" class="actor_link">';
    echo '<div class="actor_item" id="actor_item_' . $actorsId . '">';
    echo '<img src="' . $actorsPhoto . '" alt="' . $actorsName . '" class="actor_image">';
    echo '<p class="actor_name">';
    echo $actorsName;
    echo '</p>';
    echo '<div class="actor_statistics">';
    echo '' . $actorsMovieCount . ' films ' . $actorsSeriesCount . ' series';
    echo '</div>';
    echo '</div>';
    echo '</a>';
}
?>