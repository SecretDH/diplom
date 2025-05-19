
<div class="nav_bar_navbar">
    <img src="../../Image/logo.png" class="nav_logo_navbar">
    <p class="nav_logo_text_navbar">ASTRALIKS</p>

    <div class="nav-button_navbar">
        <div class="button_navbar">
            <a href="../Home/home.php"><p class="button-text_navbar"> HOME </p></a>
        </div>
        <div class="button_navbar">
            <a href="../Cinema/Cinema.php" class="navbar_scr"><p class="button-text_navbar"> CINEMA </p></a>
        </div>
        <div class="button_navbar">
            <a href="#"><p class="button-text_navbar"> LIVE ROOM </p></a>
        </div>
        <div class="button_navbar">
            <a href="../Forum/forum.php" class="navbar_scr"><p class="button-text_navbar"> FORUM </p></a>
        </div>
        <div class="button_navbar">
            <a href="#"><p class="button-text_navbar"> SHOP </p></a>
        </div>
        <div class="button_navbar">
            <a href="#"><p class="button-text_navbar"> LIBRARY </p></a>
        </div>
        <div class="button_navbar">
            <a href="#"><p class="button-text_navbar"> COMIC </p></a>
        </div>
    </div>

    <div class="navbar_left_space"></div>

    <div class="avatar_navbar">
        <img src="../../Avatars/Davit_avatar.jpg" class="avatar_img_navbar" id="avatar_navbar">
    </div>

    <a href="../Regestration/register.php">
        <div class="reg_button_navbar">
            <p> Log in / Sing up </p>
        </div>
    </a>

    <nav class="burger-menu_navbar" id="burgerMenu_navbar">
        <ul class="menu-list_navbar">
            <li id="premium_button_navbar"><a href="#"> <img src="../../Image/premium.svg" id="premium_img_navbar"> </a></li>
            <li id="buy_premium_navbar"><a href="#"> <div class="buy_premium_navbar"> <img src="../../Image/logo_black.svg"> <p> Buy Premium </p> </div> </a></li>
            <li id="burger_button_navbar"><a href="../Profile/profile.php"> <div class="burger_button_navbar"> <img src="../../Image/bell.svg"> Profile </div> </a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/bell.svg"> Notification </div> </a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/message_circle.svg"> Comments </div></a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/mail.svg"> Personal message </div></a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/rotate_story.svg"> Story </div></a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/friends.svg"> Friends </div></a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/star.svg"> Favorites </div></a></li>
            <li id="burger_button_navbar"><a href="#"> <div class="burger_button_navbar"> <img src="../../Image/settings.svg"> Settings </div></a></li>
            <li id="burger_button_navbar"><a href="#" id="log_out_navbar"> <div class="burger_button_navbar"> <img src="../../Image/log_out.svg"> Log out </div></a></li>
        </ul>
    </nav>
</div>




