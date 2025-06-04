<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comic</title>
    <link rel="stylesheet" type="text/css" href="comic.css">
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="title">
        <h1>Comics</h1>
    </div>
    <img src="../../Image/best_comic.svg" alt="" class="best-comic-image">

    <div class="library_text">
        <h2>Library</h2>
    </div>

    <div class="comic-list">
        <?php include 'get_comic.php'; ?>
    </div>

    <div class="space"></div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('click', (event) => {
                const comicItem = event.target.closest('.comic-item');
                if (comicItem) {
                    const comicId = comicItem.getAttribute('data-comic-id');
                    if (comicId) {
                        // Получаем токен из localStorage
                        const token = localStorage.getItem('token');
                        let userId = null;
                        if (token) {
                            try {
                                const payload = JSON.parse(atob(token.split('.')[1]));
                                userId = payload.user_id;
                            } catch (e) {
                                console.error("Ошибка декодирования токена:", e);
                            }
                        }
                        // Перенаправляем на страницу комикса с передачей ID комикса и user_id (если есть)
                        if (userId) {
                            window.location.href = `comic_page.php?id=${encodeURIComponent(comicId)}&user_id=${encodeURIComponent(userId)}`;
                        } else {
                            window.location.href = `comic_page.php?id=${encodeURIComponent(comicId)}`;
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>