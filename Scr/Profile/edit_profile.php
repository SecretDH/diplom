<?php
require __DIR__ . '/../db.php'; // Подключение к базе данных

// Получаем ID пользователя из URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    die("Некорректный ID пользователя.");
}

// Запрос для получения информации о пользователе
$sql = "
    SELECT 
        login,
        name,
        email,
        avatar,
        description,
        background_image,
        posts,
        followers,
        following,
        pin,
        achivments,
        balance
    FROM 
        users
    WHERE 
        ID = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userInfo) {
    die("Пользователь с указанным ID не найден.");
}

// Присваиваем переменные для удобства
$login = htmlspecialchars($userInfo['login']);
$name = htmlspecialchars($userInfo['name']);
$email = htmlspecialchars($userInfo['email']);
$avatar = htmlspecialchars($userInfo['avatar']);
$description = htmlspecialchars($userInfo['description']);
$background_image = htmlspecialchars($userInfo['background_image']);
$posts = intval($userInfo['posts']);
$followers = intval($userInfo['followers']);
$following = intval($userInfo['following']);
$pin = intval($userInfo['pin']);
$achivments = intval($userInfo['achivments']);
$balance = number_format($userInfo['balance'], 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="edit_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
</head>
<body>
    <?php include '../navbar.php'; ?>
        
    <div class="crop_container" style="display: none;">
        <div class="crop_preview">
            <img id="imagePreview" style="max-width: 100%; display: block;">
        </div>
        <div class="crop_controls">
            <button id="cropButton">
                <img src="../../Image/confirm.svg" alt="">
            </button>
            <button id="deleteCropButton">
                <img src="../../Image/delete.svg" alt="">
            </button>
            <button id="rotate_view">
                <img src="../../Image/rotate.svg" alt="">
            </button>
            <div class="rotate_slider_container" style="display: none;">
                <input type="range" id="rotateSlider" min="-180" max="180" value="0" class="vertical-slider">
                <div id="rotationValue">0°</div>
            </div>
        </div>
    </div>

    <h1 class="edit_title"> Edit profile </h1>

    <div class="edit_container">
        <div class="edit_background">
            <img src="<?php echo $background_image; ?>" class="edit_background_img" id="edit_background_img">
        </div>
        <div class="edit_avatar_container">
            <img src="<?php echo $avatar; ?>" class="edit_avatar_img" id="edit_avatar_img">
            <div class="change_photo">
                <span>Change photo</span>
                <div class="hidden-box" id="hidden-box">
                    <button id="change_avatar_photo_btn" class="change_photo_btn upload_cover">
                        <img src="../../Image/image_white.svg" alt="" class="change_photo_img">
                        <span> Add avatar </span>
                        <input type="file" id="coverInput" accept="image/*" style="display: none;">
                    </button>
                    <button id="change_background_photo_btn" class="change_photo_btn upload_cover">
                        <img src="../../Image/image_white.svg" alt="" class="change_photo_img">
                        <span> Add background </span>
                        <input type="file" id="coverInput" accept="image/*" style="display: none;">
                    </button>
                    <button id="delete_avatar_photo_btn" class="change_photo_btn">
                        <img src="../../Image/delete_white.svg" alt="" class="change_photo_img">
                        <span> Delete avatar </span>
                    </button>
                    <button id="delete_background_photo_btn" class="change_photo_btn">
                        <img src="../../Image/delete_white.svg" alt="" class="change_photo_img">
                        <span> Delete background </span>
                    </button>
                    <button id="close-box"></button>
                </div>
            </div>
        </div>
        <div class="edit_info_container">
            <div class="edit_info">
                <div class="input_container">
                    <input type="text" id="edit_name" placeholder="" value="<?php echo $name; ?>" maxlength="32">
                    <label for="edit_name">Name</label>
                </div>
                <div class="input_container">
                    <input type="text" id="edit_login" value="<?php echo $login; ?>" placeholder=" " maxlength="32">
                    <label for="edit_login">Login</label>
                    <span class="status-icon" id="edit_login_status"></span>
                </div>
                <div class="input_container">
                    <input type="email" id="edit_email" value="<?php echo $email; ?>" placeholder=" " maxlength="32">
                    <label for="edit_email">Email</label>
                    <span class="status-icon" id="edit_email_status"></span>
                </div>
                <div class="input_container">
                    <textarea id="edit_description" placeholder=" " maxlength="460" value="<?php echo $description; ?>"></textarea>
                    <label for="edit_description">Description</label>
                </div>
                <div class="input_container">
                    <input type="password" id="password" placeholder=" " maxlength="64">
                    <label for="password">Password</label>
                </div>
                <div class="input_container">
                    <input type="password" id="new_password" placeholder=" " maxlength="64">
                    <label for="new_password">New password</label>
                    <span class="status-icon" id="new_password_status"></span>
                </div>
                <div class="input_container">
                    <input type="password" id="repeat_password" placeholder=" " maxlength="64">
                    <label for="repeat_password">Repeat password</label>
                    <span class="status-icon" id="repeat_password_status"></span>
                </div>
            </div>
            <div class="password_info">
                <h1> Create a strong password. </h1>
                <span>
                    Your password should be at least 8 characters long and include uppercase and lowercase letters, numbers, and special characters (e.g., !, @, #, $).
                </span><br>
                <span>
                    Avoid simple combinations like "123456" or "password".
                </span><br>
                <span>
                    Do not share your password with anyone or store it in an easily accessible place.
                </span>
            </div>
        </div>
        <div class="save_container">
            <h2> To save all changes please click on the corresponding save button </h2>
            <button class="save_button">Save</button>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Функция для проверки ввода
            function validateInput(input) {
                const statusIcon = document.getElementById(input.id + '_status');
                if (input.value.trim() !== '') {
                    // Устанавливаем изображение птички
                    statusIcon.innerHTML = '<img src="../../Image/confirm.svg" alt="Valid" class="status-image">';
                    statusIcon.classList.remove('invalid');
                    statusIcon.classList.add('valid');
                } else {
                    // Устанавливаем изображение крестика
                    statusIcon.innerHTML = '<img src="../../Image/circle.svg" alt="Invalid" class="status-image">';
                    statusIcon.classList.remove('valid');
                    statusIcon.classList.add('invalid');
                }
            }

            // Добавляем обработчики событий для всех полей ввода
            document.querySelectorAll('.input_container input, .input_container textarea').forEach((input) => {
                input.addEventListener('input', function () {
                    validateInput(input);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const changePhotoButton = document.querySelector('.change_photo');
            const hiddenBox = document.getElementById('hidden-box');
            const closeBoxButton = document.getElementById('close-box');

            // Показать прямоугольник при нажатии на кнопку
            changePhotoButton.addEventListener('click', function (event) {
                hiddenBox.style.display = 'block';
                event.stopPropagation(); // Останавливаем всплытие события
            });

            // Скрыть прямоугольник при нажатии на кнопку "Close"
            closeBoxButton.addEventListener('click', function () {
                hiddenBox.style.display = 'none';
            });

            // Скрыть прямоугольник при клике вне его
            document.addEventListener('click', function (event) {
                if (!hiddenBox.contains(event.target) && event.target !== changePhotoButton) {
                    hiddenBox.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultAvatarPath = '../../Avatars/Defoult_avatar.png';
            const defaultBackgroundPath = '../../Backgrounds/default_background.png';

            const avatarImg = document.getElementById('edit_avatar_img');
            const backgroundImg = document.getElementById('edit_background_img');

            const changeAvatarButton = document.getElementById('change_avatar_photo_btn');
            const deleteAvatarButton = document.getElementById('delete_avatar_photo_btn');

            const changeBackgroundButton = document.getElementById('change_background_photo_btn');
            const deleteBackgroundButton = document.getElementById('delete_background_photo_btn');

            // Функция для проверки пути и обновления кнопок
            function updateButtons(imageElement, changeButton, deleteButton, defaultPath, addText, editText) {
                if (imageElement.src.includes(defaultPath)) {
                    // Если путь совпадает с дефолтным
                    changeButton.querySelector('span').textContent = addText;
                    deleteButton.style.display = 'none'; // Скрываем кнопку удаления
                } else {
                    // Если путь не совпадает с дефолтным
                    changeButton.querySelector('span').textContent = editText;
                    deleteButton.style.display = 'flex'; // Показываем кнопку удаления
                }
            }

            // Инициализация кнопок при загрузке страницы
            updateButtons(avatarImg, changeAvatarButton, deleteAvatarButton, defaultAvatarPath, 'Add avatar', 'Edit avatar');
            updateButtons(backgroundImg, changeBackgroundButton, deleteBackgroundButton, defaultBackgroundPath, 'Add background', 'Edit background');

            // Пример: Обновление кнопок при изменении изображения (если это нужно)
            changeAvatarButton.addEventListener('click', function () {
                // Здесь можно добавить логику для изменения аватара
                console.log('Change avatar clicked');
                updateButtons(avatarImg, changeAvatarButton, deleteAvatarButton, defaultAvatarPath, 'Add avatar', 'Edit avatar');
            });

            changeBackgroundButton.addEventListener('click', function () {
                // Здесь можно добавить логику для изменения фона
                console.log('Change background clicked');
                updateButtons(backgroundImg, changeBackgroundButton, deleteBackgroundButton, defaultBackgroundPath, 'Add background', 'Edit background');
            });

            deleteAvatarButton.addEventListener('click', function () {
                // Подтверждение удаления аватара
                if (confirm('Are you sure you want to delete the avatar?')) {
                    // Устанавливаем дефолтный аватар
                    avatarImg.src = defaultAvatarPath;
                    updateButtons(avatarImg, changeAvatarButton, deleteAvatarButton, defaultAvatarPath, 'Add avatar', 'Edit avatar');
                }
            });

            deleteBackgroundButton.addEventListener('click', function () {
                // Подтверждение удаления фона
                if (confirm('Are you sure you want to delete the background?')) {
                    // Устанавливаем дефолтный фон
                    backgroundImg.src = defaultBackgroundPath;
                    updateButtons(backgroundImg, changeBackgroundButton, deleteBackgroundButton, defaultBackgroundPath, 'Add background', 'Edit background');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Переменные и элементы ---
            const avatarInput = document.querySelector('#change_avatar_photo_btn input[type="file"]');
            const backgroundInput = document.querySelector('#change_background_photo_btn input[type="file"]');
            const cropContainer = document.querySelector('.crop_container');
            const imagePreview = document.getElementById('imagePreview');
            const cropButton = document.getElementById('cropButton');
            const deleteCropButton = document.getElementById('deleteCropButton');
            const rotateButton = document.getElementById('rotate_view');
            const rotateSliderContainer = document.querySelector('.rotate_slider_container');
            const rotateSlider = document.getElementById('rotateSlider');
            const rotationValue = document.getElementById('rotationValue');
            const avatarImg = document.getElementById('edit_avatar_img');
            const backgroundImg = document.getElementById('edit_background_img');
            let cropper = null;
            let currentType = null; // 'avatar' или 'background'

            // --- Открытие диалога выбора файла ---
            document.getElementById('change_avatar_photo_btn').addEventListener('click', (e) => {
                e.stopPropagation();
                currentType = 'avatar';
                avatarInput.click();
            });
            document.getElementById('change_background_photo_btn').addEventListener('click', (e) => {
                e.stopPropagation();
                currentType = 'background';
                backgroundInput.click();
            });

            // --- Обработка выбора файла ---
            function handleFileInput(input, type) {
                input.addEventListener('change', (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            imagePreview.src = e.target.result;
                            cropContainer.style.display = 'flex';
                            rotateSlider.value = 0;
                            rotationValue.textContent = '0°';
                            rotateSliderContainer.style.display = 'none';

                            // Уничтожаем предыдущий cropper
                            if (cropper) cropper.destroy();

                            // Настройки для аватара и фона
                            let aspectRatio, cropWidth, cropHeight;
                            if (type === 'avatar') {
                                aspectRatio = 1;
                                cropWidth = 400;
                                cropHeight = 400;
                            } else {
                                aspectRatio = 1920 / 471;
                                cropWidth = 1920;
                                cropHeight = 471;
                            }

                            cropper = new Cropper(imagePreview, {
                                aspectRatio: aspectRatio,
                                viewMode: 1,
                            });

                            // Сохраняем параметры для дальнейшего использования
                            cropper._cropWidth = cropWidth;
                            cropper._cropHeight = cropHeight;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            handleFileInput(avatarInput, 'avatar');
            handleFileInput(backgroundInput, 'background');

            // --- Обрезка и вставка результата ---
            cropButton.addEventListener('click', () => {
                if (cropper && currentType) {
                    const canvas = cropper.getCroppedCanvas({
                        width: cropper._cropWidth,
                        height: cropper._cropHeight,
                    });
                    if (canvas) {
                        const croppedImage = canvas.toDataURL();
                        if (currentType === 'avatar') {
                            avatarImg.src = croppedImage;
                        } else if (currentType === 'background') {
                            backgroundImg.src = croppedImage;
                        }
                        cropContainer.style.display = 'none';
                        cropper.destroy();
                        cropper = null;
                        currentType = null;
                        rotateSlider.value = 0;
                        rotationValue.textContent = '0°';
                        rotateSliderContainer.style.display = 'none';
                    } else {
                        alert('Ошибка при обрезке изображения.');
                    }
                }
            });

            // --- Удаление обрезки ---
            deleteCropButton.addEventListener('click', () => {
                cropContainer.style.display = 'none';
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                currentType = null;
                rotateSlider.value = 0;
                rotationValue.textContent = '0°';
                rotateSliderContainer.style.display = 'none';
            });

            // --- Поворот изображения ---
            rotateButton.addEventListener('click', () => {
                if (rotateSliderContainer.style.display === 'none' || !rotateSliderContainer.style.display) {
                    rotateSliderContainer.style.display = 'block';
                } else {
                    rotateSliderContainer.style.display = 'none';
                }
            });

            rotateSlider.addEventListener('input', (event) => {
                const rotationDegree = event.target.value;
                rotationValue.textContent = `${rotationDegree}°`;
                if (cropper) {
                    cropper.rotateTo(Number(rotationDegree));
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const saveButton = document.querySelector('.save_button');
            const requiredInputs = [
                document.getElementById('edit_login'),
                document.getElementById('edit_email')
            ];
            const avatarImg = document.getElementById('edit_avatar_img');
            const backgroundImg = document.getElementById('edit_background_img');

            // Функция проверки заполненности
            function checkInputs() {
                let allFilled = true;
                requiredInputs.forEach(input => {
                    if (!input.value.trim()) allFilled = false;
                });
                if (allFilled) {
                    saveButton.classList.add('active');
                    saveButton.disabled = false;
                    saveButton.style.opacity = '1';
                    saveButton.style.cursor = 'pointer';
                } else {
                    saveButton.classList.remove('active');
                    saveButton.disabled = true;
                    saveButton.style.opacity = '0.5';
                    saveButton.style.cursor = 'not-allowed';
                }
            }

            // Проверяем при загрузке и при изменении
            checkInputs();
            requiredInputs.forEach(input => {
                input.addEventListener('input', checkInputs);
            });

            // Обработчик кнопки сохранения
            saveButton.addEventListener('click', function () {
                if (saveButton.disabled) return;

                // Получаем токен из localStorage (или другого места, где вы его храните)
                const token = localStorage.getItem('token');
                let userId;
                try {
                    const payload = JSON.parse(atob(token.split('.')[1])); // Декодируем payload токена
                    userId = payload.user_id;
                } catch (e) {
                    console.error("Ошибка декодирования токена:", e);
                    alert("Недействительный токен.");
                    return;
                }

                function getRelativeAvatarPath(src) {
                    // Если base64 — возвращаем как есть
                    if (src.startsWith('data:image/')) return src;
                    // Если абсолютный путь — преобразуем в относительный
                    const match = src.match(/\/Avatars\/[^\/]+$/);
                    if (match) return '../..' + match[0]; // '../../Avatars/имя.png'
                    return src;
                }

                function getRelativeBackgroundPath(src) {
                    if (src.startsWith('data:image/')) return src;
                    const match = src.match(/\/Backgrounds\/[^\/]+$/);
                    if (match) return '../..' + match[0];
                    return src;
                }

                // Собираем данные
                const data = {
                    user_id: userId,
                    name: document.getElementById('edit_name').value.trim(),
                    login: document.getElementById('edit_login').value.trim(),
                    email: document.getElementById('edit_email').value.trim(),
                    description: document.getElementById('edit_description').value.trim(),
                    password: document.getElementById('password').value,
                    new_password: document.getElementById('new_password').value,
                    repeat_password: document.getElementById('repeat_password').value,
                    avatar: getRelativeAvatarPath(avatarImg.src),
                    background_image: getRelativeBackgroundPath(backgroundImg.src)
                };

                fetch('save_profile_edits.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Если сервер вернул новый путь к аватару, обновляем src
                        if (result.avatar_path) {
                            avatarImg.src = result.avatar_path;
                        }
                        alert('Профиль успешно сохранён!');
                    } else {
                        alert(result.message || 'Ошибка при сохранении профиля');
                    }
                })
                .catch(err => {
                    console.error('Ошибка соединения с сервером:', err);
                    alert('Ошибка соединения с сервером: ' + err);
                });
            });
        });
    </script>
</body>
</html>