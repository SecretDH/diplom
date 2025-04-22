<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="profile_info">
        <div>
            <img src="Avatars/Davit_avatar.jpg" class="profile_img" id="avatar-img">
        </div>
        <div>
            <div style="display: flex;">
                <div class="user_info">
                    <p class="user_name" id="username-display">Loading...</p> <!-- Изменено -->
                    <p class="user_login" id="login-display">Loading...</p>
                </div>
                <div class="edit">
                    <p>Edit Profile</p>
                </div>
            </div>
            <div class="user_stats">
                <div class="stat">
                    <p class="big_text" id="posts-display"> Loading... </p>
                    <p class="mini_text"> posts</p>
                </div>
                <div class="stat">
                    <p class="big_text" id="followers-display"> Loading... </p>
                    <p class="mini_text"> followers </p>
                </div>
                <div class="stat">
                    <p class="big_text" id="following-display"> Loading... </p>
                    <p class="mini_text"> following </p>
                </div>
                <div class="stat">
                    <p class="big_text" id="pin-display"> Loading... </p>
                    <p class="mini_text"> pin </p>
                </div>
                <div class="stat">
                    <p class="big_text" id="achivments-display"> Loading... </p>
                    <p class="mini_text"> achievements </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Функция декодирования JWT (с улучшенной обработкой ошибок)
        function parseJwt(token) {
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                return payload;
            } catch (e) {
                console.error('Ошибка декодирования токена:', e);
                return null;
            }
        }

        // 1. Функция для обновления интерфейса (добавьте этот код)
        function updateUserInterface(token) {
            try {
                // Декодируем токен
                const decoded = JSON.parse(atob(token.split('.')[1]));
                
                // Обновляем данные на странице
                document.getElementById('username-display').textContent = decoded.name || decoded.username;
                document.getElementById('login-display').textContent = '@' + decoded.username;
                
                // Обновляем статистику
                document.getElementById('posts-display').textContent = decoded.posts || 0;
                document.getElementById('followers-display').textContent = decoded.followers || 0;
                document.getElementById('following-display').textContent = decoded.following || 0;
                document.getElementById('pin-display').textContent = decoded.pin || 0;
                document.getElementById('achivments-display').textContent = decoded.achivments || 0;
                
                // Обновляем аватар (если есть)
                if (decoded.avatar) {
                    document.querySelectorAll('.avatar_img, .profile_img').forEach(img => {
                        img.src = decoded.avatar;
                    });
                }
                
                console.log('Интерфейс обновлен!', decoded);
            } catch (e) {
                console.error('Ошибка обновления интерфейса:', e);
                window.location.href = 'home.php';
            }
        }

        // 2. Функция обновления токена (ваш существующий код с исправлением)
        async function refreshTokenData() {
            const token = localStorage.getItem('token');
            if (!token) { 
                window.location.href = 'home.php'; 
                return;
            }
            
            try {
                const response = await fetch(`refresh-token.php?token=${encodeURIComponent(token)}`);
                const result = await response.json();
                
                if (result.status === 'success') {
                    localStorage.setItem('token', result.token);
                    updateUserInterface(result.token); // Теперь функция определена
                    console.log('Данные успешно обновлены!');
                }
            } catch (error) {
                console.error('Ошибка обновления:', error);
            }
        }

        // 3. Запускаем при загрузке страницы
        window.addEventListener('load', refreshTokenData);
    </script>
</body>
</html>