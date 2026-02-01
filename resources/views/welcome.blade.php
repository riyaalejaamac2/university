<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Attendance System | Gollis University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-[#F8FBFF] text-gray-900">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 py-4 px-6 lg:px-20 transition-all duration-300">
        <div
            class="max-w-7xl mx-auto flex justify-between items-center bg-white/80 backdrop-blur-md px-6 py-3 rounded-2xl shadow-sm border border-blue-50/50">
            <div class="flex items-center space-x-2 text-[#2185D5]">
                <svg viewBox="0 0 24 24" class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2L1 21h22L12 2zm0 3.45l8.15 14.1H3.85L12 5.45zM12 17c.55 0 1-.45 1-1s-.45-1-1-1-1 .45-1 1 .45 1 1 1zm0-3c.55 0 1-.45 1-1V9.5c0-.55-.45-1-1-1s-1 .45-1 1V13c0 .55.45 1 1 1z" />
                </svg>
                <span class="font-black text-xl tracking-tight">GOLLIS <span
                        class="text-gray-400 font-normal">UNIVERSITY</span></span>
            </div>
            <div
                class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                <a href="#features" class="hover:text-primary-500 transition-colors">Features</a>
                <a href="#about" class="hover:text-primary-500 transition-colors">About</a>
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-[#2185D5] text-white rounded-xl shadow-lg shadow-blue-500/20 hover:bg-[#1A6FB3] transition-all">Enter Portal</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 px-6">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(33,133,213,0.05),_transparent_50%)]">
        </div>
        <div class="max-w-7xl mx-auto text-center z-10">
            <span
                class="inline-block px-4 py-1.5 bg-blue-100 text-[#2185D5] rounded-full text-xs font-black uppercase tracking-widest mb-6">
                Next-Gen Academic Tracking
            </span>
            <h1 class="text-6xl lg:text-8xl font-black text-gray-900 tracking-tighter mb-8 leading-[0.9]">
                University <br>
                <span class="text-[#2185D5]">Attendance System</span>
            </h1>
            <p class="max-w-2xl mx-auto text-xl text-gray-500 mb-10 leading-relaxed font-light">
                Empowering Gollis University with real-time academic tracking, automated reporting, and secure
                role-based access for faculty and administration.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="group relative px-8 py-4 bg-[#2185D5] text-white text-lg font-bold rounded-2xl shadow-2xl shadow-blue-500/30 overflow-hidden transition-all hover:-translate-y-1">
                    <span class="relative z-10 flex items-center uppercase tracking-widest">
                        Access the System
                        <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </span>
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
                <a href="#"
                    class="px-8 py-4 text-gray-400 text-lg font-bold rounded-2xl hover:text-gray-900 transition-all uppercase tracking-widest">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Background Elements -->
    <div class="fixed bottom-0 right-0 w-96 h-96 bg-[#2185D5]/5 blur-[120px] rounded-full -z-10"></div>
    <div class="fixed top-20 left-0 w-72 h-72 bg-[#2185D5]/3 blur-[100px] rounded-full -z-10"></div>
</body>

</html>