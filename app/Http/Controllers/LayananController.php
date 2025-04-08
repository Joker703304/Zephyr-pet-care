<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::query();

        // Search berdasarkan nama layanan atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_layanan', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
        }

        // Sorting
        $sort = $request->get('sort', 'nama_layanan'); // Default sorting
        $direction = $request->get('direction', 'asc'); // Default direction

        // Kolom yang bisa diurutkan
        $sortable = ['nama_layanan', 'deskripsi', 'harga'];

        if (in_array($sort, $sortable)) {
            $query->orderBy($sort, $direction);
        }

        // Ambil data dengan pagination
        $layanans = $query->paginate(10)->appends($request->query());

        return view('admin.layanan.index', compact('layanans'));
    }


    // Show the form for creating a new resource
    public function create()
    {
        return view('admin.layanan.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan created successfully.');
    }

    // Display the specified resource
    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    // Show the form for editing the specified resource
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
        ]);

        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan deleted successfully.');
    }
}
