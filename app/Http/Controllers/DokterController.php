<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }


    public function create()
    {
        $emails = User::where('role', 'dokter')->pluck('email', 'id');
        return view('admin.dokter.create', compact('emails'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'id_user' => 'required|exists:users,id|unique:tbl_dokter,id_user',
        'spesialis' => 'nullable|string|max:50',
        'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon',
        'hari' => 'nullable|array',
        'hari.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'jam_mulai' => 'nullable|date_format:H:i',
        'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
    ]);

    // Simpan data dokter
    Dokter::create([
        'id_user' => $request->id_user, // Simpan ID pengguna
        'spesialis' => $request->spesialis,
        'no_telepon' => $request->no_telepon,
        'hari' => json_encode($request->hari), // Simpan hari sebagai JSON
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
    ]);

    return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
}



    public function edit(Dokter $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {

        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'spesialis' => 'nullable|string|max:50',
            'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon,' . $dokter->id, // Ignore the current doctor
            'hari' => 'nullable|array',
            'hari.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
        ]);

        // Update nama dokter di tabel users
        $dokter->user->update([
            'name' => $request->name,
        ]);

        // Update data dokter di tabel tbl_dokter
        $dokter->update([
            'spesialis' => $request->spesialis,
            'no_telepon' => $request->no_telepon,
            'hari' => $request->has('hari') ? json_encode($request->hari) : null,  // Encode days as JSON
            // Update jam_mulai hanya jika ada input dari user
            'jam_mulai' => $request->has('jam_mulai') ? $request->jam_mulai : $dokter->jam_mulai,  // Update jam_mulai hanya jika ada perubahan
            'jam_selesai' => $request->has('jam_selesai') ? $request->jam_selesai : $dokter->jam_selesai,  // Update jam_selesai hanya jika ada perubahan
        ]);

        // Redirect setelah berhasil update
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter updated successfully.');
    }




    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter deleted successfully.');
    }
}
