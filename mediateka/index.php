<?php
$page_title = 'Mediateka - Denda';
include '../includes/header.php';
?>

<link rel="stylesheet" href="../css/mediateka.css">

<section class="katalogo-atalak">
    <div class="katalogo-edukia">
        <h2>Mediateka</h2>

        <section>
            <h3>Irudiak - Galeria</h3>

            <div class="carousel-container" id="carousel-container">
                <button class="prev" onclick="moveSlide(-1)">&#10094;</button>

                <div class="carousel-track-container">
                    <ul class="carousel-track" id="track">
                        <li class="carousel-slide"><img src="../img/LesPaul.jpg" alt="Les Paul"></li>
                        <li class="carousel-slide"><img src="../img/SGEpiphone.jpg" alt="SG Epiphone"></li>
                        <li class="carousel-slide"><img src="../img/StratoFender.jpg" alt="Stratocaster Fender"></li>
                        <li class="carousel-slide"><img src="../img/TelecasterFender.jpg" alt="Telecaster Fender"></li>
                        <li class="carousel-slide"><img src="../img/SGGibson.jpg" alt="Gibson SG"></li>
                        <li class="carousel-slide"><img src="../img/SquierStrato.jpg" alt="Squier Strato"></li>
                    </ul>
                </div>

                <button class="next" onclick="moveSlide(1)">&#10095;</button>
            </div>
            <p style="text-align:center; font-size:0.9em; color:#666">Erabili geziak.</p>

            <hr style="margin: 30px 0;">

            <h3>Irudiak - Beste Teknikak</h3>

            <h4>Figure eta Figcaption</h4>
            <figure>
                <img src="../img/SGEpiphone.jpg" alt="Epiphone SG" style="max-width: 300px; height: auto;">
                <figcaption>Irudia 1: Epiphone SG eredua, rock estiloko klasikoa.</figcaption>
            </figure>

            <h4>CSS Sprites</h4>
            <p>Irudi bakar bat kargatu eta posizioa aldatuz zati desberdinak erakutsi (hover efektua):</p>
            <div class="sprite-container sprite-hover"></div>


        </section>

        <!-- 2. AUDIOA -->
        <section>
            <h3>Audioa</h3>

            <h4>HTML5 Audio Tag</h4>

            <audio id="myAudio" controls>
                <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
                Zure nabigatzaileak ez du audio elementua onartzen.
            </audio>

            <h4>Javascript Audio Metodoak</h4>
            <div class="controls">
                <button onclick="playAudio()">Play</button>
                <button onclick="pauseAudio()">Pause</button>
                <button onclick="restartAudio()">Hasierara</button>
            </div>
        </section>

        <!-- 3. BIDEOA -->
        <section>
            <h3>Bideoa</h3>

            <h4>HTML5 Video Tag</h4>

            <video id="myVideo" width="400" controls>
                <source src="https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4" type="video/mp4">
                Zure nabigatzaileak ez du bideo elementua onartzen.
            </video>

            <h4>Javascript Bideo Metodoak</h4>
            <div class="controls">
                <button onclick="playVideo()">Play</button>
                <button onclick="pauseVideo()">Pause</button>
                <button onclick="muteVideo()">Mute/Unmute</button>
            </div>

            <h4>Iframe (YouTube)</h4>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </section>
    </div>
</section>

<script>
    // CAROUSEL LOGIC
    const track = document.getElementById('track');
    let currentIndex = 0;
    let autoPlayInterval;

    // Determine how many items are visible based on screen width
    function getItemsVisible() {
        if (window.innerWidth <= 480) return 1;
        if (window.innerWidth <= 768) return 2;
        return 3;
    }

    function moveSlide(direction) {
        const slides = document.querySelectorAll('.carousel-slide');
        const itemsVisible = getItemsVisible();
        const totalSlides = slides.length;
        const maxIndex = totalSlides - itemsVisible;

        currentIndex += direction;

        if (currentIndex < 0) {
            currentIndex = maxIndex;
        } else if (currentIndex > maxIndex) {
            currentIndex = 0;
        }

        const percentage = (100 / itemsVisible) * currentIndex;
        track.style.transform = `translateX(-${percentage}%)`;
    }

    // Auto Play
    function startAutoPlay() {
        stopAutoPlay(); // Clear existing to avoid dupes
        autoPlayInterval = setInterval(() => {
            moveSlide(1);
        }, 3000); // 3 seconds
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Touch / Swipe Support
    let touchStartX = 0;
    let touchEndX = 0;
    const carouselContainer = document.getElementById('carousel-container');

    carouselContainer.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoPlay();
    });

    carouselContainer.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startAutoPlay();
    });

    // Pause on hover
    carouselContainer.addEventListener('mouseenter', stopAutoPlay);
    carouselContainer.addEventListener('mouseleave', startAutoPlay);

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            moveSlide(1); // Swipe Left -> Next
        }
        if (touchEndX > touchStartX + 50) {
            moveSlide(-1); // Swipe Right -> Prev
        }
    }

    // Init
    window.addEventListener('resize', () => {
        moveSlide(0);
    });

    startAutoPlay();


    // AUDIO FUNCTIONS
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }

    function restartAudio() {
        audio.currentTime = 0;
        audio.play();
    }

    // VIDEO FUNCTIONS
    var video = document.getElementById("myVideo");

    function playVideo() {
        video.play();
    }

    function pauseVideo() {
        video.pause();
    }

    function muteVideo() {
        video.muted = !video.muted;
    }
</script>

<?php include '../includes/footer.php'; ?>