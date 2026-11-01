<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Distribusi MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Distribusi MBG</h2>
            <p class="text-muted">Kelola data penyaluran makanan ke sekolah.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
            <a href="{{ route('distributions.create') }}" class="btn btn-primary">Tambah Distribusi</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Sekolah</th>
                        <th>Tanggal Penyaluran</th>
                        <th>Menu</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($distributions as $distribution)
                        <tr>
                            <td>{{ $distributions->firstItem() + $loop->index }}</td>
                            <td>{{ $distribution->school->nama_sekolah }}</td>
                            <td>{{ \Carbon\Carbon::parse($distribution->tanggal_penyaluran)->format('d-m-Y') }}</td>
                            <td>{{ $distribution->menu }}</td>
                            <td>
                                @if($distribution->status_penyaluran === 'terlaksana')
                                    <span class="badge bg-success">Terlaksana</span>
                                @elseif($distribution->status_penyaluran === 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Terjadwal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('distributions.edit', $distribution->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('distributions.destroy', $distribution->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus distribusi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data distribusi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $distributions->links() }}
        </div>
    </div>
</div>

</body>
</html>
