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
    margin: 0 auto;
  }

  .slide-wrapper {
    display: inline-flex;
    white-space: nowrap;
    width: max-content;
    animation: slide-slow 60s linear infinite;
  }

  .slide-item {
    margin-right: 6rem;
    white-space: nowrap;
  }

  @keyframes slide-slow {
    0% {
      transform: translateX(100vw);
    }
    100% {
      transform: translateX(calc(-1 * var(--slide-width) - 100vw));
    }
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

<div class="w-full h-[35vh] flex flex-col items-center justify-center text-center px-6 md:px-12 lg:px-24 animated-gradient">

  <!-- Heading slider -->
  <div class="slider-container mb-6">
    <div class="slide-wrapper slider-h1" id="heading-slider">
      <span class="slide-item">Elevate Your Style with Sarabia</span>
      <span class="slide-item">Find Your Perfect Eyewear Today</span>
      <span class="slide-item">Trendy Designs for Every Occasion</span>
      <span class="slide-item">See the Difference with Quality Shades</span>
      <span class="slide-item">Affordable Fashion Eyewear for All</span>
    </div>
  </div>

  <!-- Paragraph slider -->
  <div class="slider-container">
    <div class="slide-wrapper slider-p" id="paragraph-slider">
      <span class="slide-item">Discover trendy and affordable eyewear for every look.</span>
      <span class="slide-item">Comfort meets style in every pair we offer.</span>
      <span class="slide-item">Shop now to find your perfect match.</span>
      <span class="slide-item">Quality craftsmanship you can trust.</span>
      <span class="slide-item">Unleash your unique style with our collections.</span>
    </div>
  </div>

</div>

<script>
  function setSlideWidth(id) {
    const slider = document.getElementById(id);
    if (slider) {
      const width = slider.offsetWidth;
      slider.style.setProperty('--slide-width', width + 'px');
    }
  }

  window.addEventListener('load', () => {
    setSlideWidth('heading-slider');
    setSlideWidth('paragraph-slider');
  });

  window.addEventListener('resize', () => {
    setSlideWidth('heading-slider');
    setSlideWidth('paragraph-slider');
  });
</script>
