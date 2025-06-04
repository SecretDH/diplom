<?php
// get_movies.php
require __DIR__ . '../../db.php';

$sql = "
    SELECT 
        movies.id, 
        movies.title,
        movies.duration,
        movies.year, 
        movies.poster, 
        movies.big_poster, 
        movies.created_at
    FROM 
        movies
    ORDER BY 
        movies.created_at DESC
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Ошибка при получении данных: " . mysqli_error($conn);
    exit;
}

// Вывод данных
while ($row = mysqli_fetch_assoc($result)) {
    $movieId = htmlspecialchars($row['id']);
    $movieTitle = htmlspecialchars($row['title']);
    $movieDuration = htmlspecialchars($row['duration']);
    $movieYear = htmlspecialchars($row['year']);
    $moviePoster = htmlspecialchars($row['poster']);
    $movieBigPoster = htmlspecialchars($row['big_poster']);
    $movieCreatedAt = htmlspecialchars($row['created_at']);

    echo '<div class="movie_item" id="movie_item_' . $movieId . '" data-related-id="' . $movieId . '">';
    echo '<img src="../../Image/pin.svg" class="movie_pin">';
    echo '<img src="../../Image/eye.svg" class="movie_eye">';
    echo '<img src="' . $moviePoster . '" class="movie_image" alt="' . $movieTitle . '">';
    echo '<div class="movie_date">' . $movieYear . '</div>';
    echo '<div class="movie_duration">' . ($movieDuration ?: 'No duration available') . ' minutes</div>';

    // Добавляем скрытый шаблон
    echo '<div class="info_box_template" style="display: none;">';
    echo '<div class="info_box_movie">';
    echo '<div class="info_box_title_movie">Pins</div>';
    $user_id = $_GET['user_id'] ?? null;
    $pin_type = 'movie';
    $related_id = $movieId;

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