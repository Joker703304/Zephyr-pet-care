<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\hewan;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\pemilik_hewan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

use App\Exports\TransaksiExport;
use PHPExcel;
use PHPExcel_IOFactory;




class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin'); // Pastikan hanya admin yang bisa akses
    }

    /**
     * Tampilkan halaman dashboard admin.
     *
     */
    public function index()
{
    $today = now()->toDateString();
    $currentMonth = now()->format('Y-m');

    // Cari antrian berikutnya
    $nextQueue = Konsultasi::whereDate('tanggal_konsultasi', $today)
        ->whereIn('status', ['Menunggu', 'Sedang Diproses'])
        ->orderBy('no_antrian')
        ->first();

    // Statistik utama
    $usersCount = User::count();
    $medicationsCount = Obat::count();
    $ownersCount = pemilik_hewan::count();
    $doctorsCount = Dokter::count();
    $animalsCount = Hewan::count();
    $consultationsCount = Konsultasi::count();

    // Total pemasukan bulan ini
    $totalThisMonth = Transaksi::where('status_pembayaran', 'Sudah Dibayar')
        ->where('created_at', 'like', "$currentMonth%")
        ->sum('total_harga');

    // Total pemasukan keseluruhan
    $totalEarnings = Transaksi::where('status_pembayaran', 'Sudah Dibayar')->sum('total_harga');

    // Ambil data pemasukan per bulan
    $monthlyEarnings = Transaksi::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, SUM(total_harga) as total')
        ->where('status_pembayaran', 'Sudah Dibayar')
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->get();

    // Pisahkan label (bulan) dan data pemasukan
    $monthlyLabels = $monthlyEarnings->pluck('bulan')->toArray();
    $monthlyEarnings = $monthlyEarnings->pluck('total')->toArray();

    return view('admin.dashboard', compact(
        'usersCount',
        'ownersCount',
        'medicationsCount',
        'doctorsCount',
        'animalsCount',
        'consultationsCount',
        'nextQueue',
        'totalThisMonth',
        'totalEarnings', // DITAMBAHKAN untuk total pemasukan keseluruhan
        'monthlyLabels',
        'monthlyEarnings',
    ));
}


    // Menampilkan form untuk mengedit role pengguna
    public function editRole($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-role', compact('user')); // Menampilkan form edit role
    }

    // Memperbarui role pengguna
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input role
        $validated = $request->validate([
            'role' => 'required|in:admin,dokter,apoteker,pemilik_hewan', // Gantilah sesuai role yang ada
        ]);

        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.verify-users')->with('status', 'Role pengguna telah berhasil diperbarui.');
    }

    // Tambahkan fungsi lain untuk mengelola fitur admin, misalnya:
    public function manageUsers()
    {
        // Ambil semua pengguna untuk dikelola
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function manageObat()
    {
        // Ambil semua pengguna untuk dikelola
        $obats = Obat::all();
        return view('admin.obat', compact('obats'));
    }

    public function managePemilik()
    {
        // Ambil semua pengguna untuk dikelola
        $data = pemilik_hewan::all();
        return view('admin.pemilik_hewan', compact('data'));
    }

    public function manageDokter()
    {
        // Ambil semua pengguna untuk dikelola
        $dokters = Dokter::all();
        return view('admin.Dokter', compact('dokters'));
    }

    public function manageHewan()
    {
        // Ambil semua pengguna untuk dikelola
        $hewan = hewan::all();
        return view('admin.hewan', compact('hewan'));
    }

    public function manageKonsultasi()
    {
        // Ambil semua pengguna untuk dikelola
        $konsultasi = konsultasi::all();
        return view('admin.konsultasi', compact('konsultasi'));
    }


public function laporan(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun ?? now()->format('Y');
    $mode = $request->mode ?? 'bulan';

    $query = Transaksi::with(['konsultasi.hewan.pemilik.user'])
        ->where('status_pembayaran', 'Sudah Dibayar');

    if ($mode === 'bulan' && $bulan) {
        $start = Carbon::parse($bulan . '-01')->startOfMonth();
        $end = Carbon::parse($bulan . '-01')->endOfMonth();
        $query->whereBetween('created_at', [$start, $end]);
        $transaksi = $query->orderBy('created_at')->get();

        return view('admin.laporan.kasir', compact('transaksi', 'bulan', 'tahun', 'mode'));
    } else {
        // Mode tahun
        $start = Carbon::parse($tahun . '-01-01')->startOfYear();
        $end = Carbon::parse($tahun . '-12-31')->endOfYear();
        $query->whereBetween('created_at', [$start, $end]);

        // Ambil transaksi, kelompokkan berdasarkan bulan (01-12)
        $rawRekap = $query->get()->groupBy(function ($item) {
            return $item->created_at->format('m'); // Ambil angka bulan (01–12)
        })->map(function ($group) {
            return $group->sum('total_harga');
        });

        // Buat array berisi 12 bulan, isi 0 jika tidak ada data
        $rekapTahun = collect();
        for ($i = 1; $i <= 12; $i++) {
            $bulanStr = str_pad($i, 2, '0', STR_PAD_LEFT); // '01', '02', ..., '12'
            $rekapTahun[$bulanStr] = $rawRekap->get($bulanStr, 0);
        }

        $totalTahun = $rekapTahun->sum();

        return view('admin.laporan.kasir', [
            'rekapTahun' => $rekapTahun,
            'totalTahun' => $totalTahun,
            'bulan' => null,
            'tahun' => $tahun,
            'mode' => 'tahun',
            'transaksi' => collect(),
        ]);
    }
}

public function exportLaporan(Request $request)
{
    $mode = $request->mode ?? 'bulan';
    $tahun = $request->tahun ?? now()->format('Y');
    $bulan = $request->bulan ?? now()->format('Y-m');

    $filename = 'laporan_' . $mode . '_' . now()->format('Ymd_His') . '.xlsx';

    return Excel::download(new TransaksiExport($mode, $bulan, $tahun), $filename);
}



}
