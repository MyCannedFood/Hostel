<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller stub untuk semua halaman polosan.
 */
class PageController extends Controller
{
    public function show(Request $request, string $page)
    {
        return view('pages.stub', ['page' => $page]);
    }

    public function showAdmin(Request $request, string $page)
    {
        return view('pages.admin_stub', ['page' => $page]);
    }
}


