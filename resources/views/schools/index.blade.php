<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Sekolah MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <h2>Kelola Data Sekolah</h2>
    <p class="text-muted">Manajemen data sekolah penerima distribusi MBG.</p>

    <div class="mb-3">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Kembali ke Dashboard
        </a>

        <a href="{{ route('schools.create') }}" class="btn btn-primary">
            + Tambah Sekolah
        </a>
    </div>

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

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>NPSN</th>
                            <th>Alamat</th>
                            <th>Kabupaten/Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($schools as $school)
                            <tr>
                                <td>{{ $schools->firstItem() + $loop->index }}</td>
                                <td>{{ $school->nama_sekolah }}</td>
                                <td>{{ $school->npsn }}</td>
                                <td>{{ $school->alamat ?? '-' }}</td>
                                <td>{{ $school->kabupaten_kota }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('schools.edit', $school->id) }}"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('schools.destroy', $school->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus sekolah ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada data sekolah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $schools->links() }}
            </div>

        </div>
    </div>

</div>

</body>
</html>
