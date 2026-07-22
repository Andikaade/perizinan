<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Exports\PermohonanExport;
use Maatwebsite\Excel\Facades\Excel;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil keyword pencarian dari input bernama 'search'
        $search = $request->input('search');
        $status = $request->input('status');
        $tgl_mulai = $request->input('tgl_mulai');
        $tgl_selesai = $request->input('tgl_selesai');

        // 2. Buat query dasar
        $query = Permohonan::query();

        // 3. Jika ada keyword pencarian, filter berdasarkan No Pengajuan atau Nama Pemohon
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_pengajuan', 'LIKE', "%{$search}%")
                ->orWhere('nama_pemohon', 'LIKE', "%{$search}%");
            });
        }
        // 4. Filter berdasarkan status dari Tab yang aktif (jika ada status yang dipilih)
        if ($status) {
            $query->where('status', $status);
        }

        // 5. Filter Rentang Tanggal (Fitur Baru)
        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tgl_pengajuan', [$tgl_mulai, $tgl_selesai]);
        }

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_pengajuan', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        // 5. Urutkan dari yang terbaru, lalu gunakan paginate (10 data per halaman)
        $permohonans = $query->latest()->paginate(10)->withQueryString();

        // 6. Hitung total seluruh data untuk informasi di dashboard
        $totalData = Permohonan::count();

        $counts = [
            'Semua'    => Permohonan::count(),
            'Menunggu' => Permohonan::where('status', 'Menunggu')->count(),
            'Proses'   => Permohonan::where('status', 'Proses')->count(),
            'Selesai'  => Permohonan::where('status', 'Selesai')->count(),
            'Ditolak'  => Permohonan::where('status', 'Ditolak')->count(),
        ];

        return view('permohonan.index', compact('permohonans', 'totalData' ,'counts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dateCode = date('Ymd');
        $latest = Permohonan::where('no_pengajuan', 'LIKE', "PRZ-{$dateCode}-%")->latest()->first();

        if ($latest) {
            $lastNumber = (int) substr($latest->no_pengajuan, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $automaticNoPengajuan = "PRZ-{$dateCode}-{$nextNumber}";

        return view('permohonan.create', compact('automaticNoPengajuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_pengajuan'  => 'required|unique:permohonans,no_pengajuan',
            'nama_pemohon'  => 'required|string|max:255',
            'alamat'        => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'jenis_surat'   => 'required|string|max:255',
            'tgl_pengajuan' => 'required|date',
            'status'        => 'required|in:Menunggu,Proses,Selesai,Ditolak',
        ]);

        Permohonan::create($request->all());

        return redirect()->route('permohonan.index')->with('success', 'Data permohonan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Cari data permohonan, jika tidak ada langsung munculkan error 404
        $permohonan = Permohonan::findOrFail($id);

        return view('permohonan.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('permohonan.edit', compact('permohonan'));
    }
    public function updateData(Request $request, $id)
    {
        // Validasi inputan form
        $validated = $request->validate([
            'jenis_surat'  => 'required|string|max:255',
            'nama_pemohon' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
        ]);

        // Cari dan update datanya
        $permohonan = Permohonan::findOrFail($id);
        $permohonan->update($validated);

        // Kembalikan ke halaman detail dengan pesan sukses
        return redirect()->route('permohonan.show', $id)->with('success', 'Data permohonan dan alamat berhasil diperbarui.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai,Ditolak'
        ]);

        // 2. Cari data permohonan berdasarkan ID, jika tidak ada akan memunculkan error 404 (Bukan Null Error)
        $permohonan = Permohonan::findOrFail($id);

        // 3. Update status permohonan
        $permohonan->status = $request->status;

        // Otomatis isi tanggal proses jika status diubah ke 'Diproses'
        if ($request->status == 'Proses') {
            $permohonan->tgl_proses = now();
        }

        // Otomatis isi tanggal selesai jika status diubah ke 'Selesai'
        if ($request->status == 'Selesai') {
            $permohonan->tgl_selesai = now();
        }

        $permohonan->save();

        return redirect()->back()->with('success', 'Status permohonan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data permohonan berdasarkan ID
        $permohonan = Permohonan::findOrFail($id);

        // Hapus data tersebut
        $permohonan->delete();

        // Redirect kembali ke halaman index dengan session flash message
        return redirect()->route('permohonan.index')
                     ->with('success', 'Data permohonan berhasil dipindahkan ke tempat sampah.');
    }
    public function exportExcel(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $tgl_mulai = $request->input('tgl_mulai');
        $tgl_selesai = $request->input('tgl_selesai');

        $query = Permohonan::query();

        // Logika filternya disamakan persis dengan fungsi index agar prinsip "Export What You See" bekerja
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_pengajuan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pemohon', 'LIKE', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tgl_pengajuan', [$tgl_mulai, $tgl_selesai]);
        }

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_pengajuan', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        // Proses download langsung ke komputer dengan nama file: laporan-permohonan.xlsx
        return Excel::download(new PermohonanExport($query), 'laporan-permohonan.xlsx');
    }
}
