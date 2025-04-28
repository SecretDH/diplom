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

// Добавляем запись в таблицу views
$viewQuery = "
    INSERT INTO views (user_id, post_id) 
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE viewed_at = CURRENT_TIMESTAMP
";
$viewStmt = mysqli_prepare($conn, $viewQuery);
mysqli_stmt_bind_param($viewStmt, "ii", $user_id, $post_id);
if (!mysqli_stmt_execute($viewStmt)) {
    die("Ошибка при записи просмотра: " . mysqli_error($conn));
}

// Выполнение SQL-запроса для получения данных поста, лайков, просмотров и информации о пользователе
$sql = "
    SELECT 
        forum.*, 
        COALESCE(forum_likes_view.like_count, 0) AS like_count,
        COALESCE(forum_views_view.view_count, 0) AS view_count,
        COALESCE(forum_comments_view.comment_count, 0) AS comment_count,
        COALESCE(forum_reposts_view.repost_count, 0) AS repost_count,
        users.ID AS post_user_id,
        users.name AS user_name,
        users.login AS user_login,
        users.avatar AS user_avatar
    FROM 
        forum
    LEFT JOIN 
        forum_likes_view ON forum.ID = forum_likes_view.post_id
    LEFT JOIN 
        forum_views_view ON forum.ID = forum_views_view.post_id
    LEFT JOIN 
        users ON forum.user_id = users.ID
    LEFT JOIN 
        forum_comments_view ON forum.ID = forum_comments_view.post_id
    LEFT JOIN 
        forum_reposts_view ON forum.ID = forum_reposts_view.post_id
    WHERE 
        forum.ID = ?
";
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

$repostQuery = "SELECT 1 FROM reposts WHERE user_id = ? AND post_id = ?";
$stmt = $pdo->prepare($repostQuery);
$stmt->execute([$user_id, $post_id]);
$isReposted = $stmt->fetch() ? 'true' : 'false';

// Добавляем информацию о лайке в массив $row
$row['is_reposted'] = $isReposted;

