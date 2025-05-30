<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Smooth Slider</title>
  <style>
    html, body {
      overflow-x: hidden;
      margin: 0;
      padding: 0;
    }

    @keyframes gradient-move {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .animated-gradient {
      background: linear-gradient(-45deg, #f04e37, #ec4899, #3b82f6, #0d6b8a);
      background-size: 300% 300%;
      animation: gradient-move 12s ease infinite;
    }

    .slider-container {
      overflow: hidden;
      width: 100vw;
      max-width: 100vw;
    }

    .slide-track {
      display: flex;
      width: max-content;
      animation: scroll-left 60s linear infinite;
    }

    @keyframes scroll-left {
      0% {
        transform: translateX(0%);
      }
      100% {
        transform: translateX(-50%);
      }
    }

    .slide-item {
      margin-right: 6rem;
      white-space: nowrap;
      flex: 0 0 auto;
    }

    .slider-h1 {
      font-size: 3rem;
      font-weight: 900;
      color: white;
      text-shadow: 0 0 15px rgba(0,0,0,0.8);
      letter-spacing: 0.15em;
    }

    .slider-p {
      font-size: 1.75rem;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.85);
      text-shadow: 0 0 8px rgba(0,0,0,0.5);
      letter-spacing: 0.07em;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

<div class="w-full h-[35vh] flex flex-col items-center justify-center text-center px-6 md:px-12 lg:px-24 animated-gradient">

  <!-- Heading slider -->
  <div class="slider-container mb-6">
    <div class="slide-track slider-h1">
      <span class="slide-item">Elevate Your Style with Sarabia</span>
      <span class="slide-item">Find Your Perfect Eyewear Today</span>
      <span class="slide-item">Trendy Designs for Every Occasion</span>
      <span class="slide-item">See the Difference with Quality Shades</span>
      <span class="slide-item">Affordable Fashion Eyewear for All</span>

      <!-- Duplicate for seamless scroll -->
      <span class="slide-item">Elevate Your Style with Sarabia</span>
      <span class="slide-item">Find Your Perfect Eyewear Today</span>
      <span class="slide-item">Trendy Designs for Every Occasion</span>
      <span class="slide-item">See the Difference with Quality Shades</span>
      <span class="slide-item">Affordable Fashion Eyewear for All</span>
    </div>
  </div>

  <!-- Paragraph slider -->
  <div class="slider-container">
    <div class="slide-track slider-p">
      <span class="slide-item">Discover trendy and affordable eyewear for every look.</span>
      <span class="slide-item">Comfort meets style in every pair we offer.</span>
      <span class="slide-item">Shop now to find your perfect match.</span>
      <span class="slide-item">Quality craftsmanship you can trust.</span>
      <span class="slide-item">Unleash your unique style with our collections.</span>

      <!-- Duplicate for seamless scroll -->
      <span class="slide-item">Discover trendy and affordable eyewear for every look.</span>
      <span class="slide-item">Comfort meets style in every pair we offer.</span>
      <span class="slide-item">Shop now to find your perfect match.</span>
      <span class="slide-item">Quality craftsmanship you can trust.</span>
      <span class="slide-item">Unleash your unique style with our collections.</span>
    </div>
  </div>

</div>

</body>
</html>
