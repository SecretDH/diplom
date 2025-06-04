<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    
</head>
<body>
    <?php include '../navbar.php'; ?>

    <div class="background_image">
        <div class="background_overlay"></div>
        <img src="" id="slider_background_image" draggable="false">

        <div class="slide_description">
            <h1> Wanda Vision </h1>
            <div class="raiting">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star.svg" class="star" alt="Star">
                <img src="../../Image/raiting_star_empty.svg" class="star" alt="Star">
            </div>
            <h2> Wanda and Vision are newlyweds living in the idyllic town of Westview. At first, their lives seem perfect, but they gradually realize that this is not the case. </h2>
            <button class="watch_button" onclick="">
                Watch
            </button>
        </div>
    </div>
    <div class="slider-container" id="slider">
        
        <div class="slider-track" id="track">
            <?php include 'get_slides.php'; ?>
        </div>
    </div>

    <div class="mini_forum">
        <h1> Say what you think.<br>Read what others think. </h1>
        <h2> Connect without limits. </h2>

        <div class="second_slider-container" id="second_slider">
        
            <div class="second_slider-track" id="second_track">
                <!-- Твои слайды -->
                <div class="second_slide" >
                    <div class="second_slide_content" id="1">
                        <div class="second_slide_sender"> 
                            <img src="../../Image/doggy.svg">
                            <span> 101SoloGamer101 </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="../../Image/retweet.svg">
                        </div>
                        <p class="second_slide_content_messege">
                            Everything moves, everything changes, yet it all feels the same. We think something matters, but soon we forget. Maybe it wasn’t worth worrying about after all.
                        </p>
                        <p class="second_slide_content_time">
                            13:02
                        </p>
                    </div>
                </div>
                <div class="second_slide" >
                    <div class="second_slide_content" id="2">
                        <div class="second_slide_sender"> 
                            <img src="../../Image/doggy.svg">
                            <span> GigaNiga </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="../../Image/retweet.svg">
                        </div>
                        <p class="second_slide_content_messege">
                            Everything moves, everything changes, yet it all feels the same. We think something matters, but soon we forget. Maybe it wasn’t worth worrying about after all.
                        </p>
                        <p class="second_slide_content_time">
                            13:02
                        </p>
                    </div>
                </div>
                <div class="second_slide" >
                    <div class="second_slide_content" id="3">
                        <div class="second_slide_sender"> 
                            <img src="../../Image/doggy.svg">
                            <span> NotYourBussines </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="../../Image/retweet.svg">
                        </div>
                        <p class="second_slide_content_messege">
                            Everything moves, everything changes, yet it all feels the same. We think something matters, but soon we forget. Maybe it wasn’t worth worrying about after all.
                        </p>
                        <p class="second_slide_content_time">
                            13:02
                        </p>
                    </div>
                </div>
                <div class="second_slide" >
                    <div class="second_slide_content" id="4">
                        <div class="second_slide_sender"> 
                            <img src="../../Image/doggy.svg">
                            <span> Tralaleo_Tralala </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="../../Image/retweet.svg">
                        </div>
                        <p class="second_slide_content_messege">
                            Everything moves, everything changes, yet it all feels the same. We think something matters, but soon we forget. Maybe it wasn’t worth worrying about after all.
                        </p>
                        <p class="second_slide_content_time">
                            13:02
                        </p>
                    </div>
                </div>
                <div class="second_slide" >
                    <div class="second_slide_content" id="5">
                        <div class="second_slide_sender"> 
                            <img src="../../Image/doggy.svg">
                            <span> Bombordino_Crocodilo </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="../../Image/retweet.svg">
                        </div>
                        <p class="second_slide_content_messege">
                            Everything moves, everything changes, yet it all feels the same. We think something matters, but soon we forget. Maybe it wasn’t worth worrying about after all.
                        </p>
                        <p class="second_slide_content_time">
                            13:02
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="second_slide_join">
            <span> Join Now </span>
        </div>
    </div>

    <script>
        const slider = document.getElementById('slider');
        const track = document.getElementById('track');
        const originalSlides = Array.from(track.children);
        const slideCount = originalSlides.length;

        const slideWidth = originalSlides[0].offsetWidth + parseInt(getComputedStyle(originalSlides[0]).marginRight);

        // Клонируем в начало (в правильном порядке)
        originalSlides.forEach(slide => {
            const clone = slide.cloneNode(true);
            track.insertBefore(clone, track.lastChild);
        });

        // Клонируем в конец
        originalSlides.forEach(slide => {
            const clone = slide.cloneNode(true);
            track.appendChild(clone);
        });

        // Установка начального положения на оригинальные слайды
        let currentScroll = slideWidth * slideCount;
        slider.scrollLeft = currentScroll;

        // Обновление ширины трека
        track.style.width = `${slideWidth * track.children.length}px`;

        // Drag-скроллинг
        let isDragging = false;
        let startX = 0;
        let scrollStart = 0;

        slider.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX;
            scrollStart = slider.scrollLeft;
            slider.style.cursor = 'grabbing';
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
            slider.style.cursor = 'grab';
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            const dx = e.pageX - startX;
            slider.scrollLeft = scrollStart - dx;
        });

        // Зацикливание
        slider.addEventListener('scroll', () => {
            const maxScroll = slideWidth * (slideCount * 2);

            if (slider.scrollLeft <= slideWidth * 0.5) {
                // Перепрыгиваем вперёд (в центр)
                slider.scrollLeft += slideWidth * slideCount;
            }

            if (slider.scrollLeft >= maxScroll + slideWidth * 0.5) {
                // Перепрыгиваем назад (в центр)
                slider.scrollLeft -= slideWidth * slideCount;
            }
        });

        // Центрируем слайд по клику
        let currentActiveSlideImg = null;

