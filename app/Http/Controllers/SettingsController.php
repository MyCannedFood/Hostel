<?php
// FILE: app/Http/Controllers/Admin/SettingsController.php
// Pastikan folder app/Http/Controllers/Admin/ sudah dibuat dulu

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'gallery');
        $data    = ['section' => $section];

        if ($section === 'gallery') {
            $query = Gallery::query();

            if ($request->filled('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $query->orderBy('column_placement')->orderBy('order_number');

            $data['photos']         = $query->paginate(10)->appends($request->except('page'));
            $data['totalPhotos']    = Gallery::count();
            $data['filterCategory'] = $request->get('category', 'all');
            $data['filterStatus']   = $request->get('status', 'all');
        }

        return view('admin.settings.settings', $data);
    }
}