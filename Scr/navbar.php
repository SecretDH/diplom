
<div class="nav_bar_navbar">
    <img src="../../Image/logo.png" class="nav_logo_navbar">
    <p class="nav_logo_text_navbar">ASTRALIKS</p>

    <div class="nav-button_navbar">
        <div class="button_navbar">
            <a href="../Home/home.php"><p class="button-text_navbar"> HOME </p></a>
        </div>
        <div class="button_navbar">
            <a href="#"><p class="button-text_navbar"> LIVE ROOM </p></a>
        </div>
        <div class="button_navbar">
            <a href="../Forum/forum.php" id="navbar_forum_scr"><p class="button-text_navbar"> FORUM </p></a>
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

    <a href="../Regestration/register.html">
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
    /* 1vh = 12.9px */
    
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
        height: 105px;
        top: 0;
        background: linear-gradient(0deg,rgba(0, 0, 0, 0) 0%, rgba(19, 12, 36, 0.79) 50%, rgba(14, 9, 29, 1) 100%);
    }
    
    .nav_logo_navbar {
        height: 75px;
        margin-left: 40px;
        margin-top: 30px;
    }
    
    .nav_logo_text_navbar {
        font-family: Helvetica;
        font-size: 24px;
        color: #FFFFFF;
        margin-top: 47px;
        margin-left: 13px;
    }
    
    .nav-button_navbar {
        display: flex;
        margin: auto;
    }

    .navbar_left_space {
        margin-left: auto;
        width: 185px;
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
        margin-right: 40px;
        margin-top: 23px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-100px);
    }
    
    .avatar_navbar.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .avatar_img_navbar {
        margin: auto;
        height: 52px;
        border-radius: 50%;
        border: 1.5px solid #FFFFFF;
    }
    
    .reg_button_navbar {
        position: absolute;
        margin: auto;
        right: 0;
        margin-right: 40px;
        margin-top: 23px;
        opacity: 0;
        width: 270px;
        height: 64px;
        background-color: #FFFFFF;
        border-radius: 20px;
        text-align: center;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-100px);
    }
    
    .reg_button_navbar.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .reg_button_navbar p {
        margin-top: 18px;
        font-family: Helvetica;
        font-size: 24px;
        color: #0E091D;
    }
    
    /* Стили бургер-меню */
    .burger-menu_navbar {
        position: absolute;
        background-color: #241A43;
        border-radius: 20px;
        top: 100px;
        right: 20px;
        width: 605px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px);
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
        height: 30px;
        margin-bottom: 20px;
    }
    
    #permium_button_navbar {
        width: 605px;
        height: 223px;
    }
    
    #premium_img_navbar {
        width: 605px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }
    
    .menu-list_navbar li a {
        display: flex;
        font-family: Helvetica;
        text-decoration: none;
        font-size: 24px;
        color: #FFFFFF;
        display: block;
    }
    
    #log_out_navbar {
        display: flex;
        font-family: Helvetica;
        text-decoration: none;
        font-size: 24px;
        color: #DF3636;
        display: block;
    }
    
    .burger_button_navbar img {
        margin-left: 40px;
        margin-right: 10px;
    }
    
    .burger_button_navbar {
        display: flex;
        margin-top: 26px;
        margin-bottom: 26px;
    }
    
    #buy_premium_navbar {
        height: 60px;
        margin-bottom: 40px;
        margin-top: 20px;
    }
    
    .buy_premium_navbar {
        display: flex;
        margin-left: 20px;
        width: 565px;
        background-color: #FFFFFF;
        border-radius: 20px;
        padding-top: 14px;
        padding-bottom: 14px;
    }
    
    .buy_premium_navbar p {
        margin: auto;
        margin-left: 10px;
        font-family: Helvetica;
        font-size: 24px;
        color: #0E091D;
    }
    
    .buy_premium_navbar img {
        margin: auto;
        margin-right: 0;
        height: 29px;
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

            // Получаем URL аватара из токена
            const avatarUrl = payload.avatar;

            // Устанавливаем аватар в навбаре
            if (avatarUrl) {
                avatarElement.src = avatarUrl;
            }

            // Показываем профиль и скрываем кнопку регистрации
            profileNavbar.classList.add('active');
            regButtonNavbar.classList.remove('active');
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

        // Добавляем user_id в URL ссылки
        const forumLink = document.getElementById('navbar_forum_scr');
        if (forumLink) {
            const url = new URL(forumLink.href, window.location.origin);
            url.searchParams.set('user_id', user_id);
            forumLink.href = url.toString();
        }
    });
</script>