<div class="flex items-center justify-center min-h-screen bg-[#D9EBFD] p-4">
    <!-- Center Container with stricter max-width -->
    <div class="w-full max-w-[300px] flex flex-col items-center">
        
        <!-- Icon (Smaller proportional sizing) -->
        <div class="mb-6 text-[#2185D5]">
            <div class="w-20 h-20 rounded-full border-[2.5px] border-[#2185D5] flex items-center justify-center bg-transparent">
                <svg viewBox="0 0 24 24" class="w-14 h-14 fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </div>
        </div>

        <!-- Compact Form -->
        <div class="w-full">
            <form wire:submit="authenticate" class="space-y-4">
                <div class="space-y-3">
                    {{ $this->form }}
                </div>

                <!-- Action links with tight spacing -->
                <div class="flex items-center justify-between text-[#2185D5] text-[10px] font-bold px-0.5">
                    <div class="flex items-center space-x-1 cursor-pointer">
                        <x-filament::input.checkbox wire:model="remember" id="remember" class="w-3 h-3 border-[#2185D5] text-[#2185D5] focus:ring-[#2185D5]" />
                        <label for="remember" class="cursor-pointer tracking-tighter">Remember me</label>
                    </div>

                    @if (filament()->hasPasswordReset())
                        <a href="{{ $this->getPasswordResetUrl() }}" class="hover:underline tracking-tighter">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button (Compact height) -->
                <div class="pt-1">
                    <button type="submit" class="w-full bg-[#2185D5] hover:bg-[#1A6FB3] text-white font-bold py-2 rounded-lg text-base transition-all shadow-sm uppercase tracking-widest">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        body {
            background-color: #D9EBFD !important;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Essential Filament Overrides for small view */
        .fi-input-wrp {
            background-color: #EBF5FF !important;
            border: 1.5px solid #2185D5 !important;
            border-radius: 6px !important;
            padding: 0px 4px !important;
            box-shadow: none !important;
        }

        .fi-input-wrp input {
            background-color: transparent !important;
            color: #2185D5 !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            height: 36px !important;
        }

        .fi-input-wrp input::placeholder {
            color: #2185D5 !important;
            opacity: 0.5;
        }

        .fi-input-wrp svg {
            color: #2185D5 !important;
            width: 16px !important;
            height: 16px !important;
        }

        .fi-fo-field-wrp-label {
            display: none !important;
        }

        .fi-fo-field-wrp {
            margin: 0 !important;
        }
    </style>
</div>
