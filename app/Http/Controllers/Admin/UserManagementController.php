<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Tampilkan daftar semua user
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan role
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Pencarian nama / email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Hitung jumlah per role (buat badge di view)
        $roleCount = [
            'all'        => User::count(),
            'admin'      => User::where('role', 'admin')->count(),
            'editor'     => User::where('role', 'editor')->count(),
            'teologi'    => User::where('role', 'teologi')->count(),
            'linguistik' => User::where('role', 'linguistik')->count(),
            'null'       => User::whereNull('role')->orWhere('role', '')->count(),
        ];

        $title = "Manajemen Pengguna | Admin Panel - Qur'an Gorontalo";

        return view('admin.user.index', compact('users', 'roleCount', 'title'));
    }

    /**
     * Tampilkan form tambah user
     */
    public function create()
    {
        $title = "Tambah Pengguna Baru | Admin Panel";
        return view('admin.user.create', compact('title'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,editor,teologi,linguistik',
            'no_hp'    => 'nullable|string|max:20',
            'bio'      => 'nullable|string|max:500',
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'no_hp'    => $validated['no_hp'] ?? null,
            'bio'      => $validated['bio'] ?? null,
        ]);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit user
     */
    // public function edit($id)
    // {
    //     $user = User::findOrFail($id);
    //     $title = "Edit Pengguna | Admin Panel";

    //     return view('admin.user.edit', compact('user', 'title'));
    // }

    public function edit(Request $request, $id) {
        $user = User::findOrFail($id);
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $user]);
        }
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update data user (termasuk role)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|in:admin,editor,teologi,linguistik',
            'no_hp'    => 'nullable|string|max:20',
            'bio'      => 'nullable|string|max:500',
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
            'no_hp' => $validated['no_hp'] ?? null,
            'bio'   => $validated['bio'] ?? null,
        ];

        // Hanya update password kalau diisi
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Update role saja (cepat, bisa dipakai lewat AJAX atau form kecil)
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Jangan biarkan admin mengubah role dirinya sendiri menjadi non-admin
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak bisa menurunkan role diri sendiri.');
        }

        $request->validate([
            'role' => 'required|in:admin,editor,teologi,linguistik',
        ]);

        $user->update(['role' => $request->role]);

        $roleLabel = match($request->role) {
            'teologi'    => 'Validator Teologi',
            'linguistik' => 'Validator Linguistik',
            'editor'     => 'Editor',
            'admin'      => 'Administrator',
            default      => $request->role,
        };

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$roleLabel}.");
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: jangan biarkan admin hapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}