<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Distribusi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h3 class="mb-4">Edit Distribusi</h3>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('distributions.update', $distribution->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Sekolah</label>
                    <select name="school_id" class="form-select" required>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ old('school_id', $distribution->school_id) == $school->id ? 'selected' : '' }}>
                                {{ $school->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Penyaluran</label>
                    <input type="date" name="tanggal_penyaluran"
                        class="form-control"
                        value="{{ old('tanggal_penyaluran', $distribution->tanggal_penyaluran->format('Y-m-d')) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Menu Makanan</label>
                    <input type="text" name="menu" class="form-control"
                        value="{{ old('menu', $distribution->menu) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Penyaluran</label>
                    <select name="status_penyaluran" class="form-select" required>
                        <option value="terjadwal"
                            {{ old('status_penyaluran', $distribution->status_penyaluran) == 'terjadwal' ? 'selected' : '' }}>
                            Terjadwal
                        </option>
                        <option value="terlaksana"
                            {{ old('status_penyaluran', $distribution->status_penyaluran) == 'terlaksana' ? 'selected' : '' }}>
                            Terlaksana
                        </option>
                        <option value="dibatalkan"
                            {{ old('status_penyaluran', $distribution->status_penyaluran) == 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('distributions.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
