<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');  // Hanya admin yang bisa mengakses
    }

    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Cek apakah ada input pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        // Sorting berdasarkan kolom yang dipilih
        $sortColumn = $request->input('sort', 'name'); // Default sort by name
        $sortDirection = $request->input('direction', 'asc'); // Default ascending

        // Validasi agar hanya kolom tertentu yang bisa di-sort
        if (!in_array($sortColumn, ['name', 'phone'])) {
            $sortColumn = 'name';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $query->orderBy($sortColumn, $sortDirection);

        // Ambil data user dengan pagination (10 data per halaman)
        $users = $query->paginate(10)->appends([
            'search' => $request->search,
            'role' => $request->role,
            'sort' => $sortColumn,
            'direction' => $sortDirection,
        ]);

        return view('admin.users.index', compact('users', 'sortColumn', 'sortDirection'));
    }



    // Menampilkan form untuk menambah pengguna baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Mengupdate data pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:pemilik_hewan,admin,dokter,apoteker,security', // Validasi role
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,  // Update role
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


    // Menghapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:pemilik_hewan,admin,dokter,apoteker,kasir',
        ]);

        // Hapus data terkait jika user mengganti role
        if ($user->role != $request->role) {
            if ($user->pemilikHewan) {
                $user->pemilikHewan()->delete();
            }
            if ($user->dokter) {
                $user->dokter()->delete();
            }
            if ($user->apoteker) {
                $user->apoteker()->delete();
            }
            if ($user->kasir) {
                $user->kasir()->delete();
            }
            if ($user->security) {
                $user->security()->delete();
            }
        }

        // Update role user
        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Role user berhasil diperbarui.');
    }
}
