<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="add_post.css">
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
    <div class="add_post" id="add_post">
        <div class="add_post_background"></div>
        <div class="add_post_conteiner_center">
            <div class="add_post_conteiner">
                <img src="Avatars/Davit_avatar.jpg" class="add_post_avatar_img">
                <div class="add_post_div_textare">
                    <textarea class="add_post_textarea" id="autoResize" placeholder="Lets people know your opinion" maxlength="1000"></textarea>
                </div>
                <div id="add_post_preview_container"></div>
                <div class="add_post_reply_access">
                    <span> Who can reply </span>
                </div>
                <div class="add_post_footer">
                    <img src="Image/add_post_image.svg" id="add_post_image">
                    <input type="file" id="add_post_image_input" accept="image/*, video/*" multiple style="display: none;">

                    <img src="Image/add_post_gif.svg" id="add_post_gif">
                    <input type="file" id="add_post_gif_input" accept="image/gif" multiple style="display: none;">

                    <div class="upload_post">
                        <span> Post </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const add_post_textarea = document.getElementById('autoResize');

        add_post_textarea.addEventListener('input', () => {
            if (add_post_textarea.scrollHeight < 450) {
                add_post_textarea.style.height = 'auto'; // сбрасываем, чтобы пересчитать
                add_post_textarea.style.height = add_post_textarea.scrollHeight + 'px';    
            }
        });
    </script>
    <script>
        const addImageBtn = document.getElementById('add_post_image');
        const addGifBtn = document.getElementById('add_post_gif');
        const imageInput = document.getElementById('add_post_image_input');
        const gifInput = document.getElementById('add_post_gif_input');
        const previewContainer = document.getElementById('add_post_preview_container');

        // Общая функция для добавления превью (картинка или гиф)
        function addPreview(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';
                    wrapper.style.display = 'inline-block';
                    wrapper.style.margin = '5px';

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
                }
            }
        });
    </script>
    <script>
        document.querySelector('.upload_post').addEventListener('click', async () => {
            const text = document.querySelector('.add_post_textarea').value;
            const images = document.querySelector('#add_post_image_input').files;

            // Получаем токен из localStorage
            const token = localStorage.getItem('token');
            if (!token) {
                alert("Пользователь не авторизован.");
                return;
            }

            // Декодируем токен
            let user_id;
            let user_name;
            let user_login;
            let user_avatar;
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                user_id = payload.user_id;
                user_name = payload.username;
                user_login = payload.name;
                user_avatar = payload.avatar;
            } catch (e) {
                console.error("Ошибка декодирования токена:", e);
                alert("Недействительный токен.");
                return;
            }

            const formData = new FormData();
            formData.append('text', text);
            formData.append('user_id', user_id);
            formData.append('user_name', user_name);
            formData.append('user_login', user_login); 
            formData.append('user_avatar', user_avatar);


            for (let i = 0; i < images.length; i++) {
                formData.append('images[]', images[i]);
            }
            console.log("Token:", token);

            const response = await fetch('upload_post.php', {
                method: 'POST',
                body: formData
            });

            const error_text = await response.text(); // сначала как обычный текст
            console.log("Raw server response:", error_text);

            try {
                const result = JSON.parse(error_text); // теперь пытаемся в JSON
                alert(result.message);
            } catch (err) {
                console.error("Ошибка разбора JSON:", err);
            }

            if (error_text = 'Пост успешно добавлен!') {
                window.location.href = 'forum.php';
            }
        });
    </script>
</body>
</html>