
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Sekolah MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <h2>Tambah Sekolah</h2>
    <p class="text-muted">Masukkan informasi sekolah penerima distribusi MBG.</p>

    <a href="{{ route('schools.index') }}" class="btn btn-secondary mb-3">
        Kembali
    </a>

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

            <form action="{{ route('schools.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text"
                           name="nama_sekolah"
                           class="form-control"
                           value="{{ old('nama_sekolah') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NPSN</label>
                    <input type="text"
                           name="npsn"
                           class="form-control"
                           value="{{ old('npsn') }}"
                           maxlength="8"
                           required>
                    <small class="text-muted">Masukkan 8 digit NPSN.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="3">{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kabupaten/Kota</label>
                    <input type="text"
                           name="kabupaten_kota"
                           class="form-control"
                           value="{{ old('kabupaten_kota') }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Sekolah
                </button>

            </form>

        </div>
    </div>

</div>

</body>
</html>
