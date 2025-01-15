<?php

namespace App\Http\Controllers;

use App\Models\ResepObat;
use App\Models\konsultasi;
use App\Models\obat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResepObatController extends Controller
{
    public function index()
    {
        // Ambil semua resep yang statusnya belum siap
        $resep_obat = ResepObat::where('status', '!=', 'siap') // Hanya yang belum siap
                                ->with('konsultasi', 'obat')
                                ->get()
                                ->groupBy('id_konsultasi'); // Kelompokkan berdasarkan konsultasi
        
        return view('apoteker.resep_obat.index', compact('resep_obat'));
    }
    
    public function history()
    {
        // Ambil semua resep yang statusnya sudah siap
        $resep_obat = ResepObat::where('status', 'siap') // Hanya yang sudah siap
                                ->with('konsultasi', 'obat')
                                ->get()
                                ->groupBy('id_konsultasi'); // Kelompokkan berdasarkan konsultasi
        
        return view('apoteker.resep_obat.history', compact('resep_obat'));
    }
    
    public function create()
    {
        $konsultasi = konsultasi::all();
        $obat = obat::all();
        return view('apoteker.resep_obat.create', compact('konsultasi', 'obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_konsultasi' => 'required|exists:konsultasi,id_konsultasi',
            'obat' => 'required|array',
            'obat.*.id_obat' => 'required|exists:obat,id_obat',
            'obat.*.jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        foreach ($request->obat as $obat) {
            ResepObat::create([
                'id_konsultasi' => $request->id_konsultasi,
                'id_obat' => $obat['id_obat'],
                'jumlah' => $obat['jumlah'],
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep obat berhasil ditambahkan.');
    }

    public function edit($id_konsultasi)
    {
        // Ambil semua resep terkait konsultasi
        $resepGroup = ResepObat::where('id_konsultasi', $id_konsultasi)->get();
        
        if ($resepGroup->isEmpty()) {
            return redirect()->route('apoteker.resep_obat.index')->with('error', 'Resep tidak ditemukan.');
        }

        // Data tambahan untuk dropdown
        $konsultasi = Konsultasi::all(); // Semua data konsultasi
        $obat = Obat::all(); // Semua data obat

        return view('apoteker.resep_obat.edit', compact('resepGroup', 'konsultasi', 'obat', 'id_konsultasi'));
    }

    public function update(Request $request, $id_konsultasi)
    {
        $request->validate([
            'id_obat' => 'required|array|min:1', // Validasi array untuk obat
            'id_obat.*' => 'exists:obat,id_obat', // Setiap ID obat harus valid
            'jumlah' => 'required|array', // Validasi array untuk jumlah
            'jumlah.*' => 'required|integer|min:1', // Jumlah tiap obat harus valid
            'keterangan' => 'nullable|string|max:255', // Validasi keterangan opsional
            'status' => 'nullable|string|in:sedang disiapkan,siap', // Validasi status
        ]);

        // Hapus semua resep lama terkait konsultasi ini
        ResepObat::where('id_konsultasi', $id_konsultasi)->delete();

        // Tambahkan resep baru dan langsung kurangi stok obat
        foreach ($request->id_obat as $index => $id_obat) {
            $jumlah = $request->jumlah[$index];

            // Kurangi stok obat di tabel obat
            $obat = Obat::find($id_obat);
            if ($obat) {
                if ($obat->stok < $jumlah) {
                    return redirect()->back()->withErrors(['stok' => "Stok obat {$obat->nama_obat} tidak mencukupi."]);
                }

                $obat->stok -= $jumlah; // Kurangi stok langsung
                $obat->save();
            }

            // Buat resep baru
            ResepObat::create([
                'id_konsultasi' => $id_konsultasi,
                'id_obat' => $id_obat,
                'jumlah' => $jumlah,
                'keterangan' => $request->keterangan,
                'status' => $request->status ?? 'sedang disiapkan', // Set status default
            ]);
        }

        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat berhasil diperbarui dan stok telah diperbarui.');
    }

    public function destroy(ResepObat $resepObat)
    {
        $resepObat->delete();
        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat berhasil dihapus.');
    }
}

