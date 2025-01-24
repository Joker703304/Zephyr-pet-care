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
        $kasir = kasir::where('id_user', Auth::id())->first();
        $today = Carbon::today();

        if (!$kasir) {
            // If no doctor profile exists, redirect to the profile creation page
            return redirect()->route('kasir.createProfile')->with('warning', 'Mohon Isi data diri terlebih dahulu.');
        }

        $konsultasiCount = konsultasi::whereDate('tanggal_konsultasi', Carbon::today())->where('status', 'Menunggu')->count();
        // Menampilkan tampilan dashboard pemilik hewan

        $antrianCount = Antrian::whereDate('created_at', $today)->count();

        $counttransaksi = Transaksi::whereDate('created_at', $today)
        ->where('status_pembayaran', 'Belum Dibayar')
        ->count();


        return view('kasir.dashboard', compact('konsultasiCount', 'antrianCount', 'counttransaksi'));;
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
        return view('kasir.createProfile');
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'no_telepon' => 'required|string|max:20|unique:kasir',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Create a new doctor profile
        Kasir::create([
            'id_user' => Auth::id(),
            'no_telepon' => $validated['no_telepon'],
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
