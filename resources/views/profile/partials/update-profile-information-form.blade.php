<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update data diri dan pilih project terbaikmu (Maksimal 3).") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf @method('patch')

        <!-- Foto, Nama, Email, Jurusan, Bio, Skills -->
        <div class="flex items-start gap-6">
            <div class="shrink-0">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="h-20 w-20 rounded-full object-cover border-2 border-gray-200" />
            </div>
            <div class="w-full">
                <x-input-label for="avatar" :value="__('Ganti Foto Profil')" />
                <input type="file" name="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-secondary hover:file:bg-blue-100 mt-2 border border-gray-300 rounded-lg" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><x-input-label for="name" :value="__('Nama Lengkap')" /><x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required /></div>
            <div><x-input-label for="email" :value="__('Email')" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required /></div>
            <div class="md:col-span-2"><x-input-label for="major" :value="__('Jurusan')" /><x-text-input id="major" name="major" type="text" class="mt-1 block w-full" :value="old('major', $user->major)" /></div>
            <div class="md:col-span-2"><x-input-label for="bio" :value="__('Bio Singkat')" /><textarea name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $user->bio) }}</textarea></div>
            <div class="md:col-span-2"><x-input-label for="skills" :value="__('Skills (Pisahkan koma)')" /><x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->skills)" /></div>
        </div>

        <!-- PILIH PORTFOLIO -->
        <div class="border-t pt-6 mt-6">
            <h3 class="text-md font-bold text-gray-900 mb-2">Pilih Portfolio (Maks. 3)</h3>
            <p class="text-sm text-gray-500 mb-4">Centang project yang ingin ditampilkan di profil publik.</p>

            <div class="space-y-4" x-data="{ 
                count: {{ $user->recruitments->where('is_pinned', true)->count() + $user->applications->where('is_pinned', true)->count() }},
                checkLimit(e) {
                    if (e.target.checked) {
                        if (this.count >= 3) {
                            e.preventDefault();
                            alert('Maksimal 3 portfolio!');
                        } else {
                            this.count++;
                        }
                    } else {
                        this.count--;
                    }
                }
            }">
                
                <!-- 1. Project Buatan Saya (Leader) -->
                @if($ownedTeams->isNotEmpty())
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Project Saya (Leader)</h4>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($ownedTeams as $team)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="portfolio[]" value="rec_{{ $team->id }}" 
                                       class="w-5 h-5 text-secondary rounded focus:ring-secondary"
                                       {{ $team->is_pinned ? 'checked' : '' }} @change="checkLimit($event)">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold">{{ $team->title }}</span>
                                    <span class="text-xs text-gray-500">{{ $team->category }} • {{ $team->status }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif

                <!-- 2. Project yang Diikuti (Member) -->
                @if($joinedTeams->isNotEmpty())
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-2">Project Diikuti (Member)</h4>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($joinedTeams as $app)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="portfolio[]" value="app_{{ $app->id }}" 
                                       class="w-5 h-5 text-secondary rounded focus:ring-secondary"
                                       {{ $app->is_pinned ? 'checked' : '' }} @change="checkLimit($event)">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold">{{ $app->recruitment->title }}</span>
                                    <span class="text-xs text-gray-500">{{ $app->recruitment->category }} • {{ $app->recruitment->status }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif

                @if($ownedTeams->isEmpty() && $joinedTeams->isEmpty())
                    <p class="text-sm text-gray-400 italic">Belum ada data project.</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold">{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>