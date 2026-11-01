<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\School;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with('school')
            ->latest('tanggal_penyaluran')
            ->paginate(10);

        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        $schools = School::orderBy('nama_sekolah')->get();

        return view('distributions.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'tanggal_penyaluran' => 'required|date',
            'menu' => 'required|string|max:255',
            'status_penyaluran' => 'required|in:terjadwal,terlaksana,dibatalkan',
        ]);

        Distribution::create($validated);

        return redirect()->route('distributions.index')
            ->with('success', 'Data distribusi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $distribution = Distribution::findOrFail($id);
        $schools = School::orderBy('nama_sekolah')->get();

        return view('distributions.edit', compact('distribution', 'schools'));
    }

    public function update(Request $request, $id)
    {
        $distribution = Distribution::findOrFail($id);

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'tanggal_penyaluran' => 'required|date',
            'menu' => 'required|string|max:255',
            'status_penyaluran' => 'required|in:terjadwal,terlaksana,dibatalkan',
        ]);

        $distribution->update($validated);

        return redirect()->route('distributions.index')
            ->with('success', 'Data distribusi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $distribution = Distribution::findOrFail($id);

        if ($distribution->reports()->exists()) {
            return back()->with(
                'error',
                'Distribusi tidak dapat dihapus karena sudah digunakan dalam laporan.'
            );
        }

        $distribution->delete();

        return redirect()->route('distributions.index')
            ->with('success', 'Data distribusi berhasil dihapus.');
    }
}
