<?php
require __DIR__ . '/../db.php';

// Получаем ID комикса из URL
$comic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($comic_id <= 0) {
    die("Некорректный ID комикса.");
}

// Добавляем просмотр, если user_id передан и такого просмотра ещё нет
if ($user_id > 0) {
    $check_sql = "SELECT 1 FROM comic_views WHERE comic_id = ? AND user_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $comic_id, $user_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) === 0) {
        $insert_sql = "INSERT INTO comic_views (comic_id, user_id) VALUES (?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ii", $comic_id, $user_id);
        mysqli_stmt_execute($insert_stmt);
        mysqli_stmt_close($insert_stmt);
    }
    mysqli_stmt_close($check_stmt);
}

// Запрос для получения информации о комиксе, среднего рейтинга и количества просмотров
$sql = "
    SELECT 
        comics.id,
        comics.title,
        comics.description,
        comics.plot,
        comics.image,
        comics.background_image,
        comics.release_date,
        comics.create_at,
        COALESCE(car.avg_rating, 0) AS average_rating,
        COALESCE(cvc.views, 0) AS views
    FROM comics
    LEFT JOIN comic_avg_rating AS car ON comics.id = car.comic_id
    LEFT JOIN comic_views_count AS cvc ON comics.id = cvc.comic_id
    WHERE comics.id = ?
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $comic_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Комикс с указанным ID не найден.");
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Ошибка при получении данных.");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comic</title>
    <link rel="stylesheet" type="text/css" href="comic_page.css">
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="background">
        <div class="filter"></div>
        <img src="../../Comic/<?php echo htmlspecialchars($data['background_image']); ?>" alt="" class="background-image">
        <img src="../../Comic/background_gradient.png" alt="" class="background-gradient">
    </div>

    <div class="title">
        <h1>Comics</h1>
    </div>

    <div class="comic-details">
        <div class="comic-image">
            <img src="../../Comic/<?php echo htmlspecialchars($data['image']); ?>" alt="<?php echo htmlspecialchars($data['title']); ?>">
        </div>
        <div class="comic-info">
            <h2><?php echo htmlspecialchars($data['title']); ?></h2>

            <p class="average-rating"> Rating <br> <?php echo number_format($data['average_rating'], 1); ?> <img src="../../Image/raiting_star.svg" alt=""></p>
            <p class="views">Views <br> <?php echo htmlspecialchars($data['views']); ?> <img src="../../Image/view.svg" alt=""> </p>

            <button class="rate_btn">
                Rate
            </button>

            <p class="description_title"> Description </p>
            <p class="description_text">
                <?php echo nl2br(htmlspecialchars($data['description'])); ?>
            </p>
            <p class="plot_title"> Plot </p>
            <p class="plot_text">
                <?php echo nl2br(htmlspecialchars($data['plot'])); ?>
            </p>
        </div>
    </div>

    <div id="rate_modal" class="modal">
        <div class="modal_content">
            <h2>Your rate</h2>
            <div class="rating_buttons">
                <button class="rating_button" data-rating="1">1</button>
                <button class="rating_button" data-rating="2">2</button>
                <button class="rating_button" data-rating="3">3</button>
                <button class="rating_button" data-rating="4">4</button>
                <button class="rating_button" data-rating="5">5</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rateBtn = document.querySelector('.rate_btn');
            const modal = document.getElementById('rate_modal');
            const ratingButtons = document.querySelectorAll('.rating_button');

            // Показать модальное окно при нажатии на кнопку "Rate"
            rateBtn.addEventListener('click', () => {
                modal.style.display = 'flex';
            });

            // Закрыть модальное окно при выборе оценки
            ratingButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const rating = button.getAttribute('data-rating');
                    alert(`You rated the Comic: ${rating} stars`);
                    modal.style.display = 'none';
                });
            });

            // Закрыть модальное окно при клике вне контента
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ratingButtons = document.querySelectorAll('.rating_button');

            ratingButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const rating = button.getAttribute('data-rating');

                    // Получаем токен из localStorage
                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert("Пользователь не авторизован.");
                        return;
                    }

                    // Извлекаем user_id из токена
                    const payload = parseJwt(token);
                    const userId = payload && payload.user_id ? payload.user_id : null;

                    if (!userId) {
                        alert("Не удалось получить ID пользователя.");
                        return;
                    }

                    // Объявляем переменные вне блока if/else
                    let comicId = 0;
                    comicId = <?php echo htmlspecialchars($data['id']); ?>; // ID фильма

                    fetch('comic_rate_handler.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `user_id=${userId}&rating=${rating}&comic_id=${comicId}`,
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Показываем сообщение об успехе
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                    });
                });
            });
        });

        // Функция для декодирования JWT
        function parseJwt(token) {
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                return payload;
            } catch (e) {
                console.error('Ошибка декодирования токена:', e);
                return null;
            }
        }
    </script>
</body>
</html>