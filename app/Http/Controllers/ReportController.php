<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->with(['school', 'distribution'])
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }
}