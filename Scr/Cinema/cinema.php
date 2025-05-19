<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" type="text/css" href="cinema.css">
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
    <div class="best_movies_container">
        <div id="cinema_slider" class="slider">
            <div class="slide" id="slide1">Page 1 Content</div>
            <div class="slide" id="slide2">Page 2 Content</div>
            <div class="slide" id="slide3">Page 3 Content</div>
        </div>
        <div class="slider-indicators">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <div class="series_container">
        <h1>Series</h1>
        <button class="series-scroll-left">&#10142;</button>
        <div class="series_list">
            <?php include 'get_series.php'; ?>
        </div>
        <button class="series-scroll-right">&#10142;</button>
    </div>

    <div class="movie_container">
        <h1>Movies</h1>
        <button class="movie-scroll-left">&#10142;</button>
        <div class="movie_list">
            <?php include 'get_movies.php'; ?>
        </div>
        <button class="movie-scroll-right">&#10142;</button>
    </div>

    <div class="actors_container">
        <h1>Actors</h1>
        <button class="actors-scroll-left">&#10142;</button>
        <div class="actors_list">
            <?php include 'get_actors.php'; ?>
        </div>
        <button class="actors-scroll-right">&#10142;</button>
    </div>


    <div style="width:100%; height:1000px"></div>

    <template id="infoBoxTemplateSeries">
        <div class="info_box_series">
            <div class="info_box_title_series">
                Pins
            </div>
            <?php 
                $user_id = $_GET['user_id'] ?? null;
                $pin_type = 'series'; // Укажите тип, например, 'movie' или 'series'

                if (!$user_id) {
                    die("ID пользователя не передан.");
                }

                // Передаем тип пина через $_GET
                $_GET['pin_type'] = $pin_type;

                include 'get_pins.php'; 
            ?>
        </div>
    </template>

    <template id="infoBoxTemplateMovie">
        <div class="info_box_movie">
            <div class="info_box_title_movie">
                Pins
            </div>
            <?php 
                $user_id = $_GET['user_id'] ?? null;
                $pin_type = 'movie'; // Укажите тип, например, 'movie' или 'series'

                if (!$user_id) {
                    die("ID пользователя не передан.");
                }

                // Передаем тип пина через $_GET
                $_GET['pin_type'] = $pin_type;

                include 'get_pins.php'; 
            ?>
        </div>
    </template>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const cinema_slider = document.getElementById('cinema_slider');
        const cinema_slides = Array.from(cinema_slider.children);
        const cinema_slideCount = cinema_slides.length;

        // Рассчитываем ширину одного слайда (включая отступы)
        const cinema_slideWidth = cinema_slides[0].offsetWidth;

        // Клонируем слайды в начало
        cinema_slides.forEach(slide => {
            const cloneStart = slide.cloneNode(true);
            cinema_slider.insertBefore(cloneStart, cinema_slider.lastChild);
        });

        // Клонируем слайды в конец
        cinema_slides.forEach(slide => {
            const cloneEnd = slide.cloneNode(true);
            cinema_slider.appendChild(cloneEnd);
        });

        // Устанавливаем начальное положение на оригинальные слайды
        let cinema_currentScroll = cinema_slideWidth * cinema_slideCount;
        cinema_slider.scrollLeft = cinema_currentScroll;

        // Переменные для drag-скроллинга
        let cinema_isDragging = false;
        let cinema_startX = 0;
        let cinema_scrollStart = 0;
        let cinema_movedBy = 0;

        // Drag-скроллинг с переходом на слайды
        cinema_slider.addEventListener('mousedown', (e) => {
            cinema_isDragging = true;
            cinema_startX = e.pageX;
            cinema_scrollStart = cinema_slider.scrollLeft;
            cinema_slider.style.cursor = 'grabbing';
            e.preventDefault(); // Предотвращаем выделение текста
        });

        document.addEventListener('mouseup', () => {
            if (!cinema_isDragging) return;
            cinema_isDragging = false;
            cinema_slider.style.cursor = 'grab';

            // Если перетаскивание больше 25% ширины слайда
            if (Math.abs(cinema_movedBy) > cinema_slideWidth * 0.25) {
                if (cinema_movedBy > 0) {
                    // Переход к предыдущему слайду
                    cinema_slider.scrollTo({
                        left: cinema_scrollStart - cinema_slideWidth,
                        behavior: 'smooth',
                    });
                } else {
                    // Переход к следующему слайду
                    cinema_slider.scrollTo({
                        left: cinema_scrollStart + cinema_slideWidth,
                        behavior: 'smooth',
                    });
                }
            } else {
                // Возвращаемся к текущему слайду
                cinema_slider.scrollTo({
                    left: cinema_scrollStart,
                    behavior: 'smooth',
                });
            }

            cinema_movedBy = 0; // Сбрасываем значение

            // Проверяем выравнивание после отпускания
            alignToNearestSlide();
        });

        document.addEventListener('mousemove', (e) => {
            if (!cinema_isDragging) return;
            const dx = e.pageX - cinema_startX;
            cinema_movedBy = dx; // Сохраняем смещение
            cinema_slider.scrollLeft = cinema_scrollStart - dx;
        });

        // Функция для выравнивания к ближайшему слайду
        function alignToNearestSlide() {
            const currentScroll = cinema_slider.scrollLeft;
            const nearestSlideIndex = Math.round(currentScroll / cinema_slideWidth);
            const targetScroll = nearestSlideIndex * cinema_slideWidth;

            cinema_slider.scrollTo({
                left: targetScroll,
                behavior: 'smooth',
            });
        }

        // Зацикливание
        cinema_slider.addEventListener('scroll', () => {
            const maxScroll = cinema_slideWidth * (cinema_slideCount * 3); // Общая ширина с учетом клонированных слайдов

            if (cinema_slider.scrollLeft <= cinema_slideWidth) {
                // Если прокрутка меньше половины ширины слайда, перепрыгиваем в конец оригинальных слайдов
                cinema_slider.scrollLeft += cinema_slideWidth * cinema_slideCount;
            }

            if (cinema_slider.scrollLeft >= maxScroll - cinema_slideWidth) {
                // Если прокрутка больше, чем предпоследний слайд, перепрыгиваем в начало оригинальных слайдов
                cinema_slider.scrollLeft -= cinema_slideWidth * cinema_slideCount;
            }
        });

        // Индикаторы
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                cinema_slider.scrollTo({
                    left: cinema_slideWidth * (index + 1),
                    behavior: 'smooth',
                });
            });
        });

        // Обновляем индикаторы при прокрутке
        cinema_slider.addEventListener('scroll', () => {
            const scrollLeft = cinema_slider.scrollLeft;
            const currentIndex = Math.round(scrollLeft / cinema_slideWidth) % cinema_slideCount;
            dots.forEach(dot => dot.classList.remove('active'));
            dots[currentIndex].classList.add('active');
        });
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seriesList = document.querySelector('.series_list');
            const scrollLeftButton = document.querySelector('.series-scroll-left');
            const scrollRightButton = document.querySelector('.series-scroll-right');
            const seriesItemWidth = document.querySelector('.series_item').offsetWidth + 20; // Ширина элемента + gap

            // Проверяем, что кнопки и список существуют
            if (!seriesList || !scrollLeftButton || !scrollRightButton) {
                console.error('Элементы не найдены в DOM');
                return;
            }

            // Обработчик для кнопки прокрутки влево
            scrollLeftButton.addEventListener('click', () => {
                console.log('Кнопка влево нажата');
                seriesList.scrollBy({
                    left: -seriesItemWidth, // Прокрутка влево на ширину одного элемента
                    behavior: 'smooth',
                });
            });

            // Обработчик для кнопки прокрутки вправо
            scrollRightButton.addEventListener('click', () => {
                console.log('Кнопка вправо нажата');
                seriesList.scrollBy({
                    left: seriesItemWidth, // Прокрутка вправо на ширину одного элемента
                    behavior: 'smooth',
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const movieList = document.querySelector('.movie_list');
            const scrollLeftButton = document.querySelector('.movie-scroll-left');
            const scrollRightButton = document.querySelector('.movie-scroll-right');
            const movieItemWidth = document.querySelector('.movie_item').offsetWidth + 20; // Ширина элемента + gap

            // Проверяем, что кнопки и список существуют
            if (!movieList || !scrollLeftButton || !scrollRightButton) {
                console.error('Элементы не найдены в DOM');
                return;
            }

            // Обработчик для кнопки прокрутки влево
            scrollLeftButton.addEventListener('click', () => {
                movieList.scrollBy({
                    left: -movieItemWidth, // Прокрутка влево на ширину одного элемента
                    behavior: 'smooth',
                });
            });

            // Обработчик для кнопки прокрутки вправо
            scrollRightButton.addEventListener('click', () => {
                movieList.scrollBy({
                    left: movieItemWidth, // Прокрутка вправо на ширину одного элемента
                    behavior: 'smooth',
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const actorsList = document.querySelector('.actors_list');
            const scrollLeftButton = document.querySelector('.actors-scroll-left');
            const scrollRightButton = document.querySelector('.actors-scroll-right');
            const actorItemWidth = document.querySelector('.actor_item').offsetWidth + 20; // Ширина элемента + gap

            // Проверяем, что кнопки и список существуют
            if (!actorsList || !scrollLeftButton || !scrollRightButton) {
                console.error('Элементы не найдены в DOM');
                return;
            }

            // Обработчик для кнопки прокрутки влево
            scrollLeftButton.addEventListener('click', () => {
                actorsList.scrollBy({
                    left: -actorItemWidth, // Прокрутка влево на ширину одного элемента
                    behavior: 'smooth',
                });
            });

            // Обработчик для кнопки прокрутки вправо
            scrollRightButton.addEventListener('click', () => {
                actorsList.scrollBy({
                    left: actorItemWidth, // Прокрутка вправо на ширину одного элемента
                    behavior: 'smooth',
                });
            });
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const actorNames = document.querySelectorAll('.actor_name');

        actorNames.forEach(name => {
            if (name.textContent.length > 10) {
                name.style.wordWrap = 'break-word';
                name.style.lineHeight = '1.2';
            }
        });
    });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const actorItems = document.querySelectorAll('.movie_item');

    actorItems.forEach(item => {
        item.addEventListener('click', (event) => {
            // Проверяем, был ли клик на movie_pin
            if (event.target.classList.contains('movie_pin')) {
                console.log('Клик на movie_pin, переход отменен');
                event.preventDefault(); // Отменяем переход
                return;
            }

            const actorId = item.id.replace('movie_item_', '');
            window.location.href = `movie_series_page.php?movie_id=${actorId}`; // Перенаправляем на страницу
        });
    });

    const seriesItems = document.querySelectorAll('.series_item'); // Выбираем все элементы сериалов

    seriesItems.forEach(item => {
        item.addEventListener('click', (event) => {
            // Проверяем, был ли клик на series_pin
            if (event.target.classList.contains('series_pin')) {
                console.log('Клик на series_pin, переход отменен');
                event.preventDefault(); // Отменяем переход
                return;
            }

            const seriesId = item.id.replace('series_item_', '');
            window.location.href = `movie_series_page.php?series_id=${seriesId}`; // Перенаправляем на страницу
        });
    });
});
    </script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    let activeBox = null; // Хранит текущий активный прямоугольник

    // Функция для создания и отображения прямоугольника
    function createInfoBox(item) {
        console.log('createInfoBox вызвана с:', item); // Отладочный вывод

        // Удаляем предыдущий прямоугольник, если он есть
        if (activeBox) {
            activeBox.remove();
            activeBox = null;
        }

        // Извлекаем шаблон из текущего элемента
        const template = item.querySelector('.info_box_template');
        if (!template) {
            console.error('Шаблон не найден в элементе:', item);
            return;
        }

        const rect = template.firstElementChild.cloneNode(true);
        rect.style.display = 'block'; // Делаем шаблон видимым

        document.body.appendChild(rect);

        // Позиционируем прямоугольник
        const itemRect = item.getBoundingClientRect();
        const rectWidth = rect.offsetWidth;
        const windowWidth = window.innerWidth;

        console.log('Координаты прямоугольника:', {
            top: itemRect.top + window.scrollY,
            left: itemRect.right + 10,
        });

        // Проверяем, есть ли достаточно места справа
        if (itemRect.right + rectWidth + 10 > windowWidth) {
            rect.style.top = `${itemRect.top + window.scrollY}px`;
            rect.style.left = `${itemRect.left - rectWidth - 10}px`;
        } else {
            rect.style.top = `${itemRect.top + window.scrollY}px`;
            rect.style.left = `${itemRect.right + 10}px`;
        }

        // Сохраняем текущий прямоугольник
        activeBox = rect;
    }

    // Делегирование событий для клика на пины
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('movie_pin') || event.target.classList.contains('series_pin')) {
            const pin = event.target;
            const parent = pin.closest('.series_item, .movie_item');

            if (!parent) {
                console.error('Родительский элемент не найден');
                return;
            }

            console.log('Клик на пин:', pin); // Отладочный вывод
            console.log('Родительский элемент:', parent); // Отладочный вывод

            // Создаем прямоугольник
            createInfoBox(parent);

            // Останавливаем всплытие события, чтобы клик на прямоугольнике не закрывал его
            event.stopPropagation();
        }
    });

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('pin_attach_button')) {
            const button = event.target;

            // Получаем данные из атрибутов кнопки
            const pinId = button.getAttribute('data-pin-id');
            const pinType = button.getAttribute('data-pin-type');
            const relatedId = button.getAttribute('data-related-id');

            // Проверяем, что все данные присутствуют
            if (!pinId || !pinType || !relatedId) {
                console.error('Некорректные данные для отправки:', { pinId, pinType, relatedId });
                alert('Некорректные данные. Пожалуйста, проверьте атрибуты кнопки.');
                return;
            }

            // Отправляем AJAX-запрос на сервер
            fetch('toggle_pin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ pin_id: pinId, pin_type: pinType, related_id: relatedId }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log('Ответ сервера:', data);

                    if (data.success) {
                        // Обновляем текст кнопки в зависимости от действия
                        if (data.action === 'added') {
                            button.textContent = 'UnPin';
                        } else if (data.action === 'removed') {
                            button.textContent = 'Pin';
                        }
                    } else {
                        alert('Ошибка: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Ошибка при отправке запроса:', error);
                    alert('Произошла ошибка. Попробуйте снова.');
                });

            // Останавливаем всплытие события
            event.stopPropagation();
        }
    });

    // Закрываем прямоугольник при клике вне его территории
    document.addEventListener('click', (event) => {
        if (activeBox && !activeBox.contains(event.target) && !event.target.classList.contains('movie_pin') && !event.target.classList.contains('series_pin')) {
            activeBox.remove();
            activeBox = null;
        }
    });
});
    </script>
</body>
</html>