<?php
require __DIR__ . '/../db.php'; // Убедитесь, что путь к db.php корректный

// Получаем ID фильма или сериала из URL
$movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : 0;
$series_id = isset($_GET['series_id']) ? intval($_GET['series_id']) : 0;

if ($movie_id <= 0 && $series_id <= 0) {
    die("Некорректный ID фильма или сериала.");
}

// Определяем, какой запрос выполнять
if ($movie_id > 0) {
    // Запрос для фильма
    $sql = "
        SELECT 
            movies.id, 
            movies.title,
            movies.description,
            movies.duration, 
            movies.year, 
            movies.poster, 
            movies.big_poster, 
            movies.created_at
        FROM 
            movies
        WHERE 
            movies.id = ?
    ";
    $id = $movie_id;
} elseif ($series_id > 0) {
    // Запрос для сериала
    $sql = "
        SELECT 
            series.id, 
            series.title,
            series.description,
            series.duration, 
            series.year, 
            series.poster, 
            series.big_poster, 
            series.created_at
        FROM 
            series
        WHERE 
            series.id = ?
    ";
    $id = $series_id;
}

// Выполняем запрос
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Фильм или сериал с указанным ID не найден.");
}

// Получаем данные фильма или сериала
$data = mysqli_fetch_assoc($result);

// Проверяем, что данные получены
if (!$data) {
    die("Ошибка при получении данных.");
}

// Закрываем соединение с базой данных
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title']); ?></title>
    <link rel="stylesheet" type="text/css" href="movie_series_page.css">
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="movie_series_page">
        <div class="poster_container">
            <img src="<?php echo htmlspecialchars($data['big_poster']); ?>" alt="<?php echo htmlspecialchars($data['title']); ?>" class="movie_poster">
            <div class="filtr"></div>
            <div class="poster_gradient"></div>
        </div>
        <div class="content">
            <h1 class="title"><?php echo htmlspecialchars($data['title']); ?></h1>
            <div class="raiting">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star_empty.svg" class="star" alt="Star">
            </div>
            <div class="watch_btn">
                <span>Watch</span>
            </div>
        </div>
    </div>
    <div class="similar">
        <h1>Similar</h1>
        <div class="similar_list">
            <?php include 'get_similar.php'; ?>
        </div>
    </div>

    <div class="actors_container">
        <h1>Actors</h1>
        <div class="actors_list">
            <?php 
            $id = $movie_id > 0 ? $movie_id : $series_id; // Определяем, что передать
            $type = $movie_id > 0 ? 'movie' : 'series'; // Определяем тип (фильм или сериал)
            include 'get_movie_actors.php'; 
            ?>
        </div>
    </div>

    <div class="about_rate">
        <div class="about">
            <h1>About the film</h1>
            <p><?php echo htmlspecialchars($data['description']); ?></p>
        </div>
        <div class="rate">
            <div class="rate_item">
                <div class="rate_info">
                    <img src="../../Image/raiting_star.svg" class="rate_star" alt="Star">
                    <span>8.5</span>
                    <div>
                        <h3>Astraliks Rating</h3>
                        <h4>Share your opinion about the film</h4>
                    </div>
                </div>
                <div class="rate_btn">
                    <span>Rate</span>
                </div>
            </div>
        </div>
    </div>

    <div class="page_space"></div>
</body>
</html>