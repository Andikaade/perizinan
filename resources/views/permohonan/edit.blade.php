<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Edit Data Permohonan Perizinan</h2>
            <a href="{{ route('permohonan.show', $permohonan->id) }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800 flex items-center gap-1">
                ← Kembali ke Detail
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-7xl">
            <form action="{{ route('permohonan.updateData', $permohonan->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">No. Pengajuan / Antrian</label>
                        <input type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed" value="{{ $permohonan->no_pengajuan }}" disabled>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis / Deskripsi Surat</label>
                        <input type="text" name="jenis_surat" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" value="{{ old('jenis_surat', $permohonan->jenis_surat) }}" required>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pemohon</label>
                        <input type="text" name="nama_pemohon" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" value="{{ old('nama_pemohon', $permohonan->nama_pemohon) }}" required>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Lengkap Lokasi / Pemohon</label>
                        <textarea name="alamat" rows="3" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 @error('alamat') border-rose-500 @enderror" placeholder="Masukkan alamat lengkap lokasi perizinan" required>{{ old('alamat', $permohonan->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">No. Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" value="{{ old('phone', $permohonan->phone) }}">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" value="{{ old('email', $permohonan->email) }}">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('permohonan.show', $permohonan->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
