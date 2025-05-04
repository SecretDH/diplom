<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" type="text/css" href="cinema.css">
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
        <button class="series-scroll-left">&larr;</button>
        <div class="series_list">
            <?php include 'get_series.php'; ?>
        </div>
        <button class="series-scroll-right">&rarr;</button>
    </div>

    <div class="movie_container">
        <h1>Movies</h1>
        <button class="movie-scroll-left">&larr;</button>
        <div class="movie_list">
            <?php include 'get_movies.php'; ?>
        </div>
        <button class="movie-scroll-right">&rarr;</button>
    </div>

    <div class="actors_container">
        <h1>Actors</h1>
        <button class="actors-scroll-left">&larr;</button>
        <div class="actors_list">
            <?php include 'get_actors.php'; ?>
        </div>
        <button class="actors-scroll-right">&rarr;</button>
    </div>


    <div style="width:100%; height:1000px"></div>


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
                item.addEventListener('click', () => {
                    const actorId = item.id.replace('movie_item_', '');
                    window.location.href = `movie_series_page.php?movie_id=${actorId}`; // Перенаправляем на страницу
                });
            });
        });
    </script>
</body>
</html>