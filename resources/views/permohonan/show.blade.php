<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('permohonan.index') }}" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 shadow-sm transition">
                    ←
                </a>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    Detail Permohonan: <span class="font-mono text-blue-600">{{ $permohonan->no_pengajuan }}</span>
                </h2>
            </div>

            <span class="px-3 py-1.5 text-xs font-bold rounded-full
                {{ $permohonan->status == 'Menunggu' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                {{ $permohonan->status == 'Diproses' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                {{ $permohonan->status == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                {{ $permohonan->status == 'Ditolak' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}
            ">
                Status: {{ $permohonan->status }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-slate-500 uppercase tracking-wider mr-2">Alur Berkas:</span>

                @if($permohonan->status == 'Baru')
                    <form action="{{ route('permohonan.update', $permohonan->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Diproses">
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                            ⚡ Mulai Proses Berkas
                        </button>
                    </form>
                @elseif($permohonan->status == 'Diproses')
                    <form action="{{ route('permohonan.update', $permohonan->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Selesai">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                            ✓ Selesai
                        </button>
                    </form>
                @endif

                @if(in_array($permohonan->status, ['Baru', 'Diproses']))
                    <form action="{{ route('permohonan.update', $permohonan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK permohonan ini?')">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 text-sm font-semibold px-4 py-2 rounded-lg transition">
                            ✕ Tolak Berkas
                        </button>
                    </form>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('permohonan.edit', $permohonan->id) }}" class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                    ✏️ Edit Data
                </a>

                <form action="{{ route('permohonan.destroy', $permohonan->id) }}" method="POST" class="inline" onsubmit="return confirm('DATA YANG DIHAPUS BERSIFAT PERMANEN, Apakah Anda yakin ingin menghapus permohonan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition inline-flex items-center gap-1.5">
                        🗑 Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- CARD INFORMASI DATA PEMOHON -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-200 bg-slate-50/70">
                <h3 class="font-bold text-base text-slate-800 tracking-tight">Informasi Lengkap Permohonan</h3>
            </div>

            <div class="px-6 md:px-8 text-sm divide-y divide-slate-100">

                <!-- BARIS 1: Nama & Jenis Surat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 py-4">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap Pemohon</p>
                        <p class="text-base font-bold text-slate-800">{{ $permohonan->nama_pemohon }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis / Deskripsi Surat Izin</p>
                        <p class="text-base font-bold text-slate-800">{{ $permohonan->jenis_surat }}</p>
                    </div>
                </div>

                <!-- TAMBAHAN BARU - BARIS 2: Alamat Lengkap (Full Width) -->
                <div class="py-4">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Lengkap Lokasi / Pemohon</p>
                        <p class="text-sm font-semibold text-slate-700 leading-relaxed">
                            {{ $permohonan->alamat ?? 'Belum mengisi alamat atau data kosong' }}
                        </p>
                    </div>
                </div>

                <!-- BARIS 3: Telepon & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 py-4">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor Telepon / WA</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $permohonan->phone ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Email</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $permohonan->email ?? '-' }}</p>
                    </div>
                </div>

                <!-- BARIS 4: Nomor Surat & Tanggal Masuk -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 py-4">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor Surat Resmi Dinas</p>
                        <div class="pt-0.5">
                            <p class="text-sm font-mono font-bold text-blue-600 bg-blue-50/50 inline-block px-2.5 py-0.5 rounded border border-blue-100">
                                {{ $permohonan->no_surat ?? 'Belum Terbit (Masih Proses)' }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Masuk Pengajuan</p>
                        <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($permohonan->tgl_pengajuan)->format('d F Y') }}</p>
                    </div>
                </div>

                <!-- BARIS 5: Tanggal Proses & Tanggal Selesai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 py-4">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Mulai Diproses</p>
                        <p class="text-sm font-semibold text-slate-600">
                            {{ $permohonan->tgl_proses ? \Carbon\Carbon::parse($permohonan->tgl_proses)->format('d F Y') : '-' }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Selesai / Terbit</p>
                        <p class="text-sm font-semibold text-slate-600">
                            {{ $permohonan->tgl_selesai ? \Carbon\Carbon::parse($permohonan->tgl_selesai)->format('d F Y') : '-' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
