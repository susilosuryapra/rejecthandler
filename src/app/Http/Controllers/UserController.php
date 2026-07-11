<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        $roles = [
            'Admin',
            'Supervisor QC',
            'Supervisor Produksi',
            'PPIC',
            'Merchandiser',
            'Gudang',
            'Akunting',
        ];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|unique:users,user_id',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
            'role'    => 'required|string',
        ]);

        $user = User::create([
            'user_id'  => $request->user_id,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        $user->assignRole($request->role);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Membuat user baru: ' . $user->name);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function edit(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $roles = [
            'Admin',
            'Supervisor QC',
            'Supervisor Produksi',
            'PPIC',
            'Merchandiser',
            'Gudang',
            'Akunting',
        ];
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'user_id' => 'required|string|unique:users,user_id,' . $user->id,
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role'    => 'required|string',
        ]);

        $user->update([
            'user_id' => $request->user_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'role'    => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update role di Spatie
        $user->syncRoles([$request->role]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Mengupdate data user: ' . $user->name);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Menghapus user: ' . $user->name);

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
