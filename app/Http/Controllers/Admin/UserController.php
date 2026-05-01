<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\Division;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('division')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.users.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'role' => ['required', 'in:user,wakil_admin,super_admin'],
        ]);

        // Wakil admin only creates user
        if (auth()->user()->role === 'wakil_admin' && $request->role !== 'user') {
            return back()->with('error', 'Wakil Admin hanya bisa membuat User Biasa');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'division_id' => $request->division_id,
            'role' => $request->role,
        ]);

        UserHistory::create([
            'actor_id' => auth()->id(),
            'action' => 'Tambah',
            'target_name' => $user->name,
            'description' => 'Menambahkan user ' . $user->name . ' sebagai ' . $user->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat');
    }

    public function edit(User $user)
    {
        // Check hierarchy
        if (auth()->user()->role === 'wakil_admin' && in_array($user->role, ['super_admin', 'wakil_admin', 'admin'])) {
            return back()->with('error', 'Anda tidak memiliki hak untuk mengedit user ini');
        }

        $divisions = Division::all();
        return view('admin.users.edit', compact('user', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',id,'.$user->id],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'role' => ['required', 'in:user,wakil_admin,super_admin'],
        ];

        // Wakil admin check
        if (auth()->user()->role === 'wakil_admin') {
            if (in_array($user->role, ['super_admin', 'wakil_admin', 'admin'])) {
                return back()->with('error', 'Anda tidak berhak mengubah user ini');
            }
            if ($request->role !== 'user') {
                return back()->with('error', 'Wakil Admin hanya bisa menetapkan role User Biasa');
            }
        }

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->division_id = $request->division_id;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        UserHistory::create([
            'actor_id' => auth()->id(),
            'action' => 'Edit',
            'target_name' => $user->name,
            'description' => 'Mengubah data user ' . $user->name,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        if (auth()->user()->role === 'wakil_admin' && in_array($user->role, ['super_admin', 'wakil_admin', 'admin'])) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menghapus user ini');
        }

        $targetName = $user->name;
        $user->delete();

        UserHistory::create([
            'actor_id' => auth()->id(),
            'action' => 'Hapus',
            'target_name' => $targetName,
            'description' => 'Menghapus user ' . $targetName,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus');
    }
}