track.addEventListener('click', (e) => {
    const slideImg = e.target.closest('.slide_img');
    if (!slideImg) return;

    // Убираем увеличение со всех .slide_img и .slide
    track.querySelectorAll('.slide_img').forEach(s => s.classList.remove('active'));
    track.querySelectorAll('.slide').forEach(s => s.classList.remove('active'));

    // Добавляем класс увеличения
    slideImg.classList.add('active');
    const parentSlide = slideImg.closest('.slide');
    if (parentSlide) parentSlide.classList.add('active');

    // Смещение центра
    let offset = 0;
    if (currentActiveSlideImg && currentActiveSlideImg !== slideImg) {
        const prevRect = currentActiveSlideImg.getBoundingClientRect();
        const newRect = slideImg.getBoundingClientRect();
        const slideWidth = prevRect.width;
        const activeSlideWidth = slideWidth * 1.4;
        const offsetValue = (activeSlideWidth - slideWidth) / 2;

        if (newRect.left < prevRect.left) {
            offset = offsetValue;
        } else if (newRect.left > prevRect.left) {
            offset = -offsetValue;
        }
    }

    // Центрируем слайд с учётом смещения
    const slideLeft = slideImg.offsetLeft;
    const sliderCenter = slider.offsetWidth / 2;
    const scrollTo = slideLeft - sliderCenter + slideImg.offsetWidth / 2 + offset;

    slider.scrollTo({
        left: scrollTo,
        behavior: 'smooth'
    });

    // --- ОБНОВЛЯЕМ .slide_description и фон ---
    const title = slideImg.dataset.title || '';
    const description = slideImg.dataset.description || '';
    const bigPoster = slideImg.dataset.big_poster || '';
    const averageRating = parseFloat(slideImg.dataset.average_rating || '0');

    const slideDescription = document.querySelector('.slide_description');
    const h1 = slideDescription?.querySelector('h1');
    const h2 = slideDescription?.querySelector('h2');
    const bgImg = document.getElementById('slider_background_image');
    const ratingDiv = slideDescription?.querySelector('.raiting');

    // Скрываем описание и фон
    slideDescription.classList.remove('visible');
    bgImg.classList.add('fade');

    setTimeout(() => {
        if (h1) h1.textContent = title;
        if (h2) h2.textContent = description;
        if (bgImg && bigPoster) bgImg.src = bigPoster;

        // Обновляем звёзды рейтинга
        if (ratingDiv) {
            const rounded = Math.round(averageRating);
            let stars = '';
            for (let i = 0; i < 5; i++) {
                if (i < rounded) {
                    stars += '<img src="../../Image/raiting_star.svg" class="star" alt="Star">';
                } else {
                    stars += '<img src="../../Image/raiting_star_empty.svg" class="star" alt="Star">';
                }
            }
            ratingDiv.innerHTML = stars;
        }

        // Показываем описание плавно
        slideDescription.classList.add('visible');
        bgImg.classList.remove('fade');
    }, 300);

    // Запоминаем текущий активный
    currentActiveSlideImg = slideImg;
});
    </script>

    <script>
        const second_slider = document.getElementById('second_slider');
        const second_track = document.getElementById('second_track');
        const second_originalSlides = Array.from(second_track.children);
        const second_slideCount = second_originalSlides.length;

        const second_slideWidth = second_originalSlides[0].offsetWidth + parseInt(getComputedStyle(second_originalSlides[0]).marginRight);

        // Клонируем в начало (в правильном порядке)
        second_originalSlides.forEach(second_slide => {
        const second_clone = second_slide.cloneNode(true);
        second_track.insertBefore(second_clone, second_track.lastChild);
        });

        // Клонируем в конец
        second_originalSlides.forEach(second_slide => {
        const second_clone = second_slide.cloneNode(true);
        second_track.appendChild(second_clone);
        });

        // Установка начального положения на оригинальные слайды
        let second_currentScroll = second_slideWidth * second_slideCount;
        second_slider.scrollLeft = second_currentScroll;

        // Обновление ширины трека
        second_track.style.width = `${second_slideWidth * second_track.children.length}px`;

        // Drag-скроллинг
        let second_isDragging = false;
        let second_startX = 0;
        let second_scrollStart = 0;

        second_slider.addEventListener('mousedown', (second_e) => {
            second_isDragging = true;
            second_startX = second_e.pageX;
            second_scrollStart = second_slider.scrollLeft;
            second_slider.style.cursor = 'grabbing';
        });

        document.addEventListener('mouseup', () => {
            second_isDragging = false;
            second_slider.style.cursor = 'grab';
        });

        document.addEventListener('mousemove', (second_e) => {
            if (!second_isDragging) return;
            const second_dx = second_e.pageX - second_startX;
            second_slider.scrollLeft = second_scrollStart - second_dx;
        });

        // Зацикливание
        second_slider.addEventListener('scroll', () => {
            const second_maxScroll = second_slideWidth * (second_slideCount * 2);

            if (second_slider.scrollLeft <= second_slideWidth * 0.5) {
                // Перепрыгиваем вперёд (в центр)
                second_slider.scrollLeft += second_slideWidth * second_slideCount;
            }

            if (second_slider.scrollLeft >= second_maxScroll + second_slideWidth * 0.5) {
                // Перепрыгиваем назад (в центр)
                second_slider.scrollLeft -= second_slideWidth * second_slideCount;
            }
        });
    </script>

</body>
</html>