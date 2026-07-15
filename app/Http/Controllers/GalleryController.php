<?php
// FILE: app/Http/Controllers/Admin/GalleryController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryPhotoRequest;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'admin_id'         => auth('admin')->id(),  // guard 'admin'
            'image_path'       => $path,
            'title'            => $request->title,
            'category'         => $request->category,
            'column_placement' => $request->column_placement,
            'order_number'     => $request->order_number,
            'status'           => $request->boolean('activate_immediately') ? 'active' : 'inactive',
            'alt_text'         => $request->alt_text,
        ]);

        return redirect()
            ->route('admin.settings', ['section' => 'gallery'])
            ->with('success', 'Foto berhasil diupload.');
    }

    public function update(UpdateGalleryPhotoRequest $request, Gallery $gallery): RedirectResponse
    {
        $data = [
            'title'            => $request->title,
            'category'         => $request->category,
            'column_placement' => $request->column_placement,
            'order_number'     => $request->order_number,
            'status'           => $request->boolean('activate_immediately') ? 'active' : 'inactive',
            'alt_text'         => $request->alt_text,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image_path);
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.settings', ['section' => 'gallery'])
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()
            ->route('admin.settings', ['section' => 'gallery'])
            ->with('success', 'Foto berhasil dihapus.');
    }
}