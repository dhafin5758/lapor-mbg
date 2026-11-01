
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekap Laporan MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <h2>Rekap Laporan MBG</h2>
    <p class="text-muted">Monitoring keseluruhan laporan keamanan makanan MBG.</p>

    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Kembali ke Dashboard
        </a>

        <a href="{{ route('followups.index') }}" class="btn btn-outline-primary">
            Kelola Tindak Lanjut
        </a>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-primary h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Laporan</h6>
                    <h2>{{ $totalLaporan }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning h-100">
                <div class="card-body">
                    <h6 class="text-muted">Laporan Dalam Proses</h6>
                    <h2>{{ $laporanDalamProses }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success h-100">
                <div class="card-body">
                    <h6 class="text-muted">Laporan Selesai</h6>
                    <h2>{{ $laporanSelesai }}</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">

            <h5 class="mb-3">Filter Laporan</h5>

            <form action="{{ route('followups.recap') }}" method="GET">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input
                            type="date"
                            name="tanggal_mulai"
                            class="form-control"
                            value="{{ request('tanggal_mulai') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input
                            type="date"
                            name="tanggal_akhir"
                            class="form-control"
                            value="{{ request('tanggal_akhir') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
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

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            Terapkan
                        </button>

                        <a href="{{ route('followups.recap') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Tabel Rekap -->
    <div class="card">
        <div class="card-body">

            <h5 class="mb-3">Data Laporan</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Sekolah</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $reports->firstItem() + $loop->index }}</td>

                                <td>{{ $report->judul }}</td>

                                <td>{{ $report->user->name }}</td>

                                <td>{{ $report->school->nama_sekolah }}</td>

                                <td>{{ $report->kategori }}</td>

                                <td>
                                    @php
                                        $statusLabels = [
                                            'diajukan' => 'Diajukan',
                                            'dalam_peninjauan' => 'Dalam Peninjauan',
                                            'perlu_dilengkapi' => 'Perlu Dilengkapi',
                                            'siap_ditindaklanjuti' => 'Siap Ditindaklanjuti',
                                            'selesai' => 'Selesai',
                                        ];
                                    @endphp

                                    {{ $statusLabels[$report->status] ?? $report->status }}
                                </td>

                                <td>{{ $report->created_at->format('d-m-Y') }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Tidak ada laporan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $reports->links() }}
            </div>

        </div>
    </div>

</div>

</body>
</html>
