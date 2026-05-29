<?php
// FILE: app/Http/Controllers/StaffController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /* ──────────────────────────────────────
       STORE — Tambah akun staff baru
    ────────────────────────────────────── */
    public function store(StoreAdminRequest $request): RedirectResponse
    {
        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
            'status'   => 'active',
        ]);

        return redirect()
            ->route('admin.settings', ['section' => 'staff', 'tab' => 'staff-list'])
            ->with('success', 'Akun staff berhasil ditambahkan.');
    }

    /* ──────────────────────────────────────
       UPDATE — Edit akun staff
    ────────────────────────────────────── */
    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        // Ganti password hanya kalau diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()
            ->route('admin.settings', ['section' => 'staff', 'tab' => 'staff-list'])
            ->with('success', 'Akun staff berhasil diperbarui.');
    }

    /* ──────────────────────────────────────
       DESTROY — Hapus akun staff
    ────────────────────────────────────── */
    public function destroy(Admin $admin): RedirectResponse
    {
        // Cegah admin menghapus akun dirinya sendiri
        if ($admin->id === auth('admin')->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang aktif.');
        }

        $admin->delete();

        return redirect()
            ->route('admin.settings', ['section' => 'staff', 'tab' => 'staff-list'])
            ->with('success', 'Akun staff berhasil dihapus.');
    }
}