<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Koordinator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2>Dashboard Koordinator</h2>
        <p>Selamat datang, {{ Auth::user()->name }}</p>

        <div class="card p-4">
            <h5>Menu Koordinator</h5>
            <a href="{{ route('followups.index') }}"
   class="btn btn-primary">
    Kelola Tindak Lanjut
</a>
    <a href="{{ route('followups.recap') }}" class="btn btn-success">
    Lihat Rekap Laporan
</a>
    <a href="{{ route('schools.index') }}" class="btn btn-warning">
    Kelola Sekolah
</a>

<a href="{{ route('distributions.index') }}" class="btn btn-info">
    Kelola Distribusi
</a>
          
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>