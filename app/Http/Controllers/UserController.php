<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Cek berdasarkan role, bukan email
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }

        // Tampilkan semua user kecuali user yang sedang login (opsional)
        $users = User::where('id', '!=', auth()->id())->latest()->get();
        return view('data-entry.users.index', compact('users'));
    }

    public function create()
    {
        // PERBAIKAN: Cek berdasarkan role
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }
        return view('data-entry.users.create');
    }

    public function store(Request $request)
    {
        // PERBAIKAN: Cek berdasarkan role
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user', // PASTIKAN validasi role
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // JANGAN LUPA ini!
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function show(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }
        return view('data-entry.users.show', compact('user'));
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        // Opsional: Mencegah edit admin utama jika perlu
        if ($user->email === 'admin@bpbd.com' && auth()->user()->email !== 'admin@bpbd.com') {
            abort(403, 'Tidak dapat mengedit administrator utama');
        }
        
        return view('data-entry.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        // Opsional: Mencegah update admin utama
        if ($user->email === 'admin@bpbd.com' && auth()->user()->email !== 'admin@bpbd.com') {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat mengedit administrator utama');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user', // TAMBAH validasi role
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // JANGAN LUPA update role
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        // Cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        // Cegah hapus admin utama
        if ($user->email === 'admin@bpbd.com') {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus administrator utama');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}