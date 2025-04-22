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
    <?php include 'navbar.php'; ?>

    <div class="background_image">
        <div class="background_image_blur"></div>
        <img src="Sliders/slide_1.png" id="slider_background_image">
    </div>
    <div class="slider-container" id="slider">
        
        <div class="slider-track" id="track">
            <!-- Твои слайды -->
            <div class="slide" >
                <div class="slide_img" id="1">
                    <img src="Sliders/slide_1_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Wanda Vision </h1>
                        <h2> Wanda and Vision are newlyweds living in the idyllic town of Westview. At first, their lives seem perfect, but they gradually realize that this is not the case. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="2">
                    <img src="Sliders/slide_2_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Ant-Man Wasp <br> Quantamania </h1>
                        <h2> Scott Lang and Hope Van Dyne are dragged into the Quantum Realm, along with Hope's parents and Scott's daughter Cassie. Together they must find a way to escape, but what secrets  is Hope's mother hiding? And who is the mysterious Kang? </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="3">
                    <img src="Sliders/slide_3_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Agata All Along </h1>
                        <h2> A spell-bound Agatha Harkness regains freedom thanks to a teen's help. Intrigued by his plea, she embarks on the Witches' Road trials to reclaim her powers and discover the teen's motivations. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="4">
                    <img src="Sliders/slide_4_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Thunderbolts </h1>
                        <h2> After finding themselves ensnared in a death trap, an unconventional team of antiheroes must embark on a dangerous mission that will force them to confront the darkest corners of their pasts. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="5">
                    <img src="Sliders/slide_5_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Capitan America <br> Brave New World </h1>
                        <h2> Sam Wilson, the new Captain America, finds himself in the middle of an international incident and must discover the motive behind a nefarious global plan. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="6">
                    <img src="Sliders/slide_6_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Moonknigh </h1>
                        <h2> Steven Grant discovers he's been granted the powers of an Egyptian moon god. But he soon finds out that these newfound powers can be both a blessing and a curse to his troubled life. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="7">
                    <img src="Sliders/slide_7_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> She-Hulk </h1>
                        <h2> Jennifer Walters navigates the complicated life of a single, 30-something attorney who also happens to be a green 6-foot-7-inch superpowered Hulk. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="8">
                    <img src="Sliders/slide_8_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Secret Invasion </h1>
                        <h2> Fury and Talos try to stop the Skrulls who have infiltrated the highest spheres of the Marvel Universe. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="9">
                    <img src="Sliders/slide_9_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Loki </h1>
                        <h2> The mercurial villain Loki resumes his role as the God of Mischief in a new series that takes place after the events of “Avengers: Endgame.” </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="10">
                    <img src="Sliders/slide_10_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> Avengers: <br> EndGame </h1>
                        <h2> After the devastating events of Avengers: Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more in order to reverse Thanos' actions and restore balance to the universe. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="11">
                    <img src="Sliders/slide_11_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> The Amazing Spider-Man </h1>
                        <h2> After Peter Parker is bitten by a genetically altered spider, he gains newfound, spider-like powers and ventures out to save the city from the machinations of a mysterious reptilian foe. </h2>
                    </div>
                </div>
            </div>
            <div class="slide" >
                <div class="slide_img" id="12">
                    <img src="Sliders/slide_12_mini.png" draggable="false">
                    <div class="slide_description">
                        <h1> The Amazing Spider-Man 2 </h1>
                        <h2> When New York is put under siege by Oscorp, it is up to Spider-Man to save the city he swore to protect as well as his loved ones. </h2>
                    </div>
                </div>
            </div>
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
                            <img src="Image/doggy.svg">
                            <span> 101SoloGamer101 </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="Image/retweet.svg">
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
                            <img src="Image/doggy.svg">
                            <span> GigaNiga </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="Image/retweet.svg">
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
                            <img src="Image/doggy.svg">
                            <span> NotYourBussines </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="Image/retweet.svg">
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
                            <img src="Image/doggy.svg">
                            <span> Tralaleo_Tralala </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="Image/retweet.svg">
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
                            <img src="Image/doggy.svg">
                            <span> Bombordino_Crocodilo </span>
                        </div>
                        <div class="second_slide_retweet"> 
                            <img src="Image/retweet.svg">
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

    <div class="pox3"></div>

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
    track.addEventListener('click', (e) => {
        const slide = e.target.closest('.slide_img');
        if (!slide) return;

        // Убираем увеличение со всех
        track.querySelectorAll('.slide_img').forEach(s => s.classList.remove('active'));

        // Вычисляем позицию слайда внутри трека
        const slideLeft = slide.offsetLeft;
        const sliderCenter = slider.offsetWidth / 2;
        const scrollTo = slideLeft - sliderCenter + slide.offsetWidth / 2;

        // Прокручиваем к нужной позиции
        slider.scrollTo({
          left: scrollTo,
          behavior: 'smooth'
        });

        // Добавляем класс увеличения
        slide.classList.add('active');

        // Устанавливаем новое изображение фона
        document.getElementById('slider_background_image').src = 'Sliders/slide_' + slide.id + '.png';
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