<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ReportController extends Controller

{

public function index(Request $request)
{
    $query = Report::where('user_id', Auth::id())
        ->with(['school', 'distribution']);

    // Pencarian berdasarkan judul
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
        ->paginate(5)
        ->withQueryString();

    $categories = Report::where('user_id', Auth::id())
        ->select('kategori')
        ->distinct()
        ->orderBy('kategori')
        ->pluck('kategori');

    return view('reports.index', compact('reports', 'categories'));
}

    public function create()
{
    $schools = School::orderBy('nama_sekolah')->get();

    return view('reports.create', compact('schools'));
}

    public function getDistributions(School $school)
{
    return response()->json(
        $school->distributions()
            ->orderBy('tanggal_penyaluran', 'desc')
            ->get(['id', 'tanggal_penyaluran', 'menu'])
    );
}


public function store(Request $request)
{
    $validated = $request->validate([
        'school_id' => ['required', 'exists:schools,id'],

        'distribution_id' => [
            'nullable',
            Rule::exists('distributions', 'id')
                ->where('school_id', $request->school_id),
        ],

        'judul' => ['required', 'string', 'max:255'],
        'kategori' => ['required', 'string', 'max:100'],
        'deskripsi' => ['required', 'string'],

        'evidence' => [
            'nullable',
            'file',
            'mimes:jpg,jpeg,png,pdf',
            'max:2048',
        ],
    ]);

    $evidencePath = null;

    if ($request->hasFile('evidence')) {
        $evidencePath = $request->file('evidence')
            ->store('evidence', 'public');
    }

    Report::create([
        'user_id' => Auth::id(),
        'school_id' => $validated['school_id'],
        'distribution_id' => $validated['distribution_id'] ?? null,
        'judul' => $validated['judul'],
        'kategori' => $validated['kategori'],
        'deskripsi' => $validated['deskripsi'],
        'status' => 'diajukan',
        'evidence_path' => $evidencePath,
    ]);

    return redirect()
        ->route('reports.index')
        ->with('success', 'Laporan berhasil dikirim.');
}
    public function show($id)
{
    $report = Report::where('user_id', Auth::id())
        ->with(['school', 'distribution'])
        ->findOrFail($id);

    return view('reports.show', compact('report'));
}


public function edit($id)
{
    $report = Report::where('user_id', Auth::id())
        ->findOrFail($id);

    if (!in_array($report->status, ['diajukan', 'perlu_dilengkapi'])) {
        return redirect()
            ->route('reports.show', $report->id)
            ->with('error', 'Laporan tidak dapat diedit karena sudah diproses.');
    }

    $schools = School::orderBy('nama_sekolah')->get();

    return view('reports.edit', compact('report', 'schools'));
}



public function update(Request $request, $id)
{
    $report = Report::where('user_id', Auth::id())
        ->findOrFail($id);

    if (!in_array($report->status, ['diajukan', 'perlu_dilengkapi'])) {
        return redirect()
            ->route('reports.show', $report->id)
            ->with('error', 'Laporan tidak dapat diedit karena sudah diproses.');
    }

    $validated = $request->validate([
        'school_id' => ['required', 'exists:schools,id'],

        'distribution_id' => [
            'nullable',
            Rule::exists('distributions', 'id')
                ->where('school_id', $request->school_id),
        ],

        'judul' => ['required', 'string', 'max:255'],
        'kategori' => ['required', 'string', 'max:100'],
        'deskripsi' => ['required', 'string'],

        'evidence' => [
            'nullable',
            'file',
            'mimes:jpg,jpeg,png,pdf',
            'max:2048',
        ],
    ]);

    // Siapkan data bukti lama
    $evidencePath = $report->evidence_path;

    // Jika pengguna mengunggah bukti baru
    if ($request->hasFile('evidence')) {
        $newEvidencePath = $request->file('evidence')
            ->store('evidence', 'public');

        // Hapus bukti lama setelah file baru berhasil disimpan
        if ($newEvidencePath) {
            if ($report->evidence_path) {
                \Illuminate\Support\Facades\Storage::disk('public')
                    ->delete($report->evidence_path);
            }

            $evidencePath = $newEvidencePath;
        }
    }

    // Simpan perubahan laporan
    $report->update([
        'school_id' => $validated['school_id'],
        'distribution_id' => $validated['distribution_id'] ?? null,
        'judul' => $validated['judul'],
        'kategori' => $validated['kategori'],
        'deskripsi' => $validated['deskripsi'],
        'evidence_path' => $evidencePath,
    ]);

    return redirect()
        ->route('reports.show', $report->id)
        ->with('success', 'Laporan berhasil diperbarui.');
}


}