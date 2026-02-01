<div class="fixed inset-0 z-[10000] flex items-center justify-center bg-[#D9EBFD]">
    <!-- Highly Compact Design (220px) -->
    <div class="w-full max-w-[220px] flex flex-col items-center">

        <!-- Icon -->
        <div class="mb-5 text-[#2185D5]">
            <div
                class="w-16 h-16 rounded-full border-[2px] border-[#2185D5] flex items-center justify-center bg-transparent">
                <svg viewBox="0 0 24 24" class="w-10 h-10 fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                </svg>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full">
            <form wire:submit="login" class="space-y-3">
                <!-- Username -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-[#2185D5]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model="email" type="email" placeholder="Username"
                        class="block w-full pl-8 pr-3 py-1.5 bg-[#EBF5FF] border-[1.5px] border-[#2185D5] rounded-lg text-[#2185D5] font-extrabold text-xs placeholder-[#2185D5]/50 focus:outline-none focus:ring-1 focus:ring-[#2185D5]/20 transition-all">
                </div>

                <!-- Password -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-[#2185D5]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model="password" type="password" placeholder="Password"
                        class="block w-full pl-8 pr-8 py-1.5 bg-[#EBF5FF] border-[1.5px] border-[#2185D5] rounded-lg text-[#2185D5] font-extrabold text-xs placeholder-[#2185D5]/50 focus:outline-none focus:ring-1 focus:ring-[#2185D5]/20 transition-all">
                    <div class="absolute inset-y-0 right-0 pr-2 flex items-center opacity-60">
                        <svg class="h-4 w-4 text-[#2185D5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268-2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="flex items-center justify-between text-[#2185D5] text-[9px] font-black px-0.5">
                    <div class="flex items-center space-x-1 cursor-pointer">
                        <input wire:model="remember" type="checkbox" id="rm_me"
                            class="w-3 h-3 rounded-sm border-[#2185D5] accent-[#2185D5]">
                        <label for="rm_me" class="cursor-pointer">Remember me</label>
                    </div>
                    <a href="#" class="hover:underline">Forgot password?</a>
                </div>

                <!-- Error (Absolute positioning to not shift layout) -->
                @if($errors->any())
                    <div class="text-[8px] text-red-600 font-black text-center uppercase tracking-tighter">
                        Invalid Credentials
                    </div>
                @endif

                <!-- Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-[#2185D5] hover:bg-[#1A6FB3] text-white font-black py-2 rounded-xl text-base transition-all shadow-md active:scale-95 uppercase tracking-widest">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        body {
            background-color: #D9EBFD !important;
            overflow: hidden !important;
            margin: 0 !important;
        }
    </style>
</div>