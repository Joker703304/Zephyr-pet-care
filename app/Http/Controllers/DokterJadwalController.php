<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use App\Models\DokterJadwal;

class DokterJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the logged-in user has a doctor profile
        $dokter = Dokter::where('id_user', Auth::id())->first();

        if (!$dokter) {
            // If no doctor profile exists, redirect to the profile creation page
            return redirect()->route('dokter.createProfile')->with('warning', 'Mohon isi data diri terlebih dahulu.');
        }

        // Retrieve schedules
        $schedules = DokterJadwal::where('id_dokter', $dokter->id)->get();
        $datesWithSchedules = $schedules->pluck('tanggal')->toArray(); // Ambil semua tanggal

        return view('dokter.jadwal', compact('schedules', 'datesWithSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    


    public function storeOrUpdate(Request $request)
    {
        // Check if the schedule ID is present (for update)
        if ($request->has('schedule_id') && $request->schedule_id) {
            // Update existing schedule
            $schedule = DokterJadwal::find($request->schedule_id);
            $schedule->status = $request->status;
            // Only save 'maksimal_konsultasi' if status is 'Praktik'
            if ($request->status !== 'Tidak Praktik') {
                $schedule->maksimal_konsultasi = $request->maksimal_konsultasi;
            } else {
                $schedule->maksimal_konsultasi = null; // Ensure it's null for 'Tidak Praktik'
            }
            $schedule->save();
        } else {
            // Create a new schedule
            DokterJadwal::create([
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'maksimal_konsultasi' => $request->status !== 'Tidak Praktik' ? $request->maksimal_konsultasi : null,
                'id_dokter' => auth()->user()->dokter->id // Assuming the doctor is logged in
            ]);
        }
    
        // Redirect back to the dashboard or calendar page
        return back()->with('success', 'Jadwal berhasil disimpan!');
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'tanggal' => 'required|date|after_or_equal:today', // Prevent past dates
        'maksimal_konsultasi' => 'integer|min:1',
        'status' => 'required|in:Praktik,Tidak Praktik',
    ]);

    $user = auth()->user();
    $dokter = $user->dokter;

    if (!$dokter) {
        return response()->json(['message' => 'Data dokter tidak ditemukan.'], 404);
    }

    // Check if the schedule already exists
    $scheduleId = $request->input('schedule_id');
    $existingSchedule = null;

    if ($scheduleId) {
        $existingSchedule = DokterJadwal::find($scheduleId);
        if (!$existingSchedule || $existingSchedule->id_dokter != $dokter->id) {
            return back()->withErrors(['tanggal' => 'Jadwal untuk tanggal ini tidak ditemukan.']);
        }
    }

    // Check if the date already has a schedule
    $existingScheduleByDate = DokterJadwal::where('id_dokter', $dokter->id)
        ->where('tanggal', $validated['tanggal'])
        ->first();

    if ($existingScheduleByDate && !$scheduleId) {
        return back()->withErrors(['tanggal' => 'Jadwal untuk tanggal ini sudah ada.']);
    }

    if ($existingSchedule) {
        // Update existing schedule
        $existingSchedule->update([
            'tanggal' => $validated['tanggal'],
            'maksimal_konsultasi' => $validated['maksimal_konsultasi'],
            'status' => $validated['status'],
        ]);
    } else {
        // Create new schedule
        DokterJadwal::create([
            'id_dokter' => $dokter->id,
            'tanggal' => $validated['tanggal'],
            'maksimal_konsultasi' => $validated['maksimal_konsultasi'],
            'status' => $validated['status'],
        ]);
    }

    return back()->with('success', 'Jadwal berhasil disimpan!');
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
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'tanggal' => 'required|date|after_or_equal:today',
        'maksimal_konsultasi' => 'integer|min:1',
        'status' => 'required|in:Praktik,Tidak Praktik',
    ]);

    // Find the schedule
    $schedule = DokterJadwal::findOrFail($id);

    // Update the schedule
    $schedule->update([
        'tanggal' => $validated['tanggal'],
        'maksimal_konsultasi' => $validated['maksimal_konsultasi'],
        'status' => $validated['status'],
    ]);

    return back()->with('success', 'Jadwal berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
