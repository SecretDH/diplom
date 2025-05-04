<?php
require __DIR__ . '../../db.php';

// Проверяем, что пользователь авторизован (если требуется)
// if (!isset($user_id)) {
//     echo "Ошибка: ID пользователя не передан.";
//     exit;
// }

// Запрос к таблице moimoviesves
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
    $moviesId = htmlspecialchars($row['id']);
    $moviesTitle = htmlspecialchars($row['title']);
    $moviesDuration = htmlspecialchars($row['duration']);
    $moviesYear = htmlspecialchars($row['year']);
    $moviesPoster = htmlspecialchars($row['poster']);
    $moviesBigPoster = htmlspecialchars($row['big_poster']);
    $moviesCreatedAt = htmlspecialchars($row['created_at']);

    echo '<div class="movie_item" id="movie_item_' . $moviesId . '">';
    echo '<img src="../../Image/pin.svg" class="movie_pin">';
    echo '<img src="../../Image/eye.svg" class="movie_eye">';
    echo '<img src="' . $moviesPoster . '" class="movie_image" alt="' . $moviesTitle . '">';
    echo '<div class="movie_date">' . $moviesYear . '</div>';
    echo '<div class="movie_duration">' . ($moviesDuration ?: 'No duration available') . ' minutes </div>';
    echo '</div>';
}
?>