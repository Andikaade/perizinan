<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-6">

        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Periksa Berkas Permohonan</h2>
                <nav class="flex mt-2 text-sm text-gray-500">
                    <a href="{{ route('verifikasi.index') }}" class="hover:text-gray-700">Verifikasi</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900 font-medium">Detail {{ $permohonan->no_pengajuan }}</span>
                </nav>
            </div>
            <a href="{{ route('verifikasi.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                ← Kembali ke Antrean
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- ================= KOLOM KIRI: DATA PEMOHON & AKSI (4 Kolom) ================= -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                <!-- Card 1: Profil Pemohon -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h5 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span>👤</span> Informasi Pemohon
                    </h5>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Nomor Pengajuan</label>
                            <span class="text-lg font-extrabold text-gray-900">{{ $permohonan->no_pengajuan }}</span>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Nama Lengkap</label>
                            <span class="text-sm font-semibold text-gray-800">{{ $permohonan->nama_pemohon }}</span>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Kontak & Email</label>
                            <span class="block text-sm text-gray-700">📞 {{ $permohonan->phone }}</span>
                            <span class="block text-sm text-gray-700">✉️ {{ $permohonan->email }}</span>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Jenis Perizinan</label>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-100 text-amber-800 mt-1">
                                {{ $permohonan->jenis_surat }}
                            </span>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Alamat Objek / Lokasi</label>
                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg leading-relaxed border border-gray-100">
                                {{ $permohonan->alamat }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Lembar Keputusan Verifikator -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h5 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span>⚖️</span> Keputusan Pemeriksaan
                    </h5>

                    <form action="{{ route('verifikasi.update', $permohonan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Status Verifikasi</label>
                            <div class="space-y-3">
                                <!-- Pilihan Setuju -->
                                <label class="relative flex items-start p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors focus-within:ring-2 focus-within:ring-green-500" for="status_disetujui">
                                    <div class="flex items-center h-5">
                                        <input type="radio" class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500" name="status" id="status_disetujui" value="Proses" required>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900">Setujui Berkas</span>
                                        <span class="block text-xs text-gray-500">Berkas sudah lengkap dan sesuai kriteria (Status: Proses)</span>
                                    </div>
                                </label>

                                <!-- Pilihan Tolak (Tetap Ditolak) -->
                                <label class="relative flex items-start p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors focus-within:ring-2 focus-within:ring-red-500" for="status_ditolak">
                                    <div class="flex items-center h-5">
                                        <input type="radio" class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500" name="status" id="status_ditolak" value="Ditolak" required>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900">Tolak / Butuh Revisi</span>
                                        <span class="block text-xs text-gray-500">Terdapat berkas buram atau salah upload</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Kolom Catatan (Tampil dinamis dengan Javascript) -->
                        <div id="kolom_catatan" class="mb-6 hidden">
                            <label for="catatan" class="block text-sm font-semibold text-red-700 mb-2">Alasan Penolakan / Catatan Revisi</label>
                            <textarea class="w-full rounded-lg border border-red-300 p-3 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 placeholder-gray-400" id="catatan" name="catatan" rows="3" placeholder="Contoh: KTP buram, harap upload file PDF yang jernih."></textarea>
                        </div>

                        <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            💾 Simpan Keputusan
                        </button>
                    </form>
                </div>
            </div>

            <!-- ================= KOLOM KANAN: DOKUMEN PREVIEW (7-8 Kolom) ================= -->
            <div class="lg:col-span-7 xl:col-span-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-full" style="min-height: 700px;">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 mb-6 gap-4">
                        <h5 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span>📄</span> Pratinjau Dokumen
                        </h5>
                        <!-- Tab Ganti Berkas -->
                        <div class="inline-flex rounded-lg border border-gray-200 p-1 bg-gray-50">
                            @foreach($permohonan->dokumens as $index => $dokumen)
                                <button type="button"
                                        class="tab-btn px-3 py-1.5 text-xs font-semibold rounded-md text-gray-600 hover:text-gray-900 transition-colors {{ $index === 0 ? 'bg-white shadow-sm text-gray-900 font-bold' : '' }}"
                                        onclick="previewFile('{{ asset('storage/' . $dokumen->file_path) }}', '{{ pathinfo($dokumen->file_path, PATHINFO_EXTENSION) }}', this)">
                                    Berkas {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex-grow bg-gray-50 rounded-xl p-4 border border-gray-100 flex flex-col items-center justify-center">
                        <!-- Penampung File Preview -->
                        <div id="preview-container" class="w-full h-full flex items-center justify-center min-h-[550px] bg-white rounded-lg border border-gray-200 overflow-auto">
                            @if($permohonan->dokumens->isNotEmpty())
                                @php
                                    $firstDoc = $permohonan->dokumens->first();
                                    $ext = pathinfo($firstDoc->file_path, PATHINFO_EXTENSION);
                                    $fileUrl = asset('storage/' . $firstDoc->file_path);
                                @endphp

                                <!-- PDF Viewer -->
                                <iframe id="pdf-viewer" src="{{ $fileUrl }}" class="w-full h-full border-0 {{ strtolower($ext) === 'pdf' ? '' : 'hidden' }}"></iframe>

                                <!-- Image Viewer -->
                                <img id="img-viewer" src="{{ $fileUrl }}" class="max-h-[600px] w-auto object-contain {{ strtolower($ext) === 'pdf' ? 'hidden' : '' }}" alt="Pratinjau Berkas">
                            @else
                                <div class="text-center text-gray-400 py-12">
                                    <span class="text-4xl block mb-2">📂</span>
                                    <span class="text-sm">Tidak ada dokumen pendukung yang dilampirkan.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= JAVASCRIPT INTERAKSI PREVIEW & FORM ================= -->
    <script>
        // Fungsi 1: Ganti Tampilan File di iframe/img
        function previewFile(url, ext, button) {
            const pdfViewer = document.getElementById('pdf-viewer');
            const imgViewer = document.getElementById('img-viewer');

            // Ganti status aktif pada tombol tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'shadow-sm', 'text-gray-900', 'font-bold');
                btn.classList.add('text-gray-600');
            });
            button.classList.add('bg-white', 'shadow-sm', 'text-gray-900', 'font-bold');
            button.classList.remove('text-gray-600');

            if (ext.toLowerCase() === 'pdf') {
                pdfViewer.src = url;
                pdfViewer.classList.remove('hidden');
                imgViewer.classList.add('hidden');
            } else {
                imgViewer.src = url;
                imgViewer.classList.remove('hidden');
                pdfViewer.classList.add('hidden');
            }
        }

        // Fungsi 2: Munculkan kolom catatan jika memilih 'Ditolak'
        document.addEventListener('DOMContentLoaded', function () {
            const statusSetujui = document.getElementById('status_disetujui');
            const statusDitolak = document.getElementById('status_ditolak');
            const kolomCatatan = document.getElementById('kolom_catatan');
            const catatanInput = document.getElementById('catatan');

            function toggleCatatan() {
                if (statusDitolak.checked) {
                    kolomCatatan.classList.remove('hidden');
                    catatanInput.setAttribute('required', 'required');
                } else {
                    kolomCatatan.classList.add('hidden');
                    catatanInput.removeAttribute('required');
                    catatanInput.value = '';
                }
            }

            statusSetujui.addEventListener('change', toggleCatatan);
            statusDitolak.addEventListener('change', toggleCatatan);
        });
    </script>
</x-app-layout>
