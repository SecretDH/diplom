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
            <?php include 'get_post.php'; ?>
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
        document.querySelectorAll('.content_block').forEach((post, index) => {
            const combtn = post.querySelector('#comment_stat');

            combtn.addEventListener('click', () => {
                const forum_block = document.querySelector('.forum_feed');
                document.querySelectorAll('.content_block').forEach((block) => {
                    block.classList.add('hidden'); // Делаем элементы невидимыми
                });
                const postId = post.getAttribute('data-post-id'); // Получаем ID поста
                const iframe = document.createElement('iframe');
                document.body.classList.add('noscroll');
                iframe.display = "block";
                iframe.height = "100%";
                iframe.width = "47.7%";
                iframe.frameBorder = "0";
                iframe.scrolling = "yes";
                iframe.allowTransparency = "true";
                iframe.id = "SDKiframe";
                iframe.style = "background: transparent; opacity: 1; position: fixed; left: 0; top: 0; z-index: 999; margin-left: 25.85%";
                iframe.src = `comment.php?post_id=${postId}`; // Передаем ID поста в URL

                forum_block.appendChild(iframe);
            });
        });
    </script>
</body>

</html>