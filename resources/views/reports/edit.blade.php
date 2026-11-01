
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Laporan MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2>Edit Laporan MBG</h2>
            <p class="text-muted">Perbarui informasi laporan yang sudah dibuat.</p>

            <form action="{{ route('reports.update', $report->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Sekolah</label>

                    <select name="school_id" id="school_id" class="form-select" required>
                        <option value="">-- Pilih Sekolah --</option>

                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                @selected(old('school_id', $report->school_id) == $school->id)>
                                {{ $school->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>

                    @error('school_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Distribusi Makanan</label>

                    <select name="distribution_id"
                            id="distribution_id"
                            class="form-select"
                            disabled>
                        <option value="">Memuat distribusi...</option>
                    </select>

                    @error('distribution_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Laporan</label>

                    <input type="text"
                           name="judul"
                           class="form-control"
                           value="{{ old('judul', $report->judul) }}"
                           required>

                    @error('judul')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>

                    <select name="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>

                        @foreach (['Kualitas makanan', 'Kebersihan makanan', 'Keterlambatan distribusi', 'Porsi makanan', 'Lainnya'] as $kategori)
                            <option value="{{ $kategori }}"
                                @selected(old('kategori', $report->kategori) === $kategori)>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('kategori')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>

                    <textarea name="deskripsi"
                              class="form-control"
                              rows="5"
                              required>{{ old('deskripsi', $report->deskripsi) }}</textarea>

                    @error('deskripsi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Bukti Laporan</label>

                    @if ($report->evidence_path)
                        <p>
                            Bukti saat ini:
                            <a href="{{ asset('storage/' . $report->evidence_path) }}"
                               target="_blank">
                                Lihat bukti sebelumnya
                            </a>
                        </p>
                    @else
                        <p class="text-muted">Belum ada bukti yang diunggah.</p>
                    @endif

                    <input type="file"
                           name="evidence"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.pdf">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti bukti. Maksimal 2 MB.
                    </small>

                    @error('evidence')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('reports.show', $report->id) }}"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>
        </div>
    </div>
</div>

<script>
    const schoolSelect = document.getElementById('school_id');
    const distributionSelect = document.getElementById('distribution_id');

    async function loadDistributions(schoolId, selectedId = '') {
        distributionSelect.innerHTML =
            '<option value="">Memuat distribusi...</option>';

        distributionSelect.disabled = true;

        if (!schoolId) {
            distributionSelect.innerHTML =
                '<option value="">-- Pilih sekolah terlebih dahulu --</option>';
            return;
        }

        try {
            const response = await fetch(`/sekolah/${schoolId}/distribusi`);

            if (!response.ok) {
                throw new Error('Gagal mengambil data distribusi.');
            }

            const distributions = await response.json();

            distributionSelect.innerHTML =
                '<option value="">-- Tidak memilih distribusi --</option>';

            distributions.forEach(distribution => {
                const option = document.createElement('option');

                option.value = distribution.id;
                option.textContent =
                    `${distribution.tanggal_penyaluran} - ${distribution.menu}`;

                if (String(distribution.id) === String(selectedId)) {
                    option.selected = true;
                }

                distributionSelect.appendChild(option);
            });

            distributionSelect.disabled = false;

        } catch (error) {
            distributionSelect.innerHTML =
                '<option value="">Gagal memuat distribusi</option>';

            console.error(error);
        }
    }

    schoolSelect.addEventListener('change', function () {
        loadDistributions(this.value);
    });

    if (schoolSelect.value) {
        loadDistributions(
            schoolSelect.value,
            @json(old('distribution_id', $report->distribution_id))
        );
    }
</script>

</body>
</html>
