<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Welcome -->
            <div class="bg-primary rounded-2xl p-8 mb-8 text-white flex flex-col md:flex-row justify-between items-center shadow-lg gap-6">
                <div class="flex items-center gap-6">
                    <!-- Tampilkan Foto Profil User yang Login -->
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random&color=fff' }}" 
                         class="w-20 h-20 rounded-full border-4 border-white/20 object-cover shadow-xl bg-white" 
                         alt="Profile">
                    
                    <div>
                       <h2 class="text-2xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h2>
                       <p class="text-blue-200">Siap untuk berkolaborasi hari ini?</p>
                    </div>
                </div>

                <a href="{{ route('recruitments.create') }}" class="px-6 py-3 bg-secondary hover:bg-white hover:text-secondary text-white rounded-lg font-bold transition flex items-center gap-2 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Buat Tim Baru
                </a>
             </div>
   
            <!-- Search & Filter Form -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-8">
                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" placeholder="Cari project, skill, atau nama tim..." value="{{ request('search') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-secondary outline-none cursor-pointer">
                        <option value="All">Semua Kategori</option>
                        <option value="PKM" {{ request('category') == 'PKM' ? 'selected' : '' }}>PKM</option>
                        <option value="Business Plan" {{ request('category') == 'Business Plan' ? 'selected' : '' }}>Business Plan</option>
                        <option value="Lomba IT" {{ request('category') == 'Lomba IT' ? 'selected' : '' }}>Lomba IT</option>
                        <option value="Riset" {{ request('category') == 'Riset' ? 'selected' : '' }}>Riset</option>
                        <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    
                    <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-lg font-medium transition">Cari</button>
                </form>
            </div>
   
            <!-- Grid Posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recruitments as $post)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-gray-200 flex flex-col h-full overflow-hidden">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <!-- Badge Kategori dengan Warna Dinamis -->
                            @php
                                $badgeColor = match($post->category) {
                                    'PKM' => 'bg-blue-100 text-blue-800',
                                    'Business Plan' => 'bg-green-100 text-green-800',
                                    'Lomba IT' => 'bg-purple-100 text-purple-800',
                                    'Riset' => 'bg-orange-100 text-orange-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                
                                $isExpired = \Carbon\Carbon::parse($post->deadline)->endOfDay()->isPast();
                            @endphp
                            <span class="px-2 py-1 {{ $badgeColor }} rounded-md text-xs font-bold uppercase tracking-wide">{{ $post->category }}</span>
                            
                            <!-- INDIKATOR STATUS CARD -->
                            @if($post->status == 'ongoing')
                                <span class="text-yellow-600 text-xs font-bold border border-yellow-200 bg-yellow-50 px-2 py-1 rounded">ON GOING</span>
                            @elseif($post->status == 'completed')
                                <span class="text-gray-600 text-xs font-bold border border-gray-200 bg-gray-50 px-2 py-1 rounded">SELESAI</span>
                            @elseif($isExpired)
                                <span class="text-red-600 text-xs font-bold border border-red-200 bg-red-50 px-2 py-1 rounded">CLOSED</span>
                            @endif

                            @if($post->user_id === Auth::id())
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold border border-gray-200">Project Saya</span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-primary mb-2 line-clamp-2 hover:text-secondary transition">
                            <a href="{{ route('recruitments.show', $post->id) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3 leading-relaxed">{{ Str::limit($post->description, 100) }}</p>
                        
                        <!-- Tags Requirements -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(explode(',', $post->requirements) as $index => $req)
                                @if($index < 3) <!-- Batasi tampilan tags max 3 biar rapi -->
                                    <span class="px-2 py-1 bg-gray-50 text-gray-500 text-xs rounded border border-gray-100">{{ trim($req) }}</span>
                                @endif
                            @endforeach
                            @if(count(explode(',', $post->requirements)) > 3)
                                <span class="text-xs text-gray-400 self-center">+{{ count(explode(',', $post->requirements)) - 3 }} lainnya</span>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Card: Author & Action -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <!-- Tampilkan Foto Author Postingan -->
                            <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&background=random&color=fff' }}" 
                                 class="w-8 h-8 rounded-full object-cover border border-gray-200 bg-white"
                                 alt="{{ $post->user->name }}">
                            
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-700 truncate max-w-[120px]" title="{{ $post->user->name }}">
                                    {{ $post->user->name }}
                                </span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wide">Ketua Tim</span>
                            </div>
                        </div>

                        <a href="{{ route('recruitments.show', $post->id) }}" class="text-secondary text-sm font-bold hover:underline flex items-center gap-1 group">
                            Detail <span class="group-hover:translate-x-1 transition-transform" aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State jika tidak ada data -->
            @if($recruitments->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl border border-gray-200 mt-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada project ditemukan</h3>
                    <p class="text-gray-500 mt-1">Coba cari dengan kata kunci lain atau buat tim baru.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>