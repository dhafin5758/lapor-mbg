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

            <td>{{ $loop->iteration }}</td>
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

            {{ $reports->links() }}

        </div>
    </div>

</div>

</body>
</html>