<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use App\Models\User;
use Illuminate\Http\Request;

class ApotekerAdminController extends Controller
{
    public function index()
    {
        $apotekers = Apoteker::with('user')->get();
        return view('admin.apoteker.index', compact('apotekers'));
    }

    public function create()
    {
        $users = User::where('role', 'pemilik_hewan')
            ->whereDoesntHave('pemilikHewan') // Pastikan user belum jadi apoteker
            ->get();
        return view('admin.apoteker.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'no_telepon' => 'required|string|max:20|unique:apotekers,no_telepon',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'required|string|max:255',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->update(['role' => 'apoteker']);

        Apoteker::create([
            'id_user' => $user->id,
            'no_telepon' => $request->no_telepon,
            'jenkel' => $request->jenkel,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.apoteker.index')->with('success', 'Apoteker added successfully.');
    }

    public function edit(Apoteker $apoteker)
    {
        return view('admin.apoteker.edit', compact('apoteker'));
    }

    public function update(Request $request, Apoteker $apoteker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20|unique:apotekers,no_telepon,' . $apoteker->id,
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'required|string|max:255',
        ]);

        $apoteker->user->update(['name' => $request->name]);
        $apoteker->update([
            'no_telepon' => $request->no_telepon,
            'jenkel' => $request->jenkel,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.apoteker.index')->with('success', 'Apoteker updated successfully.');
    }

    public function destroy(Apoteker $apoteker)
    {
        $apoteker->delete();
        return redirect()->route('admin.apoteker.index')->with('success', 'Apoteker deleted successfully.');
    }
}
