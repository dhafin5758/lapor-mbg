<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
 public function index(Request $request)
{
    $query = Report::with(['user', 'school'])
        ->whereIn('status', ['diajukan', 'perlu_dilengkapi']);

    if ($request->filled('search')) {
        $query->where('judul', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $reports = $query->latest()
        ->paginate(10)
        ->withQueryString();
    foreach ($reports as $report) {
    $report->related_school_reports = Report::with('school')
        ->where('school_id', $report->school_id)
        ->where('id', '!=', $report->id)
        ->latest()
        ->limit(5)
        ->get();

    if ($report->distribution_id) {
        $report->related_distribution_reports = Report::with('school')
            ->where('distribution_id', $report->distribution_id)
            ->where('id', '!=', $report->id)
            ->latest()
            ->limit(5)
            ->get();
    } else {
        $report->related_distribution_reports = collect();
    }
}
    $categories = Report::whereIn('status', ['diajukan', 'perlu_dilengkapi'])
        ->select('kategori')
        ->distinct()
        ->orderBy('kategori')
        ->pluck('kategori');

    return view('reviews.index', compact('reports', 'categories'));
}

    public function store(Request $request, $id)
{
    $validated = $request->validate([
        'hasil' => 'required|in:perlu_dilengkapi,siap_ditindaklanjuti',
        'catatan' => 'required_if:hasil,perlu_dilengkapi|nullable|string|max:2000',
    ]);

    $report = Report::findOrFail($id);

    // Pastikan laporan memang masih menunggu review.
    if (!in_array($report->status, ['diajukan', 'perlu_dilengkapi'])) {
        return back()->with('error', 'Laporan ini tidak dapat direview.');
    }

    DB::transaction(function () use ($report, $validated) {
        ReportReview::create([
            'report_id' => $report->id,
            'reviewer_id' => Auth::id(),
            'catatan' => $validated['catatan'] ?? null,
            'perlu_tindak_lanjut' =>
                $validated['hasil'] === 'siap_ditindaklanjuti',
        ]);

        $report->update([
            'status' => $validated['hasil'],
        ]);
    });

    return redirect()
        ->route('reviews.index')
        ->with('success', 'Hasil review berhasil disimpan.');
}
}
