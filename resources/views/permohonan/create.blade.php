<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Tambah Permohonan Perizinan') }}
            </h2>
            <a href="{{ route('permohonan.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                ← Kembali ke Daftar Permohonan
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-3xl mx-auto">
        <form action="{{ route('permohonan.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- No Pengajuan (Otomatis) -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">No. Pengajuan / Antrian</label>
                    <input type="text" name="no_pengajuan" value="{{ $automaticNoPengajuan }}" readonly
                        class="w-full rounded-lg border-slate-200 bg-slate-50 text-slate-600 font-medium focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Jenis / Deskripsi Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Jenis / Deskripsi Surat</label>
                    <input type="text" name="jenis_surat" required placeholder="Contoh: Izin Pemanfaatan Ruang (IPR)"
                        class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Nama Pemohon -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Pemohon</label>
                    <input type="text" name="nama_pemohon" required placeholder="Nama Lengkap Pemohon"
                        class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <!-- Alamat -->
                <div class="md:col-span-2 space-y-1">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Lengkap Lokasi / Pemohon</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="Contoh: Jl. Raya Tata Ruang No. 12, Kecamatan Kebon Jeruk, Kota Administrasi Jakarta Barat"></textarea>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="phone" placeholder="08xxxxxxxxxx"
                        class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" placeholder="nama@email.com"
                        class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- No Surat Internal Dinas (Opsional di Awal) -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">No. Surat Resmi (Opsional)</label>
                    <input type="text" name="no_surat" placeholder="Diisi jika surat sudah terbit"
                        class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Status Pengajuan -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Status Awal</label>
                    <select name="status" required class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="Menunggu" selected>Menunggu (Berkas Masuk)</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>

                <!-- Tanggal Pengajuan -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Tanggal Pengajuan</label>
                    <input type="date" name="tgl_pengajuan" value="{{ date('Y-m-d') }}" required
                        class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Tanggal Proses & Selesai (Kosongkan dulu saat input awal) -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Tanggal Mulai Proses (Opsional)</label>
                    <input type="date" name="tgl_proses" class="w-full rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <button type="reset" class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200">
                    Reset
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                    Simpan Data Permohonan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
