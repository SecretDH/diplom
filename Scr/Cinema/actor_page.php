<?php
require __DIR__ . '/../db.php'; // Убедитесь, что путь к db.php корректный

// Получаем ID актера из URL
$actor_id = isset($_GET['actor_id']) ? intval($_GET['actor_id']) : 0;

if ($actor_id <= 0) {
    die("Некорректный ID актера.");
}

// Выполнение SQL-запроса для получения данных актера
$sql = "
    SELECT 
        actors.id, 
        actors.name, 
        actors.photo, 
        actors.bio,
        actors.country,
        actors.birth_date,
        COALESCE(actor_movie_count.movie_count, 0) AS movie_count,
        COALESCE(actor_series_count.series_count, 0) AS series_count
    FROM 
        actors
    LEFT JOIN 
        actor_movie_count ON actors.id = actor_movie_count.actor_id
    LEFT JOIN 
        actor_series_count ON actors.id = actor_series_count.actor_id
    WHERE 
        actors.id = ?
";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $actor_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Актер с указанным ID не найден.");
}

// Получаем данные актера
$actor = mysqli_fetch_assoc($result);

// Проверяем, что данные актера получены
if (!$actor) {
    die("Ошибка при получении данных актера.");
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
    <title><?php echo htmlspecialchars($actor['name']); ?> - Actor Page</title>
    <link rel="stylesheet" type="text/css" href="actor_page.css">
</head>
<body>
    <?php include '../navbar.php'; ?>

    <div class="actor_profile">
        <img src="<?php echo htmlspecialchars($actor['photo']); ?>" alt="<?php echo htmlspecialchars($actor['name']); ?>" class="actor_photo">
        <h1 class="actor_name">
            <?php echo htmlspecialchars($actor['name']); ?>
            <img src="../../Flags/<?php echo htmlspecialchars($actor['country']); ?>.jpg" alt="<?php echo htmlspecialchars($actor['country']); ?>" class="actor_flag">
        </h1>
        <p class="actor_bio"><?php echo nl2br(htmlspecialchars($actor['bio'])); ?></p>
        <div class="actor_statistics">
            <p>Movies: <?php echo htmlspecialchars($actor['movie_count']); ?> Series: <?php echo htmlspecialchars($actor['series_count']); ?></p>
        </div>
    </div>

    <div class="series_container">
        <h1>Filmography</h1>
        <button class="series-scroll-left">&#10142;</button>
        <div class="series_list">
            <?php 
                $actor_id = $actor['id'];
                include 'get_actor_filmography.php'; 
            ?>
        </div>
        <button class="series-scroll-right">&#10142;</button>
    </div>
</body>
</html>