<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Silde</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
    }

    .slider-container {
      max-width: 100%;
      overflow: hidden;
      padding: 40px 0 60px;
      position: relative;
    }

    .slides {
      display: flex;
      gap: 16px;
      transition: transform 0.5s ease-in-out;
      padding: 0 20px;
    }

    .slide {
      flex: 0 0 60%;
      max-width: 60%;
      transition: transform 0.3s;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .slide img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      display: block;
    }

    .nav-button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: #fff;
      border: none;
      font-size: 22px;
      padding: 8px;
      cursor: pointer;
      border-radius: 50%;
      z-index: 2;
    }

    .nav-button:hover {
      background: rgba(0,0,0,0.8);
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }

    .indicator {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.6);
      color: #fff;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="slider-container" id="sliderContainer">
  <div class="slides" id="slideTrack">
    <?php
      $banners = ['10.jpg', '11.jpg', '12.jpg', '13.jpg', '14.jpg'];
      foreach ($banners as $banner) {
        echo '<div class="slide"><img src="IMG/'.$banner.'" alt="Banner"></div>';
      }
    ?>
  </div>

  <button class="nav-button prev" onclick="prevSlide()">❮</button>
  <button class="nav-button next" onclick="nextSlide()">❯</button>
  <div class="indicator" id="slideIndicator">1 / <?php echo count($banners); ?></div>
</div>

<script>
  const slideTrack = document.getElementById('slideTrack');
  const slides = document.querySelectorAll('.slide');
  const slideCount = slides.length;
  const indicator = document.getElementById('slideIndicator');
  let currentIndex = 0;

  function updateSlidePosition() {
    const slideWidth = slides[0].offsetWidth + 16; // Slide width + gap
    slideTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    indicator.textContent = `${currentIndex + 1} / ${slideCount}`;
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slideCount;
    updateSlidePosition();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + slideCount) % slideCount;
    updateSlidePosition();
  }

  // Auto slide
  let autoPlay = setInterval(nextSlide, 3000);

  // Pause on hover
  const container = document.getElementById('sliderContainer');
  container.addEventListener('mouseenter', () => clearInterval(autoPlay));
  container.addEventListener('mouseleave', () => autoPlay = setInterval(nextSlide, 3000));

  window.addEventListener('resize', updateSlidePosition);
  window.addEventListener('load', updateSlidePosition);
</script>

</body>
</html>
