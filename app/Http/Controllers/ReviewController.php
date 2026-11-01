<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    // Menampilkan daftar laporan untuk diperiksa
 public function index(Request $request)
{
    $query = Report::with(['user', 'school'])
        ->whereIn('status', ['diajukan', 'perlu_dilengkapi']);

    // Pencarian berdasarkan judul laporan
    if ($request->filled('search')) {
        $query->where('judul', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $reports = $query->latest()
        ->paginate(10)
        ->withQueryString();

    // Mengambil kategori yang tersedia untuk laporan yang dapat direview
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
