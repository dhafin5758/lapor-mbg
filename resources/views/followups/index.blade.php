
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tindak Lanjut Laporan MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2>Daftar Tindak Lanjut</h2>
            <p class="text-muted">
                Kelola penerusan laporan kepada pihak terkait.
            </p>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>Pelapor</th>
                            <th>Sekolah</th>
                            <th>Tanggal Laporan</th>
                            <th>Form Tindak Lanjut</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>
                                    {{ $reports->firstItem() + $loop->index }}
                                </td>

                                <td>{{ $report->judul }}</td>

                                <td>{{ $report->user->name }}</td>

                                <td>{{ $report->school->nama_sekolah }}</td>

                                <td>
                                    {{ $report->created_at->format('d-m-Y') }}
                                </td>

                                <td style="min-width: 260px;">
                                    <form action="{{ route('followups.store', $report->id) }}"
                                          method="POST">
                                        @csrf

                                        <div class="mb-2">
                                            <input type="text"
                                                   name="pihak_tujuan"
                                                   class="form-control"
                                                   placeholder="Pihak tujuan penerusan"
                                                   required>
                                        </div>

                                        <div class="mb-2">
                                            <textarea name="catatan"
                                                      class="form-control"
                                                      rows="2"
                                                      placeholder="Catatan tindak lanjut"></textarea>
                                        </div>

                                        <button type="submit"
                                                class="btn btn-primary btn-sm">
                                            Simpan Tindak Lanjut
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada laporan yang perlu ditindaklanjuti.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $reports->links() }}

            <a href="{{ route('dashboard') }}"
               class="btn btn-secondary">
                Kembali ke Dashboard
            </a>

        </div>
    </div>
</div>

</body>
</html>
