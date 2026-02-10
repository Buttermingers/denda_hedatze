<?php
$page_title = 'Mediateka - Denda';
include '../includes/header.php';
?>

<link rel="stylesheet" href="css/mediateka.css">

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
                <figcaption> Epiphone SG, rock estiloko klasikoa.</figcaption>
            </figure>

            <h4>Musika (Sprite)</h4>
            <p>Musika tresnen sprite bat:</p>
            <div class="sprite-container">
                <a href="../hasiera/index.php" title="Hasierara joan">
                    <div class="sprite-icon sprite-bakarra"></div>
                </a>
            </div>


            <section>
                <h3>Audioa</h3>

                <h4>HTML5 Audio Tag</h4>

                <audio id="myAudio" controls autoplay>
                    <source src="multimedia/hendrix.mp3" type="audio/mpeg">
                    Zure nabigatzaileak ez du audio elementua onartzen.
                </audio>

                <h4>Javascript Audio Metodoak</h4>
                <div class="controls">
                    <button onclick="changeAudio('multimedia/hendrix.mp3')">Hendrix</button>
                    <button onclick="changeAudio('multimedia/clapton.mp3')">Clapton</button>
                    <br><br>
                    <button onclick="playAudio()">Play</button>
                    <button onclick="pauseAudio()">Pause</button>
                    <button onclick="restartAudio()">Hasierara</button>
                    <button onclick="changeAudioVolume(0.1)"> Vol +</button>
                    <button onclick="changeAudioVolume(-0.1)"> Vol -</button>
                </div>
            </section>

            <section>
                <h3>Bideoa</h3>

                <h4>HTML5 Video Tag</h4>

                <h4>Aukeratu bideoa:</h4>
                <div class="controls" style="margin-bottom: 20px;">
                    <button onclick="changeVideo('multimedia/video.mp4')">Fender</button>
                    <button onclick="changeVideo('multimedia/hendrix.mp4')">Hendrix live</button>
                    <button onclick="changeVideo('multimedia/clapton.mp4')">Clapton live</button>
                </div>

                <video id="myVideo" width="400" controls>
                    <source id="videoSource" src="multimedia/video.mp4" type="video/mp4">
                    Zure nabigatzaileak ez du bideo elementua onartzen.
                </video>

                <h4>Javascript Bideo Metodoak</h4>
                <div class="controls">
                    <button onclick="playVideo()">Play</button>
                    <button onclick="pauseVideo()">Pause</button>
                    <button onclick="muteVideo()">Mute/Unmute</button>
                    <button onclick="changeVideoVolume(0.1)"> Vol +</button>
                    <button onclick="changeVideoVolume(-0.1)"> Vol -</button>
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
    const track = document.getElementById('track');
    let currentIndex = 0;
    let autoPlayInterval;

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

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(() => {
            moveSlide(1);
        }, 2000);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }


    const carouselContainer = document.getElementById('carousel-container');
    let touchStartX = 0;
    let touchEndX = 0;

    carouselContainer.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoPlay();
    });

    carouselContainer.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchEndX < touchStartX - 50) moveSlide(1);
        if (touchEndX > touchStartX + 50) moveSlide(-1);
        startAutoPlay();
    });

    carouselContainer.addEventListener('mouseenter', stopAutoPlay);
    carouselContainer.addEventListener('mouseleave', startAutoPlay);
    window.addEventListener('resize', () => moveSlide(0));
    startAutoPlay();


    // --- AUDIO LOGIKA ---
    var audio = document.getElementById("myAudio");
    audio.volume = 0.3;

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

    function changeAudioVolume(amount) {
        let newVolume = audio.volume + amount;
        if (newVolume > 1) newVolume = 1;
        if (newVolume < 0) newVolume = 0;
        audio.volume = newVolume;
    }


    function changeAudio(file) {
        audio.src = file;
        audio.load();
        audio.play().catch(error => console.log("Autoplay bloqueado"));
    }


    // --- VIDEO LOGIKA ---
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

    function changeVideoVolume(amount) {
        let newVolume = video.volume + amount;
        if (newVolume > 1) newVolume = 1;
        if (newVolume < 0) newVolume = 0;
        video.volume = newVolume;
    }

    function changeVideo(file) {
        var source = document.getElementById("videoSource");
        source.src = file;
        video.src = file;
        video.load();
        video.play().catch(error => {
            console.log("Autoplay-a blokeatuta, erabiltzaileak Play sakatu behar du.");
        });
    }
</script>

<?php include '../includes/footer.php'; ?>