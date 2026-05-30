<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::where('status', 'Active')->get();
        return view('pages.experience', compact('experiences'));
    }
}