<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelapor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2>Dashboard Pelapor</h2>
        <p>Selamat datang, {{ Auth::user()->name }}</p>

        <div class="card p-4">
            <h5>Menu Pelapor</h5>
            <p>Di sini pelapor dapat membuat laporan dan melihat status laporan miliknya.</p>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>