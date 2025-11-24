<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-primary">Manajemen Tim Saya</h1>
                <a href="{{ route('recruitments.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-primary transition">+ Buat Tim Baru</a>
            </div>
            
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-6">{{ session('success') }}</div>
            @endif

            <div class="space-y-8">
                @foreach($myRecruitments as $post)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    
                    <!-- Header Project: Judul & Status -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-bold text-dark">{{ $post->title }}</h3>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded font-bold">{{ $post->category }}</span>
                            </div>
                            <p class="text-xs text-gray-500">Dibuat pada: {{ $post->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <!-- Status Indicator Leader -->
                            @php $isExpired = \Carbon\Carbon::parse($post->deadline)->endOfDay()->isPast(); @endphp
                            
                            <div class="flex items-center gap-2 px-3 py-1 rounded-lg border bg-white">
                                <span class="text-xs text-gray-500 font-bold">Status:</span>
                                @if($post->status == 'completed')
                                    <span class="text-gray-600 font-bold text-sm">COMPLETED</span>
                                @elseif($post->status == 'ongoing')
                                    <span class="text-yellow-600 font-bold text-sm">ON GOING</span>
                                @elseif($isExpired)
                                    <span class="text-red-600 font-bold text-sm">CLOSED</span>
                                @else
                                    <span class="text-green-600 font-bold text-sm">OPEN</span>
                                @endif
                            </div>

                            <!-- Tombol Masuk ke Halaman Detail (Chat/File) -->
                            <a href="{{ route('recruitments.show', $post->id) }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-secondary transition">
                                <span>Lihat Project & Chat</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Body: Daftar Pelamar -->
                    <div class="p-6">
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Daftar Pelamar & Anggota ({{ $post->applications->count() }})</h4>
                        
                        @if($post->applications->isEmpty())
                            <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-400 text-sm">Belum ada pelamar masuk.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($post->applications as $app)
                                    <div class="flex justify-between items-start p-4 rounded-lg border {{ $app->status == 'accepted' ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white' }}">
                                        <div class="flex items-center gap-3">
                                            <!-- Avatar Pelamar -->
                                            <img src="{{ $app->user->avatar ? asset('storage/' . $app->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($app->user->name).'&background=random' }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                            <div>
                                                <a href="{{ route('user.show', $app->user->id) }}" class="font-bold text-dark text-sm hover:underline hover:text-secondary">
                                                    {{ $app->user->name }}
                                                </a>
                                                <p class="text-xs text-gray-500">{{ $app->user->major ?? 'Mahasiswa' }}</p>
                                                
                                                <!-- Pesan Pelamar -->
                                                <div x-data="{ open: false }">
                                                    <button @click="open = !open" class="text-[10px] text-blue-600 hover:underline mt-1">Lihat Pesan</button>
                                                    <div x-show="open" class="mt-1 text-xs text-gray-600 italic bg-white p-2 rounded border">
                                                        "{{ $app->message }}"
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-end gap-2">
                                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                                {{ $app->status == 'accepted' ? 'bg-green-100 text-green-800' : ($app->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $app->status }}
                                            </span>

                                            @if($app->status == 'pending')
                                            <div class="flex gap-1">
                                                <form action="{{ route('applications.update-status', $app->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button name="status" value="accepted" class="p-1 bg-green-500 text-white rounded hover:bg-green-600" title="Terima">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('applications.update-status', $app->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button name="status" value="rejected" class="p-1 bg-red-500 text-white rounded hover:bg-red-600" title="Tolak">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>