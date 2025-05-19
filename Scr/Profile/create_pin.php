<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Pin</title>
    <link rel="stylesheet" type="text/css" href="create_pin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
</head>
<body>
    <?php include '../navbar.php'; ?>

    <div class="upload_flex">

        <div class="upload_cover">
            <img src="../../Image/pin_cover_upload.svg" alt="">
            <span>Drop your image here or click to upload.</span>
            <input type="file" id="coverInput" accept="image/*" style="display: none;">
        </div>

        <div class="upload_info">
            <div class="input_container">
                <input type="text" id="pinText" placeholder=" " maxlength="32">
                <label for="pinText">Title</label>
            </div>
            <div class="input_container">
                <textarea id="pinDescription" placeholder=" " maxlength="460"></textarea>
                <label for="pinDescription">Description</label>
            </div>
            <h1>Privacy</h1>
            <label class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>
            <p>
                Make this private - once enabled, only you will be able to view this content. It will no longer be accessible to others, ensuring that your information remains visible exclusively to you and hidden from public or shared access.
            </p>
        </div>

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
    </div>

    <button id="savePinButton"> Create </button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const uploadCover = document.querySelector('.upload_cover');
            const coverInput = document.getElementById('coverInput');
            const cropContainer = document.querySelector('.crop_container');
            const imagePreview = document.getElementById('imagePreview');
            const cropButton = document.getElementById('cropButton');
            const deleteCropButton = document.getElementById('deleteCropButton');
            const rotateSlider = document.getElementById('rotateSlider');
            const savePinButton = document.getElementById('savePinButton');
            const pinText = document.getElementById('pinText');
            const pinDescription = document.getElementById('pinDescription');
            const privacySwitch = document.querySelector('.switch input');
            let cropper = null;
            let croppedImage = null;

            // Функция для извлечения user_id из токена
            function getUserIdFromToken() {
                const token = localStorage.getItem('token'); // Получаем токен из localStorage
                if (!token) {
                    alert("Пользователь не авторизован.");
                    return null;
                }

                try {
                    const payload = JSON.parse(atob(token.split('.')[1])); // Декодируем payload токена
                    return payload.user_id; // Предполагается, что user_id хранится в payload
                } catch (e) {
                    console.error("Ошибка декодирования токена:", e);
                    alert("Недействительный токен.");
                    return null;
                }
            }

            // Обработчик клика на upload_cover
            uploadCover.addEventListener('click', () => {
                coverInput.click(); // Открываем диалог выбора файла
            });

            // Обработчик выбора файла
            coverInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        imagePreview.src = e.target.result; // Устанавливаем изображение в предварительный просмотр
                        cropContainer.style.display = 'flex'; // Показываем контейнер для обрезки

                        // Инициализируем Cropper.js
                        if (cropper) {
                            cropper.destroy(); // Уничтожаем предыдущий экземпляр, если он существует
                        }
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 910 / 537, // Соотношение сторон
                            viewMode: 1,
                        });
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Обработчик изменения значения ползунка
            rotateSlider.addEventListener('input', (event) => {
                const rotationDegree = event.target.value; // Получаем текущее значение ползунка
                if (cropper) {
                    cropper.rotateTo(rotationDegree); // Устанавливаем поворот изображения
                }
            });

            // Обработчик кнопки "Crop"
            cropButton.addEventListener('click', () => {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 910,
                        height: 537,
                    });

                    if (canvas) {
                        croppedImage = canvas.toDataURL(); // Сохраняем обрезанное изображение
                        uploadCover.style.backgroundImage = `url(${croppedImage})`;
                        uploadCover.style.backgroundSize = 'cover';
                        uploadCover.style.backgroundPosition = 'center';
                        uploadCover.textContent = ''; // Убираем текст
                        cropContainer.style.display = 'none'; // Скрываем контейнер для обрезки
                        cropper.destroy();
                        cropper = null;
                    } else {
                        alert('Ошибка при обрезке изображения.');
                    }
                } else {
                    alert('Пожалуйста, загрузите изображение перед обрезкой.');
                }
            });

            // Обработчик кнопки "Delete"
            deleteCropButton.addEventListener('click', () => {
                cropContainer.style.display = 'none'; // Скрываем контейнер для обрезки
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            // Обработчик кнопки "Save Pin"
            savePinButton.addEventListener('click', () => {
                const userId = getUserIdFromToken(); // Извлекаем user_id из токена

                if (!userId) {
                    return; // Прекращаем выполнение, если user_id не найден
                }

                // Проверяем, что поле имени заполнено
                if (!pinText.value.trim()) {
                    alert('Сначала заполните поле имени.');
                    return;
                }

                // Устанавливаем значения по умолчанию
                const pinData = {
                    title: pinText.value.trim(),
                    description: pinDescription.value.trim() || "Defoult description", // Если описание пустое, вставляем ""
                    isPrivate: privacySwitch.checked ? 1 : 0,
                    image: croppedImage || '../../Covers/default_cover.svg', // Если изображение не обрезано, используем путь по умолчанию
                    user_id: userId, // Передаем user_id
                };

                console.log('Pin data being sent:', pinData);

                // Отправляем данные на сервер через AJAX
                fetch('save_pin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(pinData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pin saved successfully!');
                    } else {
                        console.error('Server error:', data.error); // Выводим ошибку в консоль
                        alert('Failed to save pin. Check console for details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            // Функция для проверки текста в поле и изменения состояния кнопки
            function toggleButtonState() {
                if (pinText.value.trim()) {
                    savePinButton.classList.add('active'); // Добавляем класс active
                } else {
                    savePinButton.classList.remove('active'); // Убираем класс active
                }
            }

            // Добавляем обработчик события input для поля pinText
            pinText.addEventListener('input', toggleButtonState);

            // Проверяем состояние кнопки при загрузке страницы
            toggleButtonState();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rotateButton = document.getElementById('rotate_view');
            const rotateSliderContainer = document.querySelector('.rotate_slider_container');
            const rotateSlider = document.getElementById('rotateSlider');
            const rotationValue = document.getElementById('rotationValue');
            let cropper = null; // Предполагается, что cropper уже инициализирован

            // Обработчик кнопки "Rotate"
            rotateButton.addEventListener('click', () => {
                if (rotateSliderContainer.style.display === 'none' || !rotateSliderContainer.style.display) {
                    rotateSliderContainer.style.display = 'block'; // Показываем ползунок
                } else {
                    rotateSliderContainer.style.display = 'none'; // Скрываем ползунок
                }
            });

            // Обработчик изменения значения ползунка
            rotateSlider.addEventListener('input', (event) => {
                const rotationDegree = event.target.value; // Получаем текущее значение ползунка
                rotationValue.textContent = `${rotationDegree}°`; // Обновляем текст с текущим углом
                if (cropper) {
                    cropper.rotateTo(rotationDegree); // Устанавливаем поворот изображения
                }
            });
        });
    </script>
</body>
</html>