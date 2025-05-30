<style>
  /* Footer link styles */
  .footer-link {
    color: #111;
    font-family: inherit;
    font-weight: 500;
    cursor: pointer;
    position: relative;
    border: none;
    background: none;
    text-transform: uppercase;
    text-decoration: none;
    transition: color 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    padding-bottom: 2px;
    display: inline-block;
  }

  .footer-link:hover,
  .footer-link:focus {
    color: #eb5638;
  }

  .footer-link::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 1px;
    background-color: #eb5638;
    transition: width 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  }

  .footer-link:hover::after,
  .footer-link:focus::after {
    width: 75%; /* Shorter underline */
  }
</style>

<!-- Footer -->
<footer class="w-full bg-[#e7e4dc] text-gray-900 font-sans text-sm mt-20">
  <div class="max-w-7xl mx-auto px-6 md:px-12 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-14 text-center md:text-left">

      <!-- Column 1: Logo + Tagline -->
      <div class="flex flex-col items-center md:items-start space-y-4 max-w-full md:max-w-md">
        <div class="flex justify-center md:justify-start">
          <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-20" alt="Sarabia Logo" />
        </div>
        <div class="leading-tight text-center md:text-left">
          <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-[#111111]">
            See the
          </p>
          <p class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-[#eb5638]">
            Difference!
          </p>
        </div>
      </div>

      <!-- Column 2: Explore Navigation -->
      <div class="space-y-6">
        <p class="text-xl font-semibold text-[#0f7b99] border-b border-gray-300 pb-2 inline-block uppercase tracking-wide">
          Explore
        </p>
        <nav class="flex flex-col gap-3 font-medium text-base">
          <a href="{{ route('about-us') }}" class="footer-link">Our Heritage</a>
          <a href="{{ route('product.home') }}" class="footer-link">Prescription Guide</a>
          <a href="#stores" class="footer-link">Stores</a>
          <a href="#faq" class="footer-link">FAQ</a>
          <a href="#eye-exam" class="footer-link">Book Eye Exam</a>
          <a href="{{ route('contacts') }}" class="footer-link">Contact Us</a>
        </nav>
      </div>

      <!-- Column 3: Social & Contact -->
      <div class="space-y-6">
        <div>
          <p class="text-xl font-semibold text-[#0f7b99] border-b border-gray-300 pb-2 uppercase tracking-wide">Follow Us</p>
          <div class="flex justify-center md:justify-start gap-6 text-gray-700">
            <a href="#" aria-label="Facebook" class="hover:text-[#f04e37] transition duration-300 transform hover:scale-110 hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#f04e37]">
              <!-- Facebook Icon SVG -->
            </a>
            <a href="#" aria-label="Instagram" class="hover:text-[#f04e37] transition duration-300 transform hover:scale-110 hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#f04e37]">
              <!-- Instagram Icon SVG -->
            </a>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="text-gray-700 space-y-2 text-sm">
          <p class="text-xl font-semibold text-[#0f7b99] border-b border-gray-300 pb-2 uppercase tracking-wide">📞 Contact</p>
          <p class="flex items-center gap-2"><span class="text-[#f04e37]">📍</span> Manila, Philippines</p>
          <p class="flex items-center gap-2"><span class="text-[#0f7b99]">📞</span> +63 900 000 0000</p>
          <p class="flex items-center gap-2"><span class="text-[#0f7b99]">✉️</span> hello@Sarabia.ph</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Elegant Gradient Bar -->
  <div class="w-full bg-gradient-to-r from-[#0f7b99] via-[#145d6d] to-[#0b4a58] text-white text-xs text-center py-4 tracking-wide shadow-inner uppercase">
    © 2025 <span class="font-semibold">Sarabia Optical</span>. All rights reserved.
  </div>
</footer>
