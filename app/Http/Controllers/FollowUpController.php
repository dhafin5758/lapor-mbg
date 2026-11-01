<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowUpController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'school', 'distribution', 'followUps'])
            ->where('status', 'siap_ditindaklanjuti')
            ->latest()
            ->paginate(10);

        return view('followups.index', compact('reports'));
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'pihak_tujuan' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $report = Report::findOrFail($id);

        if ($report->status !== 'siap_ditindaklanjuti') {
            return back()->with('error', 'Laporan belum siap ditindaklanjuti.');
        }

        FollowUp::create([
            'report_id' => $report->id,
            'coordinator_id' => Auth::id(),
            'pihak_tujuan' => $validated['pihak_tujuan'],
            'catatan' => $validated['catatan'] ?? null,
            'tanggal_diteruskan' => now(),
        ]);

        return redirect()
            ->route('followups.index')
            ->with('success', 'Tindak lanjut berhasil dicatat.');
    }
}
