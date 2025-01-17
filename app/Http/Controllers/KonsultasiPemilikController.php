<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\DokterJadwal;
use App\Models\hewan;
use App\Models\konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KonsultasiPemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $konsultasi = Konsultasi::whereHas('hewan', function ($query) {
        $query->where('id_pemilik', auth()->user()->pemilikHewan->id_pemilik);
    })->with(['hewan', 'dokter.user'])->get();

    return view('pemilik-hewan.konsultasi.index', compact('konsultasi'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data dokter yang memiliki jadwal
        $dokterJadwal = DokterJadwal::with('dokter') // Memuat relasi dokter
            ->whereDate('tanggal', '>=', now()) // Ambil jadwal mulai hari ini
            ->get();

        // Ambil data hewan milik pengguna yang sedang login
        $hewan = Hewan::where('id_pemilik', auth()->user()->pemilikHewan->id_pemilik) // Filter hewan milik pengguna login
    ->whereDoesntHave('konsultasi', function ($query) {
        $query->where('status', '!=', 'Selesai')
              ->where('status', '!=', 'Dibatalkan');
    })
    ->get();
        
        return view('pemilik-hewan.konsultasi.create', compact('hewan', 'dokterJadwal'));
    }

    public function cancel($id)
{
    // Cari konsultasi berdasarkan ID
    $konsultasi = Konsultasi::findOrFail($id);

    // Pastikan konsultasi masih dalam status 'Menunggu'
    if ($konsultasi->status !== 'Menunggu') {
        return redirect()->back()->with('error', 'Konsultasi tidak dapat dibatalkan.');
    }

    // Ubah status menjadi 'Dibatalkan'
    $konsultasi->status = 'Dibatalkan';
    $konsultasi->save();

    // Kembalikan slot konsultasi dokter
    $jadwal = DokterJadwal::where('id_dokter', $konsultasi->dokter_id)
        ->where('tanggal', $konsultasi->tanggal_konsultasi)
        ->first();

    if ($jadwal) {
        $jadwal->maksimal_konsultasi += 1; // Tambahkan slot
        $jadwal->save();
    }

    return redirect()->route('pemilik-hewan.konsultasi_pemilik.index')->with('success', 'Konsultasi berhasil dibatalkan.');
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'id_hewan' => 'required|exists:hewan,id_hewan',
        'keluhan' => 'required|string',
        'tanggal_konsultasi' => 'required|date',
        'dokter_id' => 'required|exists:dokter_jadwal,id_dokter'//[
        //     'required',
        //     function ($attribute, $value, $fail) use ($request) {
        //         $jadwal = DokterJadwal::where('id_dokter', $value)
        //             ->where('tanggal', $request->tanggal_konsultasi)
        //             ->first();

        //         // Check if the doctor is available and has available consultations
        //         if (!$jadwal || $jadwal->maksimal_konsultasi <= Konsultasi::where('dokter_id', $value)
        //             ->where('tanggal_konsultasi', $request->tanggal_konsultasi)
        //             ->count()) {
        //             $fail('Dokter tidak tersedia atau kuota sudah penuh.');
        //         }
        //     }
        // ],
    ]);

    // Create a new consultation
    $konsultasi = new Konsultasi();
    $konsultasi->no_antrian = 'ANTRI-' . strtoupper(Str::random(6));
    $konsultasi->id_hewan = $request->id_hewan;
    $konsultasi->keluhan = $request->keluhan;
    $konsultasi->tanggal_konsultasi = $request->tanggal_konsultasi;
    $konsultasi->dokter_id = $request->dokter_id;
    $konsultasi->status = 'Menunggu';
    $konsultasi->save();

    // Decrease the available consultation slots
    $jadwal = DokterJadwal::where('id_dokter', $request->dokter_id)
        ->where('tanggal', $request->tanggal_konsultasi)
        ->first();
    
    if ($jadwal) {
        $jadwal->maksimal_konsultasi -= 1; // Decrease the slot
        $jadwal->save();
    }

    // Redirect to the consultation index page with a success message
    return redirect()->route('pemilik-hewan.konsultasi_pemilik.index')->with('success', 'Konsultasi berhasil diajukan.');
}


    public function getDokterByDate(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $dokterJadwal = DokterJadwal::with('dokter')
            ->where('tanggal', $tanggal)
            ->get();

        return response()->json($dokterJadwal);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