<style>
    html {
        font-size: 16px;
    }

    p {
        margin: 0;
    }

    a {
        text-decoration: none;
    }

    @font-face {
        font-family: Peace Sans;
        src: url(../../Font/ofont.ru_Peace.ttf);
    }

    @font-face {
        font-family: Intro;
        src: url(../../Font/SCP_Font.otf);
    }

    @font-face {
        font-family: Helvetica;
        src: url(../../Font/helveticaneueltstd_blk.otf);
    }

    .nav_bar_navbar {
        z-index: 1000;
        position: sticky;
        display: flex;
        width: 100%;
        height: 6.5625rem;
        top: 0;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0) 0%, rgba(19, 12, 36, 0.79) 50%, rgba(14, 9, 29, 1) 100%);
    }

    .nav_logo_navbar {
        height: 4.6875rem;
        margin-left: 2.5rem;
        margin-top: 1.875rem;
    }

    .nav_logo_text_navbar {
        font-family: Helvetica;
        font-size: 1.5rem;
        color: #FFFFFF;
        margin-top: 2.9375rem;
        margin-left: 0.8125rem;
    }

    .nav-button_navbar {
        display: flex;
        margin: auto;
    }

    .navbar_left_space {
        width: 11.5625rem;
    }

    .button_navbar {
        margin-right: 2vw;
        margin-left: 2vw;
    }

    .button-text_navbar {
        font-family: Helvetica;
        color: #FFFFFF;
        font-size: 1vw;
    }

    .avatar_navbar {
        cursor: pointer;
        position: absolute;
        margin: auto;
        right: 0;
        margin-right: 2.5rem;
        margin-top: 1.4375rem;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-6.25rem);
    }

    .avatar_navbar.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .avatar_img_navbar {
        margin: auto;
        height: 3.25rem;
        border-radius: 50%;
        border: 0.09375rem solid #FFFFFF;
    }

    .reg_button_navbar {
        position: absolute;
        margin: auto;
        right: 0;
        margin-right: 2.5rem;
        margin-top: 1.4375rem;
        opacity: 0;
        width: 16.875rem;
        height: 4rem;
        background-color: #FFFFFF;
        border-radius: 1.25rem;
        text-align: center;
        visibility: hidden;
        transform: translateY(-6.25rem);
    }

    .reg_button_navbar.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .reg_button_navbar p {
        margin-top: 1.125rem;
        font-family: Helvetica;
        font-size: 1.5rem;
        color: #0E091D;
    }

    /* Стили бургер-меню */
    .burger-menu_navbar {
        position: absolute;
        background-color: #241A43;
        border-radius: 1.25rem;
        top: 6.25rem;
        right: 1.25rem;
        width: 37.8125rem;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-1.25rem);
        transition: all 0.3s ease;
        z-index: 100;
    }

    .burger-menu_navbar.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .menu-list_navbar {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #burger_button_navbar {
        height: 1.875rem;
        margin-bottom: 1.25rem;
    }

    #permium_button_navbar {
        width: 37.8125rem;
        height: 13.9375rem;
    }

    #premium_img_navbar {
        width: 37.8125rem;
        border-top-left-radius: 1.25rem;
        border-top-right-radius: 1.25rem;
    }

    .menu-list_navbar li a {
        display: flex;
        font-family: Helvetica;
        text-decoration: none;
        font-size: 1.5rem;
        color: #FFFFFF;
        display: block;
    }

    #log_out_navbar {
        display: flex;
        font-family: Helvetica;
        text-decoration: none;
        font-size: 1.5rem;
        color: #DF3636;
        display: block;
    }

    .burger_button_navbar img {
        margin-left: 2.5rem;
        margin-right: 0.625rem;
    }

    .burger_button_navbar {
        display: flex;
        margin-top: 1.625rem;
        margin-bottom: 1.625rem;
    }

    #buy_premium_navbar {
        height: 3.75rem;
        margin-bottom: 2.5rem;
        margin-top: 1.25rem;
    }

    .buy_premium_navbar {
        display: flex;
        margin-left: 1.25rem;
        width: 35.3125rem;
        background-color: #FFFFFF;
        border-radius: 1.25rem;
        padding-top: 0.875rem;
        padding-bottom: 0.875rem;
    }

    .buy_premium_navbar p {
        margin: auto;
        margin-left: 0.625rem;
        font-family: Helvetica;
        font-size: 1.5rem;
        color: #0E091D;
    }

    .buy_premium_navbar img {
        margin: auto;
        margin-right: 0;
        height: 1.8125rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = localStorage.getItem('token'); // Получаем токен из localStorage

        if (!token) {
            console.warn("Пользователь не авторизован.");
            return;
        }

        // Декодируем токен и получаем user_id
        let user_id;
        try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            user_id = payload.user_id;
        } catch (e) {
            console.error("Ошибка декодирования токена:", e);
            return;
        }

        // Добавляем user_id в URL ссылки на профиль
        const profileLink = document.querySelector('a[href="../Profile/profile.php"]');
        if (profileLink) {
            const url = new URL(profileLink.href, window.location.origin);
            url.searchParams.set('user_id', user_id);
            profileLink.href = url.toString();
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatar = document.getElementById('avatar_navbar');
        const burgerMenu = document.getElementById('burgerMenu_navbar');
        
        // Обработчик клика по аватару
        avatar.addEventListener('click', function(e) {
            e.stopPropagation(); // Предотвращаем всплытие события
            burgerMenu.classList.toggle('active');
        });
        
        // Закрываем меню при клике в любом месте страницы
        document.addEventListener('click', function() {
            burgerMenu.classList.remove('active');
        });
        
        // Предотвращаем закрытие меню при клике внутри него
        burgerMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const profile = document.querySelector('.avatar_navbar');
        const reg_button_navbar = document.querySelector('.reg_button_navbar');
        if (localStorage.getItem('token')) {
            profile.classList.add('active');
            reg_button_navbar.classList.remove('active');
        } else {
            reg_button_navbar.classList.add('active');
            profile.classList.remove('active');
        }
    });

    function logout() {
        // 1. Удаляем токен из localStorage
        localStorage.removeItem('token');
        
        // 2. Перенаправляем на страницу входа
        window.location.href = '../Home/home.php';
        
        // 3. Опционально: можно добавить подтверждение
        // if (!confirm('Вы уверены, что хотите выйти?')) return;
        // hl@ vor chem avelacni
    }

    // Вешаем обработчик на кнопку
    document.getElementById('log_out_navbar').addEventListener('click', logout);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarElement = document.getElementById('avatar_navbar');
        const regButtonNavbar = document.querySelector('.reg_button_navbar');
        const profileNavbar = document.querySelector('.avatar_navbar');

        // Проверяем наличие токена
        const token = localStorage.getItem('token');
        if (token) {
            try {
                // Декодируем токен (предполагается, что это JWT)
                const payload = JSON.parse(atob(token.split('.')[1]));

                // Показываем профиль и скрываем кнопку регистрации
                profileNavbar.classList.add('active');
                regButtonNavbar.classList.remove('active');

                // --- ДОБАВЛЕНО: Получаем актуальный аватар из базы через PHP ---
                const user_id = payload.user_id;
                if (user_id) {
                    fetch('../Profile/get_avatar.php?user_id=' + encodeURIComponent(user_id))
                        .then(res => res.json())
                        .then(data => {
                            if (data.avatar) {
                                avatarElement.src = data.avatar;
                            }
                        })
                        .catch(err => {
                            console.error('Ошибка получения актуального аватара:', err);
                        });
                }
                // --- КОНЕЦ ДОБАВЛЕНИЯ ---
            } catch (error) {
                console.error('Ошибка декодирования токена:', error);
            }
        } else {
            // Если токена нет, показываем кнопку регистрации и скрываем профиль
            regButtonNavbar.classList.add('active');
            profileNavbar.classList.remove('active');
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    if (!token) return;

    let user_id;
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        user_id = payload.user_id;
    } catch (e) {
        console.error("Ошибка декодирования токена:", e);
        return;
    }

    // Массив классов ссылок, куда нужно добавить user_id
    const linkClasses = [
        '.navbar_scr'
    ];

    linkClasses.forEach(selector => {
        document.querySelectorAll(selector).forEach(link => {
            const url = new URL(link.href, window.location.origin);
            url.searchParams.set('user_id', user_id);
            link.href = url.toString();
        });
    });
});
</script>