<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Ringkasan Data Perizinan') }}
        </h2>
    </x-slot> --}}

    <div class="mb-6 bg-slate-900 text-white rounded-xl shadow-md p-5 flex items-center gap-4 border-l-4 border-blue-500">
        <div class="p-2 bg-slate-800 rounded-lg text-blue-400 text-lg flex items-center justify-center shrink-0">
            👋
        </div>
        <div>
            <h4 class="font-bold text-sm sm:text-base">Selamat datang kembali, {{ Auth::user()->name }}!</h4>
            <p class="text-xs sm:text-sm text-slate-400 mt-0.5">Sistem berjalan normal. Silakan periksa pembaharuan permohonan masuk hari ini untuk memulai verifikasi berkas.</p>
        </div>
    </div>
    <div>
        <h2 class="font-bold text-xl text-slate-800 leading-tight mt-2 mb-2">
            {{ __('Ringkasan Data Perizinan') }}
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between border-t-4 border-t-blue-600">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Permohonan Baru</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">12</p>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline mt-4 block">Lihat data masuk →</a>
            </div>
            <div class="p-3.5 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between border-t-4 border-t-amber-500">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Diproses</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">5</p>
                <a href="#" class="text-xs font-medium text-amber-600 hover:underline mt-4 block">Pantau verifikasi →</a>
            </div>
            <div class="p-3.5 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between border-t-4 border-t-emerald-500">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Diterbitkan</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">142</p>
                <a href="#" class="text-xs font-medium text-emerald-600 hover:underline mt-4 block">Buka arsip surat izin →</a>
            </div>
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

    </div>
</x-app-layout>
