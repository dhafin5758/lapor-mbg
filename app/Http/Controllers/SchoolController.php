<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    // Menampilkan seluruh sekolah
    public function index()
    {
        $schools = School::latest()->paginate(10);

        return view('schools.index', compact('schools'));
    }

    // Menampilkan form tambah sekolah
    public function create()
    {
        return view('schools.create');
    }

    // Menyimpan sekolah baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|size:8|unique:schools,npsn',
            'alamat' => 'nullable|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
        ]);

        School::create($validated);

        return redirect()->route('schools.index')
            ->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    // Menampilkan form edit sekolah
    public function edit($id)
    {
        $school = School::findOrFail($id);

        return view('schools.edit', compact('school'));
    }

    // Memperbarui data sekolah
    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => [
                'required',
                'string',
                'size:8',
                Rule::unique('schools', 'npsn')->ignore($school->id),
            ],
            'alamat' => 'nullable|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
        ]);

        $school->update($validated);

        return redirect()->route('schools.index')
            ->with('success', 'Data sekolah berhasil diperbarui.');
    }

    // Menghapus sekolah
    public function destroy($id)
    {
        $school = School::findOrFail($id);

        // Sekolah tidak boleh dihapus jika sudah memiliki distribusi atau laporan
        if ($school->distributions()->exists() || $school->reports()->exists()) {
            return back()->with(
                'error',
                'Sekolah tidak dapat dihapus karena sudah memiliki data distribusi atau laporan.'
            );
        }

        $school->delete();

        return redirect()->route('schools.index')
            ->with('success', 'Data sekolah berhasil dihapus.');
    }
}
