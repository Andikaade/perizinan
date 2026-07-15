
<x-app-layout>

<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Antrean Verifikasi & Validasi</h1>
            <p class="text-sm text-slate-500">Khusus memproses berkas permohonan yang masuk secara online.</p>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-2.5 text-right">
            <span class="text-xs font-semibold text-amber-700 block uppercase tracking-wider">Butuh Tindakan</span>
            <span class="text-xl font-bold text-amber-900">{{ $antrean->total() }} Berkas</span>
        </div>
    </div>

    <!-- Tanda Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Antrean -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">No. Pengajuan</th>
                        <th class="py-4 px-6">Nama Pemohon</th>
                        <th class="py-4 px-6">Jenis Surat</th>
                        <th class="py-4 px-6">Jumlah Berkas</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                    @forelse($antrean as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $item->no_pengajuan }}</td>
                            <td class="py-4 px-6 font-medium">{{ $item->nama_pemohon }}</td>
                            <td class="py-4 px-6 text-slate-500">{{ $item->jenis_surat }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-800">
                                    📁 {{ $item->dokumens->count() }} Dokumen
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($item->status === 'Menunggu')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                        Menunggu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-100">
                                        Proses
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('verifikasi.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold shadow-sm shadow-indigo-100 transition">
                                    🔍 Periksa Berkas
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="text-3xl">🎉</span>
                                    <p class="font-medium text-slate-500">Semua antrean bersih!</p>
                                    <p class="text-xs text-slate-400">Tidak ada permohonan online yang perlu divalidasi saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($antrean->hasPages())
            <div class="p-4 border-t border-slate-50 bg-slate-50/50">
                {{ $antrean->links() }}
            </div>
        @endif
    </div>
</div>

</x-app-layout>
