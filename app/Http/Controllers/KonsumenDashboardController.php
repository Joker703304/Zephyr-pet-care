<?php

namespace App\Http\Controllers;

use App\Models\hewan;
use App\Models\konsultasi;
use App\Models\pemilik_hewan;
use App\Models\ResepObat;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KonsumenDashboardController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:pemilik_hewan');
    }

    public function index()
    {
        // Get the logged-in user
        $user = auth()->user();

        // Check if the user exists in the pemilik_hewan table
        $pemilikHewan = pemilik_hewan::where('email', $user->email)->first();

        if (!$pemilikHewan) {
            return redirect()->route('pemilik-hewan.pemilik_hewan.create')->with('warning', 'Silakan lengkapi data pemilik hewan terlebih dahulu.');
        }

        // Count animals owned by the logged-in user
        $animalsCount = $pemilikHewan->hewan()->count();

        // Count consultations for animals owned by the logged-in user with status 'menunggu'
        $consultationsCount = Konsultasi::whereIn('id_hewan', function ($query) use ($pemilikHewan) {
            $query->select('id_hewan')
                ->from('hewan')
                ->where('id_pemilik', $pemilikHewan->id_pemilik);
        })->where('status', 'menunggu')->count();

        $transaksiCount = Transaksi::whereHas('konsultasi', function ($query) use ($pemilikHewan) {
            $query->whereIn('id_hewan', function ($subQuery) use ($pemilikHewan) {
                $subQuery->select('id_hewan')
                    ->from('hewan')
                    ->where('id_pemilik', $pemilikHewan->id_pemilik);
            });
        })
        ->distinct('id_konsultasi')
        ->count('id_konsultasi');

        // Count prescriptions for the logged-in user's animals
        $prescriptions = ResepObat::whereHas('konsultasi', function ($query) use ($pemilikHewan) {
            $query->whereIn('id_hewan', function ($subQuery) use ($pemilikHewan) {
                $subQuery->select('id_hewan')
                    ->from('hewan')
                    ->where('id_pemilik', $pemilikHewan->id_pemilik);
            });
        })
        ->distinct('id_konsultasi')
        ->count('id_konsultasi');

        // Return the dashboard view
        return view('pemilik-hewan.dashboard', compact('pemilikHewan', 'animalsCount', 'consultationsCount', 'prescriptions', 'transaksiCount'));
    }

    public function manageHewan()
    {
        // Ambil semua pengguna untuk dikelola
        $hewan = hewan::all();
        return view('pemilik-hewan.hewan', compact('hewan'));
    }

    public function listTransaksi()
{
    // Ambil data pemilik berdasarkan email user yang login
    $pemilik = pemilik_hewan::where('email', Auth::user()->email)->first();

    // Jika pemilik tidak ditemukan
    if (!$pemilik) {
        return redirect()->back()->withErrors(['error' => 'Pemilik Hewan tidak ditemukan.']);
    }

    // Ambil transaksi berdasarkan id_pemilik melalui relasi ke hewan -> konsultasi -> transaksi
    $transaksi = Transaksi::with(['konsultasi.hewan.pemilik'])
        ->whereHas('konsultasi.hewan', function ($query) use ($pemilik) {
            $query->where('id_pemilik', $pemilik->id_pemilik);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('pemilik-hewan.riwayat_transaksi.index', compact('transaksi'));
}

public function rincian($id)
    {
        $transaksi = Transaksi::with([
            'konsultasi.layanan',
            'konsultasi.resepObat.obat',
        ])->findOrFail($id);

        return view('kasir.transaksi.rincian', compact('transaksi'));
    }

    


}
