<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Connecting-U - Kolaborasi Mahasiswa</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles (Load Tailwind) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-gray-900 bg-gray-50">
        
        <!-- Navbar -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 fixed w-full z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo & Brand -->
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" alt="Logo">
                        <span class="text-2xl font-bold text-primary tracking-tight">Connecting-U</span>
                    </div>
                    
                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-secondary transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-secondary transition">Masuk</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-secondary hover:bg-primary text-white text-sm font-bold rounded-lg transition shadow-lg shadow-blue-500/30">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative min-h-screen flex items-center pt-20 overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-[600px] h-[600px] bg-blue-100 rounded-full blur-3xl opacity-50 z-0"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-[500px] h-[500px] bg-purple-100 rounded-full blur-3xl opacity-50 z-0"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    
                    <!-- Left Content -->
                    <div class="lg:w-1/2 text-center lg:text-left">
                        <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-secondary text-sm font-bold mb-6 border border-blue-100">
                            🚀 Platform Kolaborasi No.1 di Unsika
                        </span>
                        <h1 class="text-5xl lg:text-6xl font-extrabold text-dark leading-tight mb-6">
                            Kolaborasi Tanpa Batas untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-purple-600">Mahasiswa</span>
                        </h1>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
                            Temukan tim impianmu untuk PKM, Business Plan, atau Riset Dosen. 
                            Hubungkan talenta, wujudkan ide, dan raih prestasi bersama Connecting-U.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-secondary text-white font-bold rounded-xl shadow-xl hover:bg-primary transition transform hover:-translate-y-1">
                                Mulai Kolaborasi
                            </a>
                            <!-- Tombol Pelajari Dulu mengarah ke ID features -->
                            <a href="#features" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 font-bold rounded-xl hover:bg-gray-50 transition">
                                Pelajari Dulu
                            </a>
                        </div>
                        
                        <div class="mt-10 flex items-center justify-center lg:justify-start gap-4 text-sm text-gray-500 font-medium">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center text-xs">🎓</div>
                                <div class="w-8 h-8 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs">💻</div>
                                <div class="w-8 h-8 rounded-full bg-gray-400 border-2 border-white flex items-center justify-center text-xs">🚀</div>
                            </div>
                            <p>Bergabung dengan Komunitas Unsika</p>
                        </div>
                    </div>

                    <!-- Right Image / Illustration -->
                    <div class="lg:w-1/2 flex justify-center">
                        <div class="relative w-full max-w-md aspect-square bg-gradient-to-tr from-white to-blue-50 rounded-3xl shadow-2xl border border-gray-100 p-8 flex flex-col justify-center">
                            <!-- Abstract UI Card Representation -->
                            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-4 transform rotate-2 hover:rotate-0 transition duration-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-dark">PKM-KC 2024</h3>
                                        <p class="text-xs text-gray-500">Mencari Frontend Dev</p>
                                    </div>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full w-full mb-2"></div>
                                <div class="h-2 bg-gray-100 rounded-full w-2/3"></div>
                            </div>

                            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 transform -rotate-2 hover:rotate-0 transition duration-500 z-10">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-dark">Business Plan</h3>
                                        <p class="text-xs text-gray-500">Mencari Anak Manajemen</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded font-bold">Diterima</span>
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">Full Team</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-secondary font-bold uppercase tracking-widest text-sm">Fitur Utama</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-dark mt-2">Semua yang Kamu Butuhkan</h2>
                    <p class="text-gray-500 mt-4 max-w-2xl mx-auto">Platform ini dirancang khusus untuk memenuhi kebutuhan kolaborasi akademik mahasiswa Unsika.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 text-secondary rounded-xl flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Pencarian Tim</h3>
                        <p class="text-gray-600 leading-relaxed">Cari tim berdasarkan kategori lomba (PKM, Business Plan, IT) atau filter berdasarkan skill yang kamu miliki.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition duration-300">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Kelola Pelamar</h3>
                        <p class="text-gray-600 leading-relaxed">Buat tim kamu sendiri, review profil pelamar, dan pilih anggota terbaik untuk proyekmu secara transparan.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition duration-300">
                        <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .828 1 1.5 2 1.5s2-.672 2-1.5M9.5 11l.01.011M14.5 11l.01.011" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Profil Profesional</h3>
                        <p class="text-gray-600 leading-relaxed">Tampilkan keahlian (skills), bio, dan foto profil profesionalmu agar lebih mudah direkrut oleh tim lain.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Creator Section -->
        <section class="py-24 bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-secondary font-bold uppercase tracking-widest text-sm">Credits</span>
                <h2 class="text-3xl font-extrabold text-dark mt-2 mb-12">Dibuat Oleh</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    
                    <!-- Creator 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition flex items-center gap-6 text-left">
                        <img src="https://ui-avatars.com/api/?name=Mohammad+Ichsan+Nurdin&background=324cc7&color=fff&size=128" alt="Ichsan" class="w-20 h-20 rounded-full border-4 border-blue-50">
                        <div>
                            <h3 class="text-xl font-bold text-dark">Mohammad Ichsan Nurdin</h3>
                            <p class="text-secondary font-semibold">NPM: 2310631170097</p>
                            <p class="text-gray-500 text-sm mt-1">Kelas 5A - Informatika</p>
                            <p class="text-gray-400 text-xs">Universitas Singaperbangsa Karawang</p>
                        </div>
                    </div>

                    <!-- Creator 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition flex items-center gap-6 text-left">
                        <img src="https://ui-avatars.com/api/?name=Iqbal+Umar+Kadafi&background=343b85&color=fff&size=128" alt="Iqbal" class="w-20 h-20 rounded-full border-4 border-indigo-50">
                        <div>
                            <h3 class="text-xl font-bold text-dark">Iqbal Umar Kadafi</h3>
                            <p class="text-secondary font-semibold">NPM: 2310631170091</p>
                            <p class="text-gray-500 text-sm mt-1">Kelas 5A - Informatika</p>
                            <p class="text-gray-400 text-xs">Universitas Singaperbangsa Karawang</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="bg-white py-8 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Connecting-U. Final Project Web Programming.
            </div>
        </footer>
    </body>
</html>