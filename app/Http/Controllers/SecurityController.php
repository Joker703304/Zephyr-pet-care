<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Security;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function profile()
    {
        // Cek role pengguna yang sedang login
        if (auth()->user()->role == 'security') {
            // Ambil data security hewan terkait dengan user yang login
            $userId = auth()->user()->id;

            // Ambil data security hewan berdasarkan user_id
            $data = Security::with('user')
                ->where('id_user', $userId)
                ->get();

            // Tampilkan view untuk security hewan
            return view('security.profile', compact('data'));
        }
    }

    public function createProfile()
    {
        $user = auth()->user();
        return view('security.createProfile', compact('user'));
    }

    public function storeProfile(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'nama' => 'required|string|max:50',
        'phone' => 'required|string|max:13|exists:users,phone',
        'jenkel' => 'required|in:pria,wanita',
        'alamat' => 'nullable|string',
    ]);

    // Create a new security profile
    Security::create([
        'id_user' => Auth::id(),
        'nama' => $validated['nama'],
        'jenkel' => $validated['jenkel'],
        'alamat' => $validated['alamat'],
    ]);

    // Redirect to the dashboard after the profile is created
    return redirect()->route('security.dashboard')->with('success', 'Profile anda berhasil dibuat.');
}


    public function editProfile()
    {
        // Get the doctor's profile
        $security = Security::where('id_user', Auth::id())->first();

        // Return the profile edit view with the doctor's current data
        return view('security.editProfile', compact('security'));
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',  // Menambahkan validasi untuk name
            'no_telepon' => 'required|string|max:20|unique:security,no_telepon,' . Auth::id() . ',id_user',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Temukan dokter berdasarkan id_user (auth)
        $security = Security::where('id_user', Auth::id())->first();

        // Update nama pengguna
        $security->user->update([
            'name' => $validated['name'],
        ]);

        // Update data dokter
        $security->update([
            'no_telepon' => $validated['no_telepon'],
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is updated
        return redirect()->route('security.profile')->with('success', 'Profile anda berhasil di perbarui.');
    }

    public function index()
    {
        $security = Security::where('id_user', Auth::id())->first();
        $today = Carbon::today();

        if (!$security) {
            // If no doctor profile exists, redirect to the profile creation page
            return redirect()->route('security.createProfile')->with('warning', 'Mohon Isi data diri terlebih dahulu.');
        }

        // Antrian dengan status "Dipanggil"
        $antrianDipanggil = Antrian::with(['konsultasi.dokter.user'])
            ->whereDate('created_at', $today)
            ->where('status', 'Dipanggil')
            ->get();
    
        // Antrian dengan status "Menunggu"
        $antrianMenunggu = Antrian::with(['konsultasi.dokter.user'])
            ->whereDate('created_at', $today)
            ->where('status', 'Menunggu')
            ->get();
    
        return view('security.dashboard', compact('antrianDipanggil', 'antrianMenunggu'));
    }

    public function getAntrian()
{
    $today = Carbon::today();

    // Ambil antrian dengan status "Dipanggil"
    $antrianDipanggil = Antrian::with(['konsultasi.dokter.user'])
        ->whereDate('created_at', $today)
        ->where('status', 'Dipanggil')
        ->get();

    // Ambil antrian dengan status "Menunggu"
    $antrianMenunggu = Antrian::with(['konsultasi.dokter.user'])
        ->whereDate('created_at', $today)
        ->where('status', 'Menunggu')
        ->get();

    // Kirim data dalam bentuk JSON
    return response()->json([
        'antrianDipanggil' => $antrianDipanggil,
        'antrianMenunggu' => $antrianMenunggu,
    ]);
}
public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
    
        $security = Security::findOrFail($id); // Pastikan model sesuai
        $security->user->update([
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
