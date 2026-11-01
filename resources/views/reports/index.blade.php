<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Laporan MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <h2>Daftar Laporan Saya</h2>
    <p>Berikut adalah laporan yang pernah dibuat.</p>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">
        Kembali ke Dashboard
    </a>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="card">
        <div class="card-body">
            
<form action="{{ route('reports.index') }}" method="GET" class="mb-4">
    <div class="row g-2">

        <!-- Pencarian judul -->
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari judul laporan..."
                   value="{{ request('search') }}">
        </div>

        <!-- Filter status -->
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>

                <option value="diajukan" @selected(request('status') == 'diajukan')>
                    Diajukan
                </option>

                <option value="dalam_peninjauan" @selected(request('status') == 'dalam_peninjauan')>
                    Dalam Peninjauan
                </option>

                <option value="perlu_dilengkapi" @selected(request('status') == 'perlu_dilengkapi')>
                    Perlu Dilengkapi
                </option>

                <option value="siap_ditindaklanjuti" @selected(request('status') == 'siap_ditindaklanjuti')>
                    Siap Ditindaklanjuti
                </option>

                <option value="selesai" @selected(request('status') == 'selesai')>
                    Selesai
                </option>
            </select>
        </div>

        <!-- Filter kategori -->
        <div class="col-md-3">
            <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>

                @foreach ($categories as $category)
                    <option value="{{ $category }}"
                        @selected(request('kategori') == $category)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tombol cari -->
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                Cari
            </button>
        </div>

    </div>

    <div class="mt-2">
        <a href="{{ route('reports.index') }}"
           class="btn btn-outline-secondary btn-sm">
            Reset Filter
        </a>
    </div>
</form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Sekolah</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

              <tbody>
    @forelse ($reports as $report)
        <tr>
            <td>
                <a href="{{ route('reports.show', $report->id) }}"
                   class="btn btn-sm btn-primary">
                    Detail
                </a>
            </td>

<td>{{ $reports->firstItem() + $loop->index }}</td>
            <td>{{ $report->judul }}</td>
            <td>{{ $report->school->nama_sekolah }}</td>
            <td>{{ $report->kategori }}</td>
            <td>{{ $report->status }}</td>
            <td>{{ $report->created_at->format('d-m-Y') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">
                Belum ada laporan.
            </td>
        </tr>
    @endforelse
</tbody>
            </table>

{{ $reports->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>

</body>
</html>