<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-primary mb-6">Riwayat Lamaran Saya</h1>

            @if($joinedTeams->isEmpty())
                <div class="bg-white p-8 rounded-xl border border-gray-200 text-center shadow-sm">
                    <div class="mb-4 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat lamaran</h3>
                    <p class="text-gray-500 mt-1">Anda belum melamar ke tim manapun.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-secondary text-white rounded-lg hover:bg-primary transition">Cari Tim</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($joinedTeams as $app)
                        @php
                            // Cek Deadline untuk status project
                            $isExpired = \Carbon\Carbon::parse($app->recruitment->deadline)->isPast();
                        @endphp

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition overflow-hidden flex flex-col h-full">
                            <!-- Status Header (Warna berdasarkan Status Lamaran) -->
                            <div class="h-2 
                                {{ $app->status === 'accepted' ? 'bg-green-500' : 
                                  ($app->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-400') }}">
                            </div>
                            
                            <div class="p-6 flex-1">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-2 py-1 bg-blue-50 text-secondary text-xs font-bold rounded uppercase">
                                        {{ $app->recruitment->category }}
                                    </span>
                                    
                                    <!-- Label Status Lamaran -->
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                        {{ $app->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                          ($app->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $app->status === 'accepted' ? 'Diterima' : ($app->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-dark mb-2">{{ $app->recruitment->title }}</h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $app->recruitment->description }}</p>

                                <!-- Pesan yang kita kirim -->
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-4">
                                    <p class="text-xs text-gray-400 font-bold mb-1">Pesan Anda:</p>
                                    <p class="text-sm text-gray-600 italic">"{{ Str::limit($app->message, 50) }}"</p>
                                </div>

                                <div class="border-t border-gray-100 pt-4 mt-auto">
                                    <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                                        <span>Ketua: <strong>{{ $app->recruitment->user->name }}</strong></span>
                                        <span>
                                            @if($isExpired)
                                                <span class="text-red-500 font-bold">Berakhir</span>
                                            @else
                                                <span class="text-green-600 font-bold">Aktif</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <a href="{{ route('recruitments.show', $app->recruitment->id) }}" class="block text-center w-full px-4 py-2 border border-secondary text-secondary rounded-lg hover:bg-blue-50 transition text-sm font-bold">
                                        Lihat Detail Project
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>