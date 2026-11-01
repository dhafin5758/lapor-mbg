
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
<th>Laporan Terkait</th>
<th>Aksi Review</th>
                        </tr>
                    </thead>

                   <tbody>
    @forelse ($reports as $report)
        {{-- Baris utama laporan --}}
        <tr>
            <td>
                {{ $reports->firstItem() + $loop->index }}
            </td>

            <td>{{ $report->judul }}</td>

            <td>{{ $report->user->nama_lengkap }}</td>

            <td>{{ $report->school->nama_sekolah }}</td>

            <td>
                <span class="badge bg-primary">
                    {{ $report->status }}
                </span>
            </td>

            <td>
                {{ $report->created_at->format('d-m-Y') }}
            </td>

            {{-- Tombol laporan terkait --}}
            <td style="min-width: 180px;">
                <button
                    class="btn btn-outline-info btn-sm w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#related-{{ $report->id }}"
                    aria-expanded="false"
                    aria-controls="related-{{ $report->id }}"
                >
                    Lihat Laporan Terkait
                </button>
            </td>

            {{-- Form review --}}
            <td style="min-width: 250px;">
                <form action="{{ route('reviews.store', $report->id) }}"
                      method="POST">
                    @csrf

                    <div class="mb-2">
                        <select name="hasil" class="form-select" required>
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

                    <button type="submit" class="btn btn-primary btn-sm">
                        Simpan Review
                    </button>
                </form>
            </td>
        </tr>

        {{-- Baris detail laporan terkait --}}
        <tr>
            <td colspan="8" class="p-0 border-0">
                <div class="collapse" id="related-{{ $report->id }}">
                    <div class="bg-light p-3 border-bottom">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <strong>
                                            Laporan dari Sekolah yang Sama
                                        </strong>
                                    </div>

                                    <div class="card-body">
                                        @forelse ($report->related_school_reports as $related)
                                            <div class="border-bottom pb-2 mb-2">
                                                <strong>{{ $related->judul }}</strong>
                                                <div class="small text-muted">
                                                    Kategori: {{ $related->kategori }}<br>
                                                    Status: {{ $related->status }}<br>
                                                    Tanggal: {{ $related->created_at->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted mb-0">
                                                Belum ada laporan lain dari sekolah ini.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <strong>
                                            Laporan dari Distribusi yang Sama
                                        </strong>
                                    </div>

                                    <div class="card-body">
                                        @forelse ($report->related_distribution_reports as $related)
                                            <div class="border-bottom pb-2 mb-2">
                                                <strong>{{ $related->judul }}</strong>
                                                <div class="small text-muted">
                                                    Kategori: {{ $related->kategori }}<br>
                                                    Status: {{ $related->status }}<br>
                                                    Tanggal: {{ $related->created_at->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted mb-0">
                                                Belum ada laporan lain dari distribusi ini.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="8" class="text-center">
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
