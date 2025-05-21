<footer class="w-full bg-[#e7e4dc] text-gray-900 font-sans text-sm mt-20">
  <div class="max-w-7xl mx-auto px-6 md:px-12 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-14 text-center md:text-left">

      <!-- Column 1: Logo + Tagline -->
      <div class="flex flex-col items-center md:items-start space-y-4 max-w-full md:max-w-md">
        <!-- Logo -->
        <div class="flex justify-center md:justify-start">
          <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-20" alt="Sarabia Logo" />
        </div>

        <!-- Tagline -->
        <div class="leading-tight text-center md:text-left">
          <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-[#111111]">
            See the
          </p>
          <p class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-[#0096a0]">
            Difference!
          </p>
        </div>
      </div>

      <!-- Column 2: Explore Navigation -->
      <div class="space-y-6">
        <p class="text-xl font-semibold text-[#0f7b99] border-b border-gray-300 pb-2 inline-block uppercase tracking-wide">
          Explore
        </p>
        <nav class="flex flex-col gap-3 text-gray-700 font-medium">
          @foreach (['Our Heritage', 'Prescription Guide', 'Stores', 'FAQ', 'Book Eye Exam', 'Contact Us'] as $item)
            <a href="#" class="hover:text-[#f04e37] transition-colors duration-300">{{ $item }}</a>
          @endforeach
        </nav>
      </div>

      <!-- Column 3: Social & Contact -->
      <div class="space-y-6">
        <!-- Social Media -->
        <div>
          <p class="text-xl font-semibold text-[#0f7b99] border-b border-gray-300 pb-2 uppercase tracking-wide">Follow Us</p>
          <div class="flex justify-center md:justify-start gap-6 text-gray-700">
            <!-- Facebook Icon -->
            <a href="#" aria-label="Facebook" class="hover:text-[#f04e37] transition-colors duration-300">
              <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22 12c0-5.522-4.478-10-10-10S2 6.478 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.988h-2.54v-2.89h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
              </svg>
            </a>
            <!-- Instagram Icon -->
            <a href="#" aria-label="Instagram" class="hover:text-[#f04e37] transition-colors duration-300">
              <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.968.24 2.418.414a4.902 4.902 0 011.675 1.09 4.902 4.902 0 011.09 1.675c.174.45.36 1.248.414 2.418.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.24 1.968-.414 2.418a4.902 4.902 0 01-1.09 1.675 4.902 4.902 0 01-1.675 1.09c-.45.174-1.248.36-2.418.414-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.968-.24-2.418-.414a4.902 4.902 0 01-1.675-1.09 4.902 4.902 0 01-1.09-1.675c-.174-.45-.36-1.248-.414-2.418C2.175 15.747 2.163 15.367 2.163 12s.012-3.584.07-4.85c.054-1.17.24-1.968.414-2.418A4.902 4.902 0 013.737 3.057a4.902 4.902 0 011.675-1.09c.45-.174 1.248-.36 2.418-.414 1.266-.058 1.646-.07 4.85-.07zm0 1.838c-3.156 0-3.517.012-4.758.069-.958.045-1.48.204-1.826.34a3.093 3.093 0 00-1.127.734 3.093 3.093 0 00-.734 1.127c-.136.346-.295.868-.34 1.826-.057 1.241-.069 1.602-.069 4.758s.012 3.517.069 4.758c.045.958.204 1.48.34 1.826.179.453.419.863.734 1.127.346.179.868.295 1.826.34 1.241.057 1.602.069 4.758.069s3.517-.012 4.758-.069c.958-.045 1.48-.204 1.826-.34a3.093 3.093 0 001.127-.734 3.093 3.093 0 00.734-1.127c.136-.346.295-.868.34-1.826.057-1.241.069-1.602.069-4.758s-.012-3.517-.069-4.758c-.045-.958-.204-1.48-.34-1.826a3.093 3.093 0 00-.734-1.127 3.093 3.093 0 00-1.127-.734c-.346-.136-.868-.295-1.826-.34-1.241-.057-1.602-.069-4.758-.069zm0 4.838a5 5 0 110 10 5 5 0 010-10zm0 1.838a3.162 3.162 0 100 6.324 3.162 3.162 0 000-6.324zm6.406-3.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
              </svg>
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
