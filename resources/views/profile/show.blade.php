<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tombol Kembali -->
            <a href="{{ url()->previous() }}" class="group mb-6 inline-flex items-center text-gray-500 hover:text-secondary font-medium transition">
                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 group-hover:border-secondary shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                Kembali
            </a>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                
                <!-- 1. Header Banner (Gradient) -->
                <div class="h-40 bg-gradient-to-r from-primary to-secondary relative">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                </div>
                
                <div class="px-8 pb-8">
                    <!-- 2. Bagian Header Profil (Foto, Nama, Tombol) -->
                    <div class="relative flex flex-col md:flex-row items-center md:items-end -mt-16 mb-8 gap-6">
                        
                        <!-- Foto Profil -->
                        <div class="relative z-10 shrink-0">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random&color=fff&size=128' }}" 
                                 alt="Profile" 
                                 class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white bg-white object-cover shadow-lg">
                        </div>

                        <!-- Info Nama & Jurusan -->
                        <div class="flex-1 text-center md:text-left mt-2 md:mt-0 md:mb-2">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <div class="flex items-center justify-center md:justify-start gap-2 text-gray-600 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="text-lg font-medium">{{ $user->major ?? 'Mahasiswa Unsika' }}</span>
                            </div>
                        </div>

                        <!-- Tombol Aksi (Jika profil sendiri) -->
                        @if(auth()->id() === $user->id)
                            <div class="md:mb-4">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Divider -->
                    <hr class="border-gray-100 mb-8">

                    <!-- 3. Konten Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        
                        <!-- KOLOM KIRI: TENTANG SAYA -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3 class="flex items-center text-lg font-bold text-gray-900 mb-3">
                                    <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                    Tentang Saya
                                </h3>
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $user->bio ?? 'User ini belum menambahkan bio.' }}
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: SIDEBAR -->
                        <div class="space-y-6">
                            
                            <!-- 1. SKILLS -->
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                <h3 class="flex items-center font-bold text-gray-900 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Keahlian (Skills)
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @if($user->skills)
                                        @foreach(explode(',', $user->skills) as $skill)
                                            <span class="px-3 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-secondary rounded-lg text-sm font-semibold border border-blue-100 shadow-sm">
                                                {{ trim($skill) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <p class="text-gray-500 text-sm italic">Belum ada skill.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- 2. PORTFOLIO TIM (Top 3) -->
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                <h3 class="flex items-center font-bold text-gray-900 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Portfolio Tim ({{ count($portfolio) }})
                                </h3>

                                @if($portfolio->isEmpty())
                                    <p class="text-sm text-gray-500 italic">Belum ada tim yang ditampilkan.</p>
                                @else
                                    <div class="space-y-3">
                                        @foreach($portfolio as $item)
                                        <a href="{{ $item['link'] }}" class="block border border-gray-100 rounded-lg p-4 bg-gray-50 hover:bg-blue-50 hover:border-blue-200 transition group">
                                            <div>
                                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                                    <!-- Kategori -->
                                                    <span class="text-[10px] font-bold uppercase text-blue-600 bg-blue-100 px-1.5 py-0.5 rounded">
                                                        {{ $item['category'] }}
                                                    </span>
                                                    <!-- Role (Leader/Member) -->
                                                    <span class="text-[10px] font-bold uppercase {{ $item['role'] == 'Leader' ? 'text-purple-600 bg-purple-100' : 'text-green-600 bg-green-100' }} px-1.5 py-0.5 rounded">
                                                        {{ $item['role'] }}
                                                    </span>
                                                </div>
                                                
                                                <h4 class="font-bold text-sm text-gray-800 group-hover:text-secondary transition line-clamp-1">{{ $item['title'] }}</h4>
                                                
                                                <div class="flex justify-between items-center mt-2">
                                                    <p class="text-xs text-gray-500">Status: 
                                                        @if($item['status'] == 'completed') <span class="text-green-600 font-bold">Selesai</span>
                                                        @elseif($item['status'] == 'ongoing') <span class="text-yellow-600 font-bold">Berjalan</span>
                                                        @else <span class="text-gray-500">Open</span> @endif
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover:text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- 3. KONTAK -->
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                <h3 class="flex items-center font-bold text-gray-900 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Kontak
                                </h3>
                                <p class="text-sm text-gray-600 mb-1">Email:</p>
                                <a href="mailto:{{ $user->email }}" class="text-secondary font-medium hover:underline truncate block">
                                    {{ $user->email }}
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>