<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Sekolah MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <h2>Edit Data Sekolah</h2>
    <p class="text-muted">Perbarui informasi sekolah.</p>

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

            <form action="{{ route('schools.update', $school->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text"
                           name="nama_sekolah"
                           class="form-control"
                           value="{{ old('nama_sekolah', $school->nama_sekolah) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NPSN</label>
                    <input type="text"
                           name="npsn"
                           class="form-control"
                           value="{{ old('npsn', $school->npsn) }}"
                           maxlength="8"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="3">{{ old('alamat', $school->alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kabupaten/Kota</label>
                    <input type="text"
                           name="kabupaten_kota"
                           class="form-control"
                           value="{{ old('kabupaten_kota', $school->kabupaten_kota) }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </form>

        </div>
    </div>

</div>

</body>
</html>
