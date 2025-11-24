<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Navigasi & Alert -->
            <a href="{{ route('dashboard') }}" class="mb-6 inline-flex items-center text-gray-500 hover:text-secondary">
                &larr; Kembali ke Dashboard
            </a>

            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-800 p-4 rounded-lg mb-6">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-200 text-red-800 p-4 rounded-lg mb-6">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- KOLOM KIRI: DETAIL UTAMA -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-8">
                        <!-- Header & Status -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-2">
                                <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-md font-bold">{{ $recruitment->category }}</span>
                                
                                <!-- LOGIKA STATUS BARU -->
                                @php
                                    $isExpired = \Carbon\Carbon::parse($recruitment->deadline)->endOfDay()->isPast();
                                @endphp

                                @if($recruitment->status == 'completed')
                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md text-sm font-bold">COMPLETED</span>
                                @elseif($recruitment->status == 'ongoing')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-md text-sm font-bold animate-pulse">ON GOING</span>
                                @else
                                    {{-- Status masih 'open' di database --}}
                                    @if($isExpired)
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-md text-sm font-bold">CLOSED RECRUITMENT</span>
                                    @else
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-bold">OPEN RECRUITMENT</span>
                                    @endif
                                @endif
                            </div>
                            <span class="{{ $isExpired ? 'text-red-500 font-bold' : 'text-gray-500' }} text-sm">
                                Deadline: {{ \Carbon\Carbon::parse($recruitment->deadline)->format('d M Y') }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-dark mb-6">{{ $recruitment->title }}</h1>
                        
                        <h3 class="font-bold text-lg mb-2">Deskripsi</h3>
                        <p class="text-gray-600 whitespace-pre-line mb-6">{{ $recruitment->description }}</p>

                        <!-- File Proposal -->
                        @if($recruitment->proposal_file)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-red-100 text-red-500 rounded flex items-center justify-center font-bold">PDF</div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Dokumen Project</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $recruitment->proposal_file) }}" target="_blank" class="text-secondary font-bold text-sm hover:underline">Download</a>
                            </div>
                        @endif
                    </div>

                    <!-- AREA DISKUSI TIM -->
                    @if($isLeader || $isMember)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[500px]">
                        <div class="p-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-bold text-dark">Ruang Diskusi Tim</h3>
                        </div>
                        
                        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50" id="chat-container">
                            @if($chats->isEmpty())
                                <p class="text-center text-gray-400 text-sm py-10">Belum ada pesan.</p>
                            @else
                                @foreach($chats as $chat)
                                    <div class="flex {{ $chat->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[80%] {{ $chat->user_id === Auth::id() ? 'bg-secondary text-white' : 'bg-white border border-gray-200 text-gray-800' }} rounded-lg p-3 shadow-sm">
                                            @if($chat->user_id !== Auth::id())
                                                <p class="text-xs font-bold mb-1 text-secondary">{{ $chat->user->name }}</p>
                                            @endif
                                            <p class="text-sm">{{ $chat->message }}</p>
                                            <p class="text-[10px] {{ $chat->user_id === Auth::id() ? 'text-blue-200' : 'text-gray-400' }} text-right mt-1">
                                                {{ $chat->created_at->format('H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="p-4 bg-white border-t border-gray-100">
                            <form action="{{ route('recruitments.chat', $recruitment->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="message" autocomplete="off" class="flex-1 border-gray-300 rounded-lg text-sm" placeholder="Ketik pesan..." required>
                                <button type="submit" class="bg-secondary text-white p-2 rounded-lg hover:bg-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- KOLOM KANAN: SIDEBAR -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Menu Ketua Tim -->
                    @if($isLeader)
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-dark mb-4">Menu Ketua Tim</h3>
                        
                        <form action="{{ route('recruitments.status', $recruitment->id) }}" method="POST" class="mb-4">
                            @csrf @method('PATCH')
                            <label class="text-xs font-bold text-gray-500 mb-1 block">Update Status Project</label>
                            <div class="flex gap-2">
                                <select name="status" class="w-full text-sm border-gray-300 rounded-lg">
                                    <!-- LOGIKA OPSI SELECT -->
                                    @if(!$isExpired) 
                                        {{-- Kalau belum expired, boleh pilih Open --}}
                                        <option value="open" {{ $recruitment->status == 'open' ? 'selected' : '' }}>Open Recruitment</option>
                                    @elseif($recruitment->status == 'open')
                                        {{-- Kalau sudah expired tapi status masih open, kasih opsi placeholder biar user sadar harus ganti --}}
                                        <option value="open" disabled selected>Recruitment Ditutup (Silakan Update)</option>
                                    @endif
                                    
                                    <option value="ongoing" {{ $recruitment->status == 'ongoing' ? 'selected' : '' }}>On Going (Mulai Proyek)</option>
                                    <option value="completed" {{ $recruitment->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <button class="bg-primary text-white px-3 rounded-lg text-sm">Ok</button>
                            </div>
                        </form>

                        <form action="{{ route('recruitments.file', $recruitment->id) }}" method="POST" enctype="multipart/form-data" class="mb-4 border-t pt-4">
                            @csrf
                            <label class="text-xs font-bold text-gray-500 mb-1 block">Upload File</label>
                            <input type="file" name="proposal_file" class="w-full text-xs mb-2">
                            <button class="w-full bg-secondary text-white py-2 rounded-lg text-sm font-bold">Upload</button>
                        </form>

                        <a href="{{ route('my-teams') }}" class="block w-full text-center border border-secondary text-secondary py-2 rounded-lg font-bold text-sm hover:bg-blue-50">Kelola Pelamar</a>
                    </div>
                    @endif

                    <!-- DAFTAR ANGGOTA TIM (DIPERBARUI) -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                         <h3 class="font-bold text-dark mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Anggota Tim
                         </h3>
                         
                         <div class="space-y-4">
                             <!-- 1. Leader (Highlight) -->
                             <div class="relative">
                                <span class="absolute -top-2 -right-2 bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-purple-200 z-10">Leader</span>
                                <a href="{{ route('user.show', $recruitment->user->id) }}" class="flex items-center gap-3 p-2 rounded-lg border border-purple-100 bg-purple-50 hover:bg-purple-100 transition">
                                     <img src="{{ $recruitment->user->avatar ? asset('storage/' . $recruitment->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($recruitment->user->name).'&background=random&color=fff' }}" 
                                          class="w-10 h-10 rounded-full object-cover border-2 border-white">
                                     <div>
                                         <p class="font-bold text-dark text-sm">{{ $recruitment->user->name }}</p>
                                         <p class="text-xs text-gray-500">{{ $recruitment->user->major ?? 'Mahasiswa' }}</p>
                                     </div>
                                </a>
                             </div>

                             <!-- 2. Members (Accepted Only) -->
                             @php
                                 $members = $recruitment->applications->where('status', 'accepted');
                             @endphp

                             @if($members->count() > 0)
                                 <div class="space-y-2 border-t border-gray-100 pt-2">
                                     <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Anggota</p>
                                     @foreach($members as $member)
                                         <a href="{{ route('user.show', $member->user->id) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
                                             <img src="{{ $member->user->avatar ? asset('storage/' . $member->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($member->user->name).'&background=random&color=fff' }}" 
                                                  class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                             <div>
                                                 <p class="font-bold text-dark text-sm">{{ $member->user->name }}</p>
                                                 <p class="text-xs text-gray-500">{{ $member->user->major ?? 'Mahasiswa' }}</p>
                                             </div>
                                         </a>
                                     @endforeach
                                 </div>
                             @elseif(!$isLeader) 
                                <!-- Jika tidak ada member lain dan bukan leader -->
                                <p class="text-xs text-gray-400 italic text-center py-2">Belum ada anggota bergabung.</p>
                             @endif
                         </div>
                    </div>
                    
                    <!-- Tombol Join -->
                    @if(!$isLeader && !$isMember)
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h3 class="font-bold text-dark mb-4">Gabung Tim</h3>
                        
                        @if($hasApplied)
                             <button disabled class="w-full bg-gray-200 text-gray-500 py-3 rounded-lg font-bold cursor-not-allowed">Sudah Melamar</button>
                        @elseif($isExpired || $recruitment->status != 'open')
                             <!-- Tombol Disabled jika Deadline lewat ATAU Status bukan Open (misal Ongoing) -->
                             <button disabled class="w-full bg-red-50 text-red-500 border border-red-200 py-3 rounded-lg font-bold cursor-not-allowed">
                                 {{ $isExpired ? 'Pendaftaran Ditutup' : 'Rekrutmen Selesai' }}
                             </button>
                        @else
                             <form action="{{ route('recruitments.join', $recruitment->id) }}" method="POST">
                                @csrf
                                <textarea name="message" rows="3" class="w-full border-gray-300 rounded-lg text-sm mb-2" placeholder="Pesan..." required></textarea>
                                <button class="w-full bg-secondary text-white py-2 rounded-lg font-bold">Ajukan Diri</button>
                             </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>