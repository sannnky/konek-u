<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-primary p-6 text-white">
                    <h2 class="text-2xl font-bold">Buat Rekrutmen Tim Baru</h2>
                    <p class="text-blue-200 mt-1">Isi detail untuk menemukan anggota tim yang tepat.</p>
                </div>

                <form action="{{ route('recruitments.store') }}" method="POST" class="p-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input name="title" required type="text" class="w-full px-4 py-2 border rounded" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="category" class="w-full px-4 py-2 border rounded">
                                <option value="PKM">PKM</option>
                                <option value="Business Plan">Business Plan</option>
                                <option value="Riset">Riset Akademik</option>
                                <option value="Lomba IT">Lomba IT</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                            <input name="deadline" required type="date" class="w-full px-4 py-2 border rounded" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input name="location" type="text" class="w-full px-4 py-2 border rounded" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" required rows="4" class="w-full px-4 py-2 border rounded"></textarea>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kriteria (pisahkan dengan koma)</label>
                        <input name="requirements" type="text" class="w-full px-4 py-2 border rounded" />
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-secondary text-white py-2 rounded">Buat Rekrutmen</button>
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-100 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
