<?php
// FILE: app/Http/Controllers/PublicGalleryController.php

namespace App\Http\Controllers;

use App\Models\Gallery;

class PublicGalleryController extends Controller
{
    public function index()
    {
        // Hanya tampilkan foto dengan status active
        // Diurutkan by order_number per kolom
        $leftPhotos = Gallery::active()
            ->leftColumn()
            ->orderBy('order_number')
            ->get();

        $rightPhotos = Gallery::active()
            ->rightColumn()
            ->orderBy('order_number')
            ->get();

        return view('pages.gallery', compact('leftPhotos', 'rightPhotos'));
    }
}