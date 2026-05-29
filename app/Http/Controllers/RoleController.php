<?php
// FILE: app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /* ──────────────────────────────────────
       STORE — Tambah role baru
    ────────────────────────────────────── */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::create([
            'name'        => $request->role_name,
            'description' => $request->role_description,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()
            ->route('admin.settings', ['section' => 'staff', 'tab' => 'access-info'])
            ->with('success', 'Role berhasil ditambahkan.');
    }

    /* ──────────────────────────────────────
       UPDATE — Edit role
    ────────────────────────────────────── */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update([
            'name'        => $request->role_name,
            'description' => $request->role_description,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()
            ->route('admin.settings', ['section' => 'staff', 'tab' => 'access-info'])
            ->with('success', 'Role berhasil diperbarui.');
    }

    /* ──────────────────────────────────────
       DESTROY — Hapus role
    ────────────────────────────────────── */
    public function destroy(Role $role): RedirectResponse
    {
        // Lepas semua admin yang pakai role ini sebelum dihapus
        $role->admins()->update(['role_id' => null]);
        $role->delete();

        return redirect()
            ->route('admin.settings', ['section' => 'staff', 'tab' => 'access-info'])
            ->with('success', 'Role berhasil dihapus.');
    }
}