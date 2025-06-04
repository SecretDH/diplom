<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum</title>
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

                // Добавляем iframe в конец body
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
            <input type="text" name="search" id="search" placeholder="Search" autocomplete="off">
        </div>
    </div>

    <script>
        // Функция для обработки текста постов
        function processPostText() {
            const maxLength = 300;
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
        }

        // Функция для обработки кликов по комментариям
        function setupCommentListeners() {
            document.querySelectorAll('.content_block').forEach((post) => {
                const combtn = post.querySelector('#comment_stat');

                combtn.addEventListener('click', () => {
                    // Сохраняем позицию прокрутки
                    localStorage.setItem('scrollPosition', window.scrollY);
                    document.body.scrollTop = window.scrollY; // Для старых браузеров
                    // Сохраняем ID поста (для центрирования, если нужно)
                    localStorage.setItem('activePostId', post.getAttribute('data-post-id'));

                    document.body.classList.add('noscroll');
                    const forum_block = document.querySelector('.forum_feed');
                    document.querySelectorAll('.content_block').forEach((block) => {
                        block.classList.add('hidden');
                    });

                    const postId = post.getAttribute('data-post-id');
                    const urlParams = new URLSearchParams(window.location.search);
                    const userId = urlParams.get('user_id');

                    if (!postId || !userId) {
                        console.error("Post ID или User ID не найден.");
                        return;
                    }

                    console.log("Post ID:", postId, "User ID:", userId);

                    const iframe = document.createElement('iframe');
                    iframe.style.display = "block";
                    iframe.height = "100%";
                    iframe.width = "47.7%";
                    iframe.frameBorder = "0";
                    iframe.scrolling = "yes";
                    iframe.allowTransparency = "true";
                    iframe.id = "CommentIframe"; // Изменён ID
                    iframe.style = "background: transparent; opacity: 1; position: fixed; left: 0; top: 0; z-index: 999; margin-left: 25.85%";
                    iframe.src = `comment.php?post_id=${postId}&user_id=${userId}`;

                    forum_block.appendChild(iframe);
                });
            });
        }

        // Функция для обработки лайков
        function setupLikeListeners() {
            document.querySelectorAll('.like_stat').forEach(div => {
                if (div.getAttribute('data-liked') === 'true') {
                    div.classList.add('liked');
                }

                div.addEventListener('click', function () {
                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert("Пользователь не авторизован.");
                        return;
                    }

                    let user_id;
                    try {
                        const payload = JSON.parse(atob(token.split('.')[1]));
                        user_id = payload.user_id;
                    } catch (e) {
                        console.error("Ошибка декодирования токена:", e);
                        alert("Недействительный токен.");
                        return;
                    }

                    const post_id = div.getAttribute('data-post-id');
                    if (!post_id) {
                        console.error("ID поста не найден.");
                        return;
                    }

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
                        return response.json();
                    })
                    .then(jsonData => {
                        if (jsonData.status === 'success') {
                            console.log(`Действие: ${jsonData.action}, Новое количество лайков: ${jsonData.new_like_count}`);
                            const likeCountElement = div.querySelector('#like_count_' + post_id);
                            if (likeCountElement) {
                                likeCountElement.textContent = jsonData.new_like_count;
                            }

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
        }

        // Функция для обработки репостов
        function setupRepostListeners() {
            document.querySelectorAll('.repost_stat').forEach(div => {
                if (div.getAttribute('data-reposted') === 'true') {
                    div.classList.add('reposted');
                }

                div.addEventListener('click', function () {
                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert("Пользователь не авторизован.");
                        return;
                    }

                    let user_id;
                    try {
                        const payload = JSON.parse(atob(token.split('.')[1]));
                        user_id = payload.user_id;
                    } catch (e) {
                        console.error("Ошибка декодирования токена:", e);
                        alert("Недействительный токен.");
                        return;
                    }

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

                    if (parseInt(user_id) !== parseInt(post_user_id)) {
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
                            return response.json();
                        })
                        .then(jsonData => {
                            if (jsonData.status === 'success') {
                                console.log(`Действие: ${jsonData.action}, Новое количество репостов: ${jsonData.new_repost_count}`);
                                const repostCountElement = div.querySelector('#repost_count_' + post_id);
                                if (repostCountElement) {
                                    repostCountElement.textContent = jsonData.new_repost_count;
                                }

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
                        return;
                    }
                });
            });
        }

        // Функция для инициализации всех обработчиков
        function initializePostHandlers() {
            processPostText();
            setupCommentListeners();
            setupLikeListeners();
            setupRepostListeners();
        }

        // Функция debounce для задержки выполнения
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Функция для выполнения поиска
        const performSearch = debounce(function(searchTerm) {
            const userId = '<?php echo isset($user_id) ? htmlspecialchars($user_id) : ''; ?>';
            console.log('Search term:', searchTerm, 'User ID:', userId); // Отладка
            if (!userId) {
                document.querySelector('.forum_feed').innerHTML = '<p class="error-message">Ошибка: ID пользователя не передан. Проверьте URL.</p>';
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_post.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.querySelector('.forum_feed').innerHTML = xhr.responseText;
                    initializePostHandlers(); // Инициализируем все обработчики для новых постов
                } else {
                    document.querySelector('.forum_feed').innerHTML = '<p class="error-message">Ошибка при загрузке постов (статус: ' + xhr.status + ').</p>';
                }
            };
            xhr.onerror = function() {
                document.querySelector('.forum_feed').innerHTML = '<p class="error-message">Ошибка сети при загрузке постов.</p>';
            };
            xhr.send('search=' + encodeURIComponent(searchTerm) + '&user_id=' + encodeURIComponent(userId));
        }, 500);

        // Слушаем ввод в поле поиска
        document.getElementById('search').addEventListener('input', function(e) {
            performSearch(e.target.value);
        });

        // Инициализируем обработчики для начальных постов
        initializePostHandlers();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Слушаем сообщения от iframe
            window.addEventListener('message', function (event) {
                if (event.data === 'closeIframe') {
                    // Удаляем iframe
                    const iframe = document.getElementById('CommentIframe');
                    if (iframe) {
                        iframe.remove();
                    }

                    // Убираем класс "hidden" у всех постов
                    document.querySelectorAll('.content_block').forEach((block) => {
                        block.classList.remove('hidden');
                    });

                    // Убираем класс "noscroll" с body
                    document.body.classList.remove('noscroll');

                    // Восстанавливаем позицию прокрутки
                    const scrollPosition = localStorage.getItem('scrollPosition');
                    if (scrollPosition) {
                        window.scrollTo(0, parseInt(scrollPosition, 10));
                        localStorage.removeItem('scrollPosition');
                    }
                }
            });
        });
    </script>
</body>
</html>