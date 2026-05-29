<?php
// FILE: app/Http/Controllers/SettingsController.php  (ganti seluruh isi)

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Gallery;
use App\Models\Role;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'gallery');
        $data    = ['section' => $section];

        /* ── Gallery ── */
        if ($section === 'gallery') {
            $query = Gallery::query();

            if ($request->filled('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }
            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $data['photos']         = $query->orderBy('column_placement')
                                            ->orderBy('order_number')
                                            ->paginate(10)
                                            ->appends($request->except('page'));
            $data['totalPhotos']    = Gallery::count();
            $data['filterCategory'] = $request->get('category', 'all');
            $data['filterStatus']   = $request->get('status', 'all');
        }

        /* ── Staff & Access Rights ── */
        if ($section === 'staff') {
            $tab = $request->get('tab', 'staff-list');

            if ($tab === 'staff-list') {
                $query = Admin::with('role');

                // Search by name
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }

                $data['staffList'] = $query->orderBy('name')->get();
            }

            if ($tab === 'access-info') {
                $data['roles'] = Role::withCount('admins')->orderBy('name')->get();
            }

            // Roles untuk dropdown di modal Add/Edit Account
            $data['roleOptions'] = Role::orderBy('name')->get();
        }

        return view('admin.settings.settings', $data);
    }
}