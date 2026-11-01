
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Review Laporan MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2>Daftar Laporan Masuk</h2>
            <p class="text-muted">
                Periksa laporan yang dikirim oleh Pelapor.
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
                
<form action="{{ route('reviews.index') }}" method="GET" class="mb-4">
    <div class="row g-2">
        <div class="col-md-4">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari judul laporan..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="diajukan" @selected(request('status') == 'diajukan')>
                    Diajukan
                </option>
                <option value="perlu_dilengkapi" @selected(request('status') == 'perlu_dilengkapi')>
                    Perlu Dilengkapi
                </option>
            </select>
        </div>

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

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                Cari
            </button>
        </div>
    </div>

    <div class="mt-2">
        <a href="{{ route('reviews.index') }}"
           class="btn btn-outline-secondary btn-sm">
            Reset Filter
        </a>
    </div>
</form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>Pelapor</th>
                            <th>Sekolah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi Review</th>
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
                                    <span class="badge bg-primary">
                                        {{ $report->status }}
                                    </span>
                                </td>

                                <td>
                                    {{ $report->created_at->format('d-m-Y') }}
                                </td>

                                <td style="min-width: 250px;">
                                    <form action="{{ route('reviews.store', $report->id) }}"
                                          method="POST">
                                        @csrf

                                        <div class="mb-2">
                                            <select name="hasil"
                                                    class="form-select"
                                                    required>
                                                <option value="">Pilih hasil review</option>
                                                <option value="perlu_dilengkapi">
                                                    Perlu Dilengkapi
                                                </option>
                                                <option value="siap_ditindaklanjuti">
                                                    Siap Ditindaklanjuti
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <textarea name="catatan"
                                                      class="form-control"
                                                      placeholder="Catatan hasil review"
                                                      rows="2"></textarea>
                                        </div>

                                        <button type="submit"
                                                class="btn btn-primary btn-sm">
                                            Simpan Review
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Tidak ada laporan yang perlu diperiksa.
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
