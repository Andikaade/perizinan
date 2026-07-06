<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- HEADER HALAMAN (Sudah Ada) -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Daftar Semua Permohonan</h2>
            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                + Tambah Permohonan Baru
            </a>
        </div>

        <!-- CARD UTAMA TABEL -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <!-- BAGIAN ATAS TABEL: TOTAL DATA & FORM PENCARIAN -->
            <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/50">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Data Tersimpan: {{ $totalData }}</p>
                </div>

                <!-- FORM PENCARIAN -->
                <form action="{{ route('permohonan.index') }}" method="GET" class="flex items-center gap-2 max-w-sm w-full">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 placeholder-slate-400"
                               placeholder="Cari No. Pengajuan / Nama...">
                        <!-- Ikon Kaca Pembesar -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('permohonan.index') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-600 text-xs font-semibold rounded-lg transition">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Cari
                    </button>
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
                                <!-- Badge Status Kamu -->
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $p->status == 'Menunggu' ? 'bg-blue-50 text-blue-600' : '' }}
                                    {{ $p->status == 'Diproses' ? 'bg-amber-50 text-amber-600' : '' }}
                                    {{ $p->status == 'Selesai' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                    {{ $p->status == 'Ditolak' ? 'bg-rose-50 text-rose-600' : '' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('permohonan.show', $p->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                                    👁 Kelola Berkas
                                </a>
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
