<aside class="w-64 bg-slate-950 text-slate-300 min-h-screen shadow-xl flex flex-col hidden md:flex border-r border-slate-800">

    <div class="p-4 border-b border-slate-800 bg-slate-950 flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Dinas" class="h-10 w-auto object-contain">
        <div class="flex flex-col">
            <span class="font-bold text-white tracking-wider text-sm leading-tight">SI-PERIZINAN</span>
            <span class="text-[10px] text-slate-400 font-medium tracking-wide">TATA RUANG</span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-1.5 text-sm overflow-y-auto">
        <p class="px-2 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Dashboard & Ringkasan</p>

        {{-- <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-medium transition duration-200"> --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
            <span>Main Dashboard</span>
        </a>

        <p class="px-2 pt-4 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Manajemen Berkas</p>

        <a href="{{ route('permohonan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition duration-200 {{ request()->routeIs('permohonan.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Semua Permohonan</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-900 hover:text-white transition duration-200 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <span>Verifikasi / Validasi</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-900 hover:text-white transition duration-200 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            <span>Penerbitan Surat Izin</span>
        </a>

        <p class="px-2 pt-4 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utilitas & Laporan</p>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-900 hover:text-white transition duration-200 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Laporan Statistik</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-900 hover:text-white transition duration-200 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span>Manajemen Petugas</span>
        </a>

        <p class="px-2 pt-4 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Sistem</p>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-900 hover:text-white transition duration-200 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span>Profil Akun</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-950">
        <div class="truncate">
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Operator Aktif</p>
            <p class="text-sm font-semibold text-white truncate mt-0.5">{{ Auth::user()->name }}</p>
        </div>
    </div>
</aside>
