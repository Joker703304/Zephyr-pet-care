<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\konsultasi;
use App\Models\Antrian;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class kasirController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:kasir');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $kasir = Kasir::where('id_user', Auth::id())->first();
    $today = Carbon::today();

    if (!$kasir) {
        return redirect()->route('kasir.createProfile')->with('warning', 'Mohon isi data diri terlebih dahulu.');
    }

    // Jumlah daftar ulang hari ini (Menunggu)
    $konsultasiCount = Konsultasi::whereDate('tanggal_konsultasi', $today)
        ->where('status', 'Menunggu')
        ->count();

    // Jumlah antrian hari ini
    $antrianCount = Antrian::whereDate('created_at', $today)->count();

    // Jumlah transaksi belum dibayar hari ini
    $counttransaksi = Transaksi::whereDate('created_at', $today)
        ->where('status_pembayaran', 'Belum Dibayar')
        ->count();

    // Total transaksi hari ini
    $totalTransaksi = Transaksi::whereDate('created_at', $today)->count();

    // 🔄 Ganti dari 7 hari jadi 30 hari terakhir
    $startDate = now()->subDays(29); // 30 hari termasuk hari ini
    $endDate = now();

    $dates = [];
    $konsultasiCounts = [];
    $konsultasiSelesaiCounts = [];
    $sudahDibayarCounts = [];
    $belumDibayarCounts = [];

    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        $formattedDate = $date->format('d M'); // Format agar label lebih rapi, contoh: 05 Apr
        $dates[] = $formattedDate;

        $konsultasiCounts[] = Konsultasi::whereDate('tanggal_konsultasi', $date)
            ->where('status', 'Menunggu')
            ->count();

        $konsultasiSelesaiCounts[] = Konsultasi::whereDate('tanggal_konsultasi', $date)
            ->where('status', 'Selesai')
            ->count();

        $belumDibayarCounts[] = Transaksi::whereDate('created_at', $date)
            ->where('status_pembayaran', 'Belum Dibayar')
            ->count();

        $sudahDibayarCounts[] = Transaksi::whereDate('created_at', $date)
            ->where('status_pembayaran', 'Sudah Dibayar')
            ->count();
    }

    return view('kasir.dashboard', compact(
        'konsultasiCount',
        'antrianCount',
        'counttransaksi',
        'totalTransaksi',
        'dates',
        'konsultasiCounts',
        'konsultasiSelesaiCounts',
        'sudahDibayarCounts',
        'belumDibayarCounts'
    ));
}

    public function antrian()
    {
        $today = Carbon::today();

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
    
        return view('kasir.antrian', compact('antrianDipanggil', 'antrianMenunggu'));
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



    public function selesai(Request $request, Antrian $antrian)
    {
        $antrian->update(['status' => 'Selesai']);

        return redirect()->back()->with('success', 'Pasien telah dipanggil.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function profile()
    {
        // Cek role pengguna yang sedang login
        if (auth()->user()->role == 'kasir') {
            // Ambil data pemilik hewan terkait dengan user yang login
            $userId = auth()->user()->id;

            // Ambil data pemilik hewan berdasarkan user_id
            $data = Kasir::with('user')
                ->where('id_user', $userId)
                ->get();

            // Tampilkan view untuk pemilik hewan
            return view('kasir.profile', compact('data'));
        }
    }

    public function createProfile()
    {
        $user = auth()->user();
        return view('kasir.createProfile', compact('user'));
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'phone' => 'required|string|max:13|exists:users,phone',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Create a new doctor profile
        Kasir::create([
            'id_user' => Auth::id(),
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is created
        return redirect()->route('kasir.dashboard')->with('success', 'Profile anda berhasil dibuat.');
    }

    public function editProfile()
    {
        // Get the doctor's profile
        $kasir = Kasir::where('id_user', Auth::id())->first();

        // Return the profile edit view with the doctor's current data
        return view('kasir.editProfile', compact('kasir'));
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',  // Menambahkan validasi untuk name
            'no_telepon' => 'required|string|max:20|unique:kasir,no_telepon,' . Auth::id() . ',id_user',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Temukan dokter berdasarkan id_user (auth)
        $apoteker = Kasir::where('id_user', Auth::id())->first();

        // Update nama pengguna
        $apoteker->user->update([
            'name' => $validated['name'],
        ]);

        // Update data dokter
        $apoteker->update([
            'no_telepon' => $validated['no_telepon'],
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is updated
        return redirect()->route('kasir.profile')->with('success', 'Profile anda berhasil di perbarui.');
    }

    public function listTransaksi()
    {
        $today = Carbon::today();
        $transaksi = Transaksi::orderBy('created_at', 'asc')->where('status_pembayaran', 'Belum Dibayar')->get();
        
        // $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])->whereDate('created_at', $today)
        // ->where('dokter_id', $dokter->id) // Filter by dokter ID
        // ->whereDate('tanggal_konsultasi', $today) // Filter by today's date
        // ->where('status', 'Diterima') // Filter by status 'Diterima'
        // ->get();

        return view('kasir.transaksi.index', compact('transaksi'));
    }

    public function riwayatTransaksi()
    {
        $today = Carbon::today();
        $transaksi = Transaksi::orderBy('created_at', 'asc')->where('status_pembayaran', 'Sudah Dibayar')->get();
        
        // $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])->whereDate('created_at', $today)
        // ->where('dokter_id', $dokter->id) // Filter by dokter ID
        // ->whereDate('tanggal_konsultasi', $today) // Filter by today's date
        // ->where('status', 'Diterima') // Filter by status 'Diterima'
        // ->get();

        return view('kasir.transaksi.riwayat.index', compact('transaksi'));
    }

    public function bayar(Request $request, $id)
{
    $transaksi = Transaksi::findOrFail($id);

    $request->validate([
        'jumlah_bayar' => 'required|numeric|min:' . $transaksi->total_harga,
    ]);

    $jumlahBayar = $request->jumlah_bayar;
    $kembalian = $jumlahBayar - $transaksi->total_harga;

    // Update the transaction with payment details
    $transaksi->update([
        'jumlah_bayar' => $jumlahBayar,
        'kembalian' => $kembalian,
        'status_pembayaran' => 'Sudah Dibayar',
    ]);

    // Update related konsultasi status to "Selesai"
    $konsultasi = $transaksi->konsultasi;
    if ($konsultasi) {
        $konsultasi->update([
            'status' => 'Selesai',
        ]);
    }

     // Update status antrian menjadi "Selesai"
     $konsultasi = $transaksi->konsultasi;
    if ($konsultasi) {
        $konsultasi->update([
            'status' => 'Selesai',
        ]);

        // Perbaikan: Mengambil id_konsultasi dengan benar
        $id_konsultasi = $konsultasi->id_konsultasi;

        // Update status antrian menjadi "Selesai"
        $antrian = Antrian::where('konsultasi_id', $id_konsultasi)->first();
        if ($antrian) {
            $antrian->update([
                'status' => 'Selesai',
            ]);
        }
    }

    // Kirim notifikasi ke pemilik hewan
    $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
    $gateway = '6288229193849';

    $pemilik = $konsultasi->hewan->pemilik;
    if ($pemilik) {
        $nomorPemilik = $pemilik->user->phone;
        $messagePemilik = "Halo {$pemilik->user->name},\n"
            . "Pembayaran untuk hewan Anda ({$konsultasi->hewan->nama_hewan}) telah berhasil.\n"
            . "💰 Total Dibayar: Rp" . number_format($jumlahBayar, 0, ',', '.') . "\n"
            . "💵 Kembalian: Rp" . number_format($kembalian, 0, ',', '.') . "\n"
            . "Status: Selesai. Terima kasih telah menggunakan layanan kami! 😊";

        Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
            'gateway' => $gateway,
            'number' => $nomorPemilik,
            'type' => 'text',
            'message' => $messagePemilik,
        ]);
    }



    return redirect()->route('kasir.transaksi.rincian', $transaksi->id_transaksi)
        ->with('success', 'Pembayaran berhasil dilakukan. Status konsultasi telah diperbarui menjadi Selesai.')
        ->with('jumlah_bayar', $jumlahBayar)
        ->with('kembalian', $kembalian)
        ->with('autoPrint', true);  // Trigger auto print only when payment is completed
}




    public function rincian($id)
    {
        $transaksi = Transaksi::with([
            'konsultasi.layanan',
            'konsultasi.resepObat.obat',
        ])->findOrFail($id);

        return view('kasir.transaksi.rincian', compact('transaksi'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
    
        $kasir = kasir::findOrFail($id); // Pastikan model sesuai
        $kasir->user->update([
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
