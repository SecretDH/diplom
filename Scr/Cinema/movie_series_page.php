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
            movies.big_description,
            movies.duration,
            movies.year, 
            movies.poster, 
            movies.big_poster, 
            movies.created_at,
            COALESCE(movie_ratings_view.average_rating, 0) AS average_rating
        FROM 
            movies
        LEFT JOIN 
            movie_ratings_view ON movies.id = movie_ratings_view.movie_id
        WHERE 
            movies.id = ?
    ";
    $id = $movie_id;
    $type = 'movie'; // Определяем тип (фильм или сериал)
} elseif ($series_id > 0) {
    // Запрос для сериала
    $sql = "
        SELECT 
            series.id, 
            series.title,
            series.description,
            series.big_description,
            series.duration, 
            series.year, 
            series.poster, 
            series.big_poster, 
            series.created_at,
            COALESCE(series_ratings_view.average_rating, 0) AS average_rating
        FROM 
            series
        LEFT JOIN 
            series_ratings_view ON series.id = series_ratings_view.series_id
        WHERE 
            series.id = ?
    ";
    $id = $series_id;
    $type = 'series'; // Определяем тип (фильм или сериал)
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
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
</head>
<body>
    <?php include '../navbar.php'; ?>

    <video id="player" controls>
        <source src="../../Video/test.mp4" type="video/mp4" />
    </video>
    <button id="return_btn" class="return_btn">Return</button>

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
            <div class="info">
                <p><?php echo htmlspecialchars($data['description']); ?></p>
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
            <p>
                <?php 
                echo nl2br(str_replace('\n', PHP_EOL, htmlspecialchars($data['big_description']))); 
                ?>
            </p>
        </div>
        <div class="rate">
            <div class="rate_item">
                <div class="rate_info">
                    <img src="../../Image/raiting_star.svg" class="rate_star" alt="Star">
                    <span><?php echo htmlspecialchars($data['average_rating']); ?></span>
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

    <div class="page_space"></div>

    <script>
        const player = new Plyr('#player');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const watchBtn = document.querySelector('.watch_btn'); // Кнопка "Watch"
            const returnBtn = document.getElementById('return_btn'); // Кнопка "Return"
            const movieSeriesPage = document.querySelector('.movie_series_page'); // Контейнер фильма/сериала
            const similarSection = document.querySelector('.similar'); // Секция "Similar"
            const player = document.getElementById('player'); // Видео-плеер

            // Обработчик для кнопки "Watch"
            watchBtn.addEventListener('click', () => {
                // Делаем элементы прозрачными
                movieSeriesPage.classList.add('hidden');
                similarSection.classList.add('hidden');

                // Показываем плеер и кнопку "Return"
                player.style.display = 'block';
                returnBtn.style.display = 'block';
            });

            // Обработчик для кнопки "Return"
            returnBtn.addEventListener('click', () => {
                // Убираем прозрачность с элементов
                movieSeriesPage.classList.remove('hidden');
                similarSection.classList.remove('hidden');

                // Скрываем плеер и кнопку "Return"
                player.style.display = 'none';
                returnBtn.style.display = 'none';
            });
        });
    </script>

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
                    alert(`You rated the film: ${rating} stars`);
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
                    let movieId = 0;
                    let seriesId = 0;

                    if ("<?php echo htmlspecialchars($type); ?>" === "movie") {
                        movieId = <?php echo htmlspecialchars($movie_id); ?>; // ID фильма
                    } else {
                        seriesId = <?php echo htmlspecialchars($series_id); ?>; // ID сериала
                    }

                    fetch('rate_handler.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `user_id=${userId}&rating=${rating}&movie_id=${movieId}&series_id=${seriesId}`,
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ratingContainer = document.querySelector('.raiting'); // Контейнер для звезд
            const averageRating = <?php echo htmlspecialchars($data['average_rating']); ?>; // Получаем рейтинг из PHP

            // Функция для обновления звезд
            function updateStars(rating) {
                ratingContainer.innerHTML = ''; // Очищаем контейнер

                // Добавляем заполненные звезды
                for (let i = 0; i < Math.floor(rating); i++) {
                    const star = document.createElement('img');
                    star.src = '../../Image/raiting_star.svg';
                    star.classList.add('star');
                    star.alt = 'Star';
                    ratingContainer.appendChild(star);
                }

                // Добавляем пустые звезды
                for (let i = Math.floor(rating); i < 5; i++) {
                    const emptyStar = document.createElement('img');
                    emptyStar.src = '../../Image/raiting_star_empty.svg';
                    emptyStar.classList.add('star');
                    emptyStar.alt = 'Empty Star';
                    ratingContainer.appendChild(emptyStar);
                }
            }

            // Обновляем звезды на основе среднего рейтинга
            updateStars(averageRating);
        });
    </script>
</body>
</html>