<?php
require __DIR__ . '/../db.php'; // Убедитесь, что путь к db.php корректный

// Получаем ID поста из URL
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if ($post_id <= 0) {
    die("Некорректный ID поста.");
}

// Получаем ID текущего пользователя из URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    die("ID пользователя не передан.");
}

// Выполнение SQL-запроса для получения данных конкретного поста
$sql = "SELECT * FROM forum WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Пост с указанным ID не найден.");
}

// Получаем данные поста
$row = mysqli_fetch_assoc($result);

// Проверяем, поставлен ли лайк текущим пользователем
$likeQuery = "SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?";
$stmt = $pdo->prepare($likeQuery);
$stmt->execute([$user_id, $post_id]);
$isLiked = $stmt->fetch() ? 'true' : 'false';

// Добавляем информацию о лайке в массив $row
$row['is_liked'] = $isLiked;

// Декодируем JSON с изображениями
$images = json_decode($row['post_image'], true);
$main_image = !empty($images) ? $images[0] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="comment.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const closeBtn = document.querySelector('.add_post_background');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    window.parent.postMessage('closeIframe', '*');
                });
            }
        });
    </script>
</head>
<body>

    <div class="comment_block" data-post-id="<?php echo htmlspecialchars($row['ID']); ?>">

        <div class="user_info">
            <img src="<?php echo htmlspecialchars($row['user_avatar']); ?>" class="avatar_img">
            <div class="user-name-display">
                <h1 class="user_name"><?php echo htmlspecialchars($row['user_name']); ?></h1>
                <h2 class="user_login"> @
                    <?php 
                        if (htmlspecialchars($row['user_login'])) {
                            echo htmlspecialchars($row['user_login']);
                        } else {
                            echo htmlspecialchars($row['user_name']);
                        }
                    ?>
                </h2>
            </div>
        </div>

        <img src="../../Image/union.svg" class="union_img">

        <div class="post_text">
            <h2><?php echo htmlspecialchars($row['post_text']); ?></h2>
        </div>
        <span class="read-more" style="display: none;">Show more</span>
        <img src="<?php echo htmlspecialchars($main_image); ?>" class="content_image">
 
        <h3 class="upload_data"><?php echo date('H:i', strtotime($row['post_date'])); ?></h3>
        <span class="dot"></span>
        <h3 class="upload_data"><?php echo date('M d', strtotime($row['post_date'])); ?></h3>
        <span class="dot"></span>
        <h3 class="upload_data"><?php echo htmlspecialchars($row['post_view']); ?> Views</h3>

        <div class="post_stat">
            <div class="stat" id="comment_stat"><img src="../../Image/comment.svg"><span><?php echo htmlspecialchars($row['post_comment']); ?></span></div>
            <div class="stat like_stat liked" data-post-id="<?php echo htmlspecialchars($row['ID']); ?>" data-liked="<?php echo $row['is_liked']; ?>">
                <img src="../../Image/like.svg">
                <span id="like_count_<?php echo htmlspecialchars($row['ID']); ?>"><?php echo htmlspecialchars($row['post_like']); ?></span>
            </div>
            <div class="stat" id="repost_stat"><img src="../../Image/repost.svg"><span><?php echo htmlspecialchars($row['post_retweet']); ?></span></div>
            <div class="stat" id="save_stat"><img src="../../Image/save.svg"><span><?php echo htmlspecialchars($row['post_save']); ?></span></div>
            <div class="stat" id="share_stat"><img src="../../Image/share.svg"></div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.like_stat').forEach(div => {
            // Проверяем, стоит ли лайк, и добавляем класс "liked"
            if (div.getAttribute('data-liked') === 'true') {
                div.classList.add('liked');
            }

            div.addEventListener('click', function () {
                // Получаем токен из localStorage
                const token = localStorage.getItem('token');
                if (!token) {
                    alert("Пользователь не авторизован.");
                    return;
                }

                // Декодируем токен
                let user_id;
                try {
                    const payload = JSON.parse(atob(token.split('.')[1]));
                    user_id = payload.user_id;
                } catch (e) {
                    console.error("Ошибка декодирования токена:", e);
                    alert("Недействительный токен.");
                    return;
                }

                // Получаем ID поста из атрибута data-post-id
                const post_id = div.getAttribute('data-post-id');
                if (!post_id) {
                    console.error("ID поста не найден.");
                    return;
                }

                // Отправляем запрос на сервер
                fetch('like_toggle.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'user_id': user_id,
                        'post_id': post_id
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Ожидаем JSON-ответ
                })
                .then(jsonData => {
                    if (jsonData.status === 'success') {
                        console.log(`Действие: ${jsonData.action}, Новое количество лайков: ${jsonData.new_like_count}`);
                        
                        // Обновляем количество лайков в реальном времени
                        const likeCountElement = div.querySelector('#like_count_' + post_id);
                        if (likeCountElement) {
                            likeCountElement.textContent = jsonData.new_like_count;
                        }

                        // Меняем класс "liked" в зависимости от действия
                        if (jsonData.action === 'liked') {
                            div.classList.add('liked');
                            div.setAttribute('data-liked', 'true');
                        } else if (jsonData.action === 'unliked') {
                            div.classList.remove('liked');
                            div.setAttribute('data-liked', 'false');
                        }
                    } else {
                        console.error('Ошибка:', jsonData.error);
                    }
                })
                .catch(error => console.error('Ошибка:', error));
            });
        });
    });
    </script>
</body>
</html>