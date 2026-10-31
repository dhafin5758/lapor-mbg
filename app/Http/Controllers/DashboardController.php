<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'pelapor') {
            return view('dashboard.pelapor');
        }

        if ($role === 'pemantau') {
            return view('dashboard.pemantau');
        }

        if ($role === 'koordinator') {
            return view('dashboard.koordinator');
        }

    }
}