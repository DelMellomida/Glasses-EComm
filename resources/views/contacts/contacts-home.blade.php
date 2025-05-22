@if (auth()->user())
    <x-nav-user></x-nav-user>
@else
    <x-nav-guest></x-nav-guest>
@endif

<x-guest-layout>
    <div class="w-full max-w-7xl mx-auto pt-16">
        <div class="text-black font-extrabold text-2xl md:text-4xl text-center pt-8 pb-4">
            <h1>Contact Us</h1>
        </div>
        
        <div class="flex bg-white rounded-xl border border-black shadow-xl border-solid overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 min-h-96">
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed interdum tempus arcu, sit amet rhoncus libero tincidunt vel. In finibus egestas odio. Aliquam cursus non ante in porttitor. Nam accumsan nisi a congue efficitur. 
                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur sed libero ut lectus mollis auctor. Morbi suscipit elit at cursus blandit. Pellentesque massa libero, fermentum non tellus sit amet,
                        bibendum rhoncus urna. In eu risus aliquam, tincidunt erat at, ultricies velit.
                    </p>
                    
                    
                    <div class="flex justify-center lg:justify-start items-center space-x-6 pt-2">
                        <a href="#" aria-label="Facebook" class="text-gray-700 hover:text-blue-600 transition-colors duration-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.522-4.478-10-10-10S2 6.478 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.988h-2.54v-2.89h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram" class="text-gray-700 hover:text-pink-600 transition-colors duration-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.968.24 2.418.414a4.902 4.902 0 011.675 1.09 4.902 4.902 0 011.09 1.675c.174.45.36 1.248.414 2.418.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.24 1.968-.414 2.418a4.902 4.902 0 01-1.09 1.675 4.902 4.902 0 01-1.675 1.09c-.45.174-1.248.36-2.418.414-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.968-.24-2.418-.414a4.902 4.902 0 01-1.675-1.09 4.902 4.902 0 01-1.09-1.675c-.174-.45-.36-1.248-.414-2.418C2.175 15.747 2.163 15.367 2.163 12s.012-3.584.07-4.85c.054-1.17.24-1.968.414-2.418A4.902 4.902 0 013.737 3.057a4.902 4.902 0 011.675-1.09c.45-.174 1.248-.36 2.418-.414 1.266-.058 1.646-.07 4.85-.07zm0 1.838c-3.156 0-3.517.012-4.758.069-.958.045-1.48.204-1.826.34a3.093 3.093 0 00-1.127.734 3.093 3.093 0 00-.734 1.127c-.136.346-.295.868-.34 1.826-.057 1.241-.069 1.602-.069 4.758s.012 3.517.069 4.758c.045.958.204 1.48.34 1.826.179.453.419.863.734 1.127.346.179.868.295 1.826.34 1.241.057 1.602.069 4.758.069s3.517-.012 4.758-.069c.958-.045 1.48-.204 1.826-.34a3.093 3.093 0 001.127-.734 3.093 3.093 0 00.734-1.127c.136-.346.295-.868.34-1.826.057-1.241.069-1.602.069-4.758s-.012-3.517-.069-4.758c-.045-.958-.204-1.48-.34-1.826a3.093 3.093 0 00-.734-1.127 3.093 3.093 0 00-1.127-.734c-.346-.136-.868-.295-1.826-.34-1.241-.057-1.602-.069-4.758-.069zm0 4.838a5 5 0 110 10 5 5 0 010-10zm0 1.838a3.162 3.162 0 100 6.324 3.162 3.162 0 000-6.324zm6.406-3.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 p-8 lg:p-12 border-l border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h3>
                    
                    <form action="/#" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input 
                                    type="text" 
                                    name="first_name" 
                                    placeholder="First Name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 bg-white"
                                    value="{{ old('first_name') }}"
                                    required
                                >
                                @error('first_name')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <input 
                                    type="text" 
                                    name="last_name" 
                                    placeholder="Last Name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 bg-white"
                                    value="{{ old('last_name') }}"
                                    required
                                >
                                @error('last_name')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                            <div>
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="Email Address"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 bg-white"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <input 
                                type="text" 
                                name="subject" 
                                placeholder="Subject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 bg-white"
                                value="{{ old('subject') }}"
                                required
                            >
                            @error('subject')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <textarea 
                                name="message" 
                                rows="4" 
                                placeholder="Your Message"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 resize-vertical bg-white"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button 
                                type="submit"
                                class="font-semibold text-sm md:text-base px-5 py-2 rounded-full border border-white backdrop-blur-md transition-all duration-300 ease-in-out"
                                style="color: white; background-color: #0f7b99; border-color: white;"
                                onmouseover="this.style.color='#eb5638'; this.style.backgroundColor='grey';"
                                onmouseout="this.style.color='white'; this.style.backgroundColor='#0f7b99';"
                                onfocus="this.style.color='#eb5638'; this.style.backgroundColor='white';"
                                onblur="this.style.color='white'; this.style.backgroundColor='transparent';"
                                onmousedown="this.style.color='#eb5638'; this.style.backgroundColor='#0f7b99';"
                                onmouseup="this.style.color='#eb5638'; this.style.backgroundColor='#0f7b99';"                            >
                                SUBMIT
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<x-footer></x-footer>