// Получаем данные зарегистрированного пользователя
$login_user_query = "SELECT avatar AS user_avatar FROM users WHERE ID = ?";
$stmt = $pdo->prepare($login_user_query);
$stmt->execute([$user_id]);
$login_user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($login_user_data) {
    $row['login_user_avatar'] = $login_user_data['user_avatar'];
} else {
    die("Пользователь с указанным ID не найден.");
}

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
        <h3 class="upload_data"><?php echo htmlspecialchars($row['view_count']); ?> Views</h3>

        <div class="post_stat">
            <div class="stat" id="comment_stat">
                <img src="../../Image/comment.svg"><span><?php echo htmlspecialchars($row['comment_count']); ?></span>
            </div>
            <div class="stat like_stat liked" data-post-id="<?php echo htmlspecialchars($row['ID']); ?>" data-liked="<?php echo $row['is_liked']; ?>">
                <img src="../../Image/like.svg">
                <span id="like_count_<?php echo htmlspecialchars($row['ID']); ?>"><?php echo htmlspecialchars($row['like_count']); ?></span>
            </div>
            <div class="stat repost_stat" data-post-id="<?php echo htmlspecialchars($row['ID']); ?>" data-post-user-id="<?php echo htmlspecialchars($row['post_user_id']); ?>" data-reposted="<?php echo $row['is_reposted']; ?>">
                <img src="../../Image/repost.svg">
                <span id="repost_count_<?php echo htmlspecialchars($row['ID']); ?>"><?php echo htmlspecialchars($row['repost_count']); ?></span>
            </div>
            <div class="stat" id="save_stat">
                <img src="../../Image/save.svg">
                <span><?php echo htmlspecialchars($row['post_save']); ?></span>
            </div>
            <div class="stat" id="share_stat"><img src="../../Image/share.svg"></div>
        </div>
        <div class="add_comment">
            <div class="add_comment_div_textare">
                <img src="<?php echo htmlspecialchars($row['login_user_avatar']); ?>" class="avatar_img" id="login_user_avatar">
                <textarea class="add_comment_textarea" id="autoResize" placeholder="Lets people know your opinion" maxlength="700"></textarea>
            </div>
            <div id="add_comment_preview_container"></div>
            <div class="add_comment_reply_access">
                <img src="../../Image/add_post_image.svg" id="add_comment_image">
                <input type="file" id="add_comment_image_input" accept="image/*, video/*" style="display: none;">

                <img src="../../Image/add_post_gif.svg" id="add_comment_gif">
                <input type="file" id="add_comment_gif_input" accept="image/gif" style="display: none;">

                <div class="add_comment_btn"> Reply </div>
            </div>
        </div>
    </div>
    <div class="commend_feed">
        <?php
            $user_id = $_GET['user_id'] ?? null;

            if (!$user_id) {
                die("ID пользователя не передан.");
            }

            // Передаем user_id в get_post.php
            include 'get_comments.php';
        ?>
    </div>

    <script>
        const add_post_textarea = document.getElementById('autoResize');

        add_post_textarea.addEventListener('input', () => {
            add_post_textarea.style.height = 'auto'; // сбрасываем, чтобы пересчитать
            add_post_textarea.style.height = add_post_textarea.scrollHeight + 'px';    
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('autoResize');
            const commentBtn = document.querySelector('.add_comment_btn');

            textarea.addEventListener('input', () => {
                if (textarea.value.trim().length > 0) {
                    commentBtn.classList.add('active'); // Добавляем класс active
                } else {
                    commentBtn.classList.remove('active'); // Убираем класс active
                }
            });
        });
    </script>

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

    <script>
        const addImageBtn = document.getElementById('add_comment_image');
        const addGifBtn = document.getElementById('add_comment_gif');
        const imageInput = document.getElementById('add_comment_image_input');
        const gifInput = document.getElementById('add_comment_gif_input');
        const previewContainer = document.getElementById('add_comment_preview_container');

        // Общая функция для добавления превью (картинка или гиф)
        function addPreview(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';
                    wrapper.style.display = 'inline-block';
                    wrapper.style.marginLeft = '80px';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '380px';
                    img.style.height = '440px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';

                    const removeBtn = document.createElement('div');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '10px';
                    removeBtn.style.right = '10px';
                    removeBtn.style.background = 'rgba(0, 0, 0, 0.6)';
                    removeBtn.style.color = '#fff';
                    removeBtn.style.width = '40px';
                    removeBtn.style.height = '40px';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.display = 'flex';
                    removeBtn.style.alignItems = 'center';
                    removeBtn.style.justifyContent = 'center';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.fontSize = '30px';

                    removeBtn.addEventListener('click', () => {
                        wrapper.remove();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            }
        }

        addImageBtn.addEventListener('click', () => {
            imageInput.click();
        });

        addGifBtn.addEventListener('click', () => {
            gifInput.click();
        });

        imageInput.addEventListener('change', (event) => {
            for (let file of event.target.files) {
                addPreview(file);
            }
        });

        gifInput.addEventListener('change', (event) => {
            for (let file of event.target.files) {
                // Только gif-файлы
                if (file.type === 'image/gif') {
                    addPreview(file);
                } else {
                    alert('Пожалуйста, выберите только GIF-файлы.');
                }
            }
        });
    </script>

    <script>
        document.querySelector('.add_comment_btn').addEventListener('click', async () => {
            const text = document.querySelector('.add_comment_textarea').value;
            const images = document.querySelector('#add_comment_image_input').files;
            const gif = document.querySelector('#add_comment_gif_input').files;

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
            const post_id = document.querySelector('.comment_block').getAttribute('data-post-id');
            if (!post_id) {
                console.error("ID поста не найден.");
                return;
            }

            const formData = new FormData();
            formData.append('text', text);
            formData.append('user_id', user_id);
            formData.append('post_id', post_id);

            for (let i = 0; i < images.length; i++) {
                formData.append('images[]', images[i]);
            }
            for (let i = 0; i < gif.length; i++) {
                formData.append('images[]', gif[i]);
            }

            try {
                const response = await fetch('upload_comments.php', {
                    method: 'POST',
                    body: formData
                });

                const error_text = await response.text(); // Получаем ответ как текст
                console.log("Raw server response:", error_text);

                try {
                    const result = JSON.parse(error_text); // Парсим JSON
                    if (result.status === "success") {
                        alert(result.message);
                        window.location.reload(); // Перезагружаем страницу
                    } else {
                        console.error("Ошибка:", result.error || "Неизвестная ошибка");
                    }
                } catch (err) {
                    console.error("Ошибка разбора JSON:", err);
                }
            } catch (err) {
                console.error("Ошибка отправки запроса:", err);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.comment_like_stat').forEach(div => {
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

                    // Получаем ID комментария из атрибута data-comment-id
                    const comment_id = div.getAttribute('data-comment-id');
                    if (!comment_id) {
                        console.error("ID комментария не найден.");
                        return;
                    }

                    // Отправляем запрос на сервер
                    fetch('comment_like_toggle.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'user_id': user_id,
                            'comment_id': comment_id
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
                            const likeCountElement = div.querySelector('#comment_feed_like_count_' + comment_id);
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.repost_stat').forEach(div => {
                // Проверяем, стоит ли репост, и добавляем класс "reposted"
                if (div.getAttribute('data-reposted') === 'true') {
                    div.classList.add('reposted');
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

                    const post_user_id = div.getAttribute('data-post-user-id');
                    if (!post_user_id) {
                        console.error("ID поста не найден.");
                        return;
                    }

                    console.log("user_id:", user_id, "post_user_id:", post_user_id);

                    // Проверяем, не является ли пользователь автором поста
                    if (parseInt(user_id) !== parseInt(post_user_id)) {
                        // Отправляем запрос на сервер только если условие не выполнено
                        fetch('repost_toggle.php', {
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
                                console.log(`Действие: ${jsonData.action}, Новое количество репостов: ${jsonData.new_repost_count}`);
                                
                                // Обновляем количество репостов в реальном времени
                                const repostCountElement = div.querySelector('#repost_count_' + post_id);
                                if (repostCountElement) {
                                    repostCountElement.textContent = jsonData.new_repost_count;
                                }

                                // Меняем класс "reposted" в зависимости от действия
                                if (jsonData.action === 'reposted') {
                                    div.classList.add('reposted');
                                    div.setAttribute('data-reposted', 'true');
                                } else if (jsonData.action === 'unreposted') {
                                    div.classList.remove('reposted');
                                    div.setAttribute('data-reposted', 'false');
                                }
                            } else {
                                console.error('Ошибка:', jsonData.error);
                            }
                        })
                        .catch(error => console.error('Ошибка:', error));
                    } else {
                        alert("Вы не можете репостнуть свою собственную публикацию.");
                        return; // Останавливаем выполнение функции
                    }
                });
            });
        });
    </script>
</body>
</html>