
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Laporan MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2>Detail Laporan</h2>
            <hr>

            <p><strong>Judul:</strong> {{ $report->judul }}</p>

            <p><strong>Sekolah:</strong>
                {{ $report->school->nama_sekolah }}
            </p>

            <p><strong>Distribusi:</strong>
                {{ $report->distribution
                    ? $report->distribution->menu
                    : 'Tidak ditentukan' }}
            </p>

            <p><strong>Kategori:</strong> {{ $report->kategori }}</p>

            <p><strong>Status:</strong> {{ $report->status }}</p>

            <p><strong>Deskripsi:</strong></p>
            <div class="border rounded p-3 bg-light">
                {{ $report->deskripsi }}
            </div>

            <p class="mt-3"><strong>Bukti laporan:</strong></p>

            @if ($report->evidence_path)
                <a href="{{ asset('storage/' . $report->evidence_path) }}"
                   target="_blank"
                   class="btn btn-outline-primary">
                    Lihat Bukti
                </a>
            @else
                <p class="text-muted">Tidak ada bukti yang diunggah.</p>
            @endif
                @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
            <hr>

            @if (in_array($report->status, ['diajukan', 'perlu_dilengkapi']))
                <a href="{{ route('reports.edit', $report->id) }}"
                   class="btn btn-warning">
                    Edit Laporan
                </a>
            @endif

            <a href="{{ route('reports.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </div>
    </div>
</div>

</body>
</html>
