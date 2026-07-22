<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- HEADER HALAMAN -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Daftar Semua Permohonan</h2>
            <a href="{{ route('permohonan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                + Tambah Permohonan Baru
            </a>
        </div>

        <!-- CARD UTAMA TABEL -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <!-- BAGIAN ATAS TABEL: TOTAL DATA & FORM PENCARIAN -->
            <div class="p-5 border-b border-slate-200 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 bg-slate-50/50">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Data Tersimpan: {{ $totalData }}</p>
                </div>

                <!-- FORM PENCARIAN & DROPDOWN STATUS (Diperlebar max-w agar muat filter tanggal) -->
                <form action="{{ route('permohonan.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2 max-w-5xl w-full xl:justify-end">

                    <!-- INPUT FILTER RENTANG TANGGAL BARU -->
                    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-lg px-2 py-1.5 shadow-sm w-full lg:w-auto">
                        <span class="text-xs font-bold text-slate-400 uppercase px-1">Periode</span>
                        <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="border-0 p-0 text-sm text-slate-700 focus:ring-0 focus:outline-none">
                        <span class="text-slate-300">-</span>
                        <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="border-0 p-0 text-sm text-slate-700 focus:ring-0 focus:outline-none">
                    </div>

                    <!-- FITUR DROPDOWN STATUS -->
                    <div class="w-full lg:w-44">
                        <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-blue-500 text-slate-700 font-medium shadow-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu ({{ $counts['Menunggu'] }})</option>
                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>⚡ Proses ({{ $counts['Proses'] }})</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>✅ Selesai ({{ $counts['Selesai'] }})</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak ({{ $counts['Ditolak'] }})</option>
                        </select>
                    </div>

                    <!-- INPUT TEKS PENCARIAN -->
                    <div class="relative w-full lg:w-56">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 placeholder-slate-400 shadow-sm"
                               placeholder="Cari No. Pengajuan / Nama...">
                        <!-- Ikon Kaca Pembesar -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI & TOMBOL EKSPOR (Menyesuaikan deteksi request filter tanggal) -->
                    <div class="flex items-center gap-2 w-full lg:w-auto">
                        @if(request('search') || request('status') || request('tgl_mulai') || request('tgl_selesai'))
                            <a href="{{ route('permohonan.index') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-600 text-xs font-semibold rounded-lg transition text-center whitespace-nowrap">
                                Reset Filter
                            </a>
                        @endif

                        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-lg shadow-sm transition w-full lg:w-auto">
                            Cari
                        </button>

                        <!-- TOMBOL EKSPOR EXCEL AUTOMATIS TERFILTER -->
                        <a href="{{ route('permohonan.export', request()->query()) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition w-full lg:w-auto whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Ekspor Excel
                        </a>
                    </div>
                </form>
            </div>

            <!-- TABEL DATA -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/70 text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-6">No. Pengajuan</th>
                            <th class="py-3 px-6">Nama Pemohon</th>
                            <th class="py-3 px-6">Jenis Surat</th>
                            <th class="py-3 px-6">Tgl Masuk</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($permohonans as $p)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">{{ $p->no_pengajuan }}</td>
                            <td class="py-4 px-6 font-semibold">{{ $p->nama_pemohon }}</td>
                            <td class="py-4 px-6 text-slate-500">{{ $p->jenis_surat }}</td>
                            <td class="py-4 px-6">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d/m/Y') }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $p->status == 'Menunggu' ? 'bg-blue-50 text-blue-600' : '' }}
                                    {{ $p->status == 'Proses' ? 'bg-amber-50 text-amber-600' : '' }}
                                    {{ $p->status == 'Selesai' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                    {{ $p->status == 'Ditolak' ? 'bg-rose-50 text-rose-600' : '' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('permohonan.show', $p->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                                    👁 Kelola Berkas
                                </a>
                                @if($p->status === 'Selesai' && $p->file_surat)
                                    <a href="{{ asset('storage/surat_izin/' . $p->file_surat) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                                        📄 Lihat Surat
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                Tidak ada data permohonan yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- LINK PAGINATION -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/30">
                {{ $permohonans->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
