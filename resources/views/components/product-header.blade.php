<style>
  html, body {
    overflow-x: hidden; /* Hide horizontal scrollbar */
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
    /* Set width to fit all text plus spacing */
    width: max-content; /* Automatically fit content width */
    animation: slide-slow 60s linear infinite;
  }

  .slide-item {
    margin-right: 6rem;
    white-space: nowrap;
  }

  /* Smooth continuous slide from right outside viewport to left outside viewport */
  @keyframes slide-slow {
    0% {
      transform: translateX(100vw); /* Start fully off right viewport */
    }
    100% {
      transform: translateX(calc(-1 * var(--slide-width) - 100vw)); /* Fully off left viewport */
    }
  }

  .slider-h1 {
    font-size: 6rem;
    font-weight: 900;
    color: white;
    text-shadow: 0 0 15px rgba(0,0,0,0.8);
    letter-spacing: 0.15em;
  }

  .slider-p {
    font-size: 2.5rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.85);
    text-shadow: 0 0 8px rgba(0,0,0,0.5);
    letter-spacing: 0.07em;
    margin-top: 1.5rem;
  }
</style>
<div class="w-full min-h-screen flex flex-col items-center justify-center text-center px-6 md:px-12 lg:px-24 animated-gradient">

  <!-- Heading slider -->
  <div class="slider-container mb-12">
    <div class="slide-wrapper slider-h1" id="heading-slider">
      <span class="slide-item">Elevate Your Style with Sarabia</span>
      <span class="slide-item">Find Your Perfect Eyewear Today</span>
      <span class="slide-item">Trendy Designs for Every Occasion</span>
      <span class="slide-item">See the Difference with Quality Shades</span>
      <span class="slide-item">Affordable Fashion Eyewear for All</span>
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
      <span class="slide-item">Discover trendy and affordable eyewear for every look.</span>
      <span class="slide-item">Comfort meets style in every pair we offer.</span>
      <span class="slide-item">Shop now to find your perfect match.</span>
      <span class="slide-item">Quality craftsmanship you can trust.</span>
      <span class="slide-item">Unleash your unique style with our collections.</span>
    </div>
  </div>

</div>

<script>
  // Dynamically set CSS variable for slide width to match actual content width
  function setSlideWidth(id) {
    const slider = document.getElementById(id);
    if (slider) {
      const width = slider.offsetWidth;
      slider.style.setProperty('--slide-width', width + 'px');
    }
  }

  // Set on page load
  window.addEventListener('load', () => {
    setSlideWidth('heading-slider');
    setSlideWidth('paragraph-slider');
  });

  // Optionally, update on window resize
  window.addEventListener('resize', () => {
    setSlideWidth('heading-slider');
    setSlideWidth('paragraph-slider');
  });
</script>
