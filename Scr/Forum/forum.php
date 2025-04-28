<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="forum.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginBtn = document.querySelector('.add_post');

            loginBtn.addEventListener('click', function() {
                document.body.classList.add('noscroll');
                // Проверяем, не добавлен ли iframe уже
                if (document.getElementById("SDKiframe")) return;

                // Создаем iframe
                const iframe = document.createElement('iframe');
                iframe.height = "100%";
                iframe.width = "100%";
                iframe.frameBorder = "0";
                iframe.scrolling = "no";
                iframe.allowTransparency = "true";
                iframe.id = "SDKiframe";
                iframe.style = "background: transparent; opacity: 1; position: fixed; left: 0; top: 0; z-index: 9999;";

                // HTML контент внутри iframe
                iframe.src = "add_post.php";

                // Добавляем iframe в конец boady
                document.body.appendChild(iframe);
            });

            // Слушаем сообщения из iframe
            window.addEventListener('message', function(event) {
                if (event.data === 'closeIframe') {
                    document.body.classList.remove('noscroll');
                    const iframe = document.getElementById("SDKiframe");
                    if (iframe) iframe.remove();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = localStorage.getItem('token'); // Получаем токен из localStorage

            if (!token) {
                alert("Пользователь не авторизован.");
                return;
            }

            // Декодируем токен и получаем user_id
            let user_id;
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                user_id = payload.user_id;
            } catch (e) {
                console.error("Ошибка декодирования токена:", e);
                alert("Недействительный токен.");
                return;
            }

            // Добавляем user_id в URL
            const url = new URL(window.location.href);
            url.searchParams.set('user_id', user_id);
            window.history.replaceState({}, '', url);
        });
    </script>
</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="title">
        <h1> Forum </h1>
    </div>
    <div class="conteiner">
        <div class="post_button">
            <div class="add_post">
                <img src="../../Image/add.svg">
                <span> Post</span>
            </div>
        </div>
        <div class="forum_feed">
        <?php
            $user_id = $_GET['user_id'] ?? null;

            if (!$user_id) {
                die("ID пользователя не передан.");
            }

            // Передаем user_id в get_post.php
            include 'get_post.php';
        ?>
        </div>

        <div class="search_bar">
            <input type="txt" name="search" id="search" placeholder="Search" autocomplete="off">
        </div>
    </div>

    <script>
        const maxLength = 300; // Типичное ограничение твиттера
        document.querySelectorAll('.content_block').forEach((post, index) => {
            const fullText = post.querySelector('.post_text_invisible').textContent;
            post.querySelector('.post_text_invisible').textContent = '';
            const postText = post.querySelector('.post_text');
            const toggleBtn = post.querySelector('.read-more');
            let isExpanded = false;

            function updateText() {
                if (fullText.length <= maxLength) {
                    postText.textContent = fullText;
                    toggleBtn.style.display = 'none';
                } else {
                    postText.textContent = isExpanded ? fullText : fullText.slice(0, maxLength) + '...';
                    toggleBtn.textContent = isExpanded ? 'Hide' : 'Show more';
                    toggleBtn.style.display = 'inline-block';
                }
            }

            toggleBtn.addEventListener('click', () => {
                isExpanded = !isExpanded;
                updateText();
            });

            updateText();
        });
    </script>
    <script>
        document.querySelectorAll('.content_block').forEach((post) => {
            const combtn = post.querySelector('#comment_stat');

            combtn.addEventListener('click', () => {
                document.body.classList.add('noscroll');
                const forum_block = document.querySelector('.forum_feed');
                document.querySelectorAll('.content_block').forEach((block) => {
                    block.classList.add('hidden'); // Делаем элементы невидимыми
                });

                const postId = post.getAttribute('data-post-id'); // Получаем ID поста
                const urlParams = new URLSearchParams(window.location.search); // Получаем параметры из URL
                const userId = urlParams.get('user_id'); // Извлекаем user_id

                if (!postId || !userId) {
                    console.error("Post ID или User ID не найден.");
                    return;
                }

                console.log("Post ID:", postId, "User ID:", userId); // Логируем ID поста и пользователя

                const iframe = document.createElement('iframe');
                iframe.style.display = "block";
                iframe.height = "100%";
                iframe.width = "47.7%";
                iframe.frameBorder = "0";
                iframe.scrolling = "yes";
                iframe.allowTransparency = "true";
                iframe.id = "SDKiframe";
                iframe.style = "background: transparent; opacity: 1; position: fixed; left: 0; top: 0; z-index: 999; margin-left: 25.85%";

                // Передаем post_id и user_id в URL iframe
                iframe.src = `comment.php?post_id=${postId}&user_id=${userId}`;

                forum_block.appendChild(iframe);
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