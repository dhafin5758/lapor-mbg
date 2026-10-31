<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pelaporan MBG</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h2>Dashboard Pelaporan MBG</h2>

            <p>
                Selamat datang,
                <strong>{{ Auth::user()->name }}</strong>
            </p>

            <p>
                Role:
                <span class="badge bg-primary">
                    {{ Auth::user()->role }}
                </span>
            </p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>

        </div>
    </div>

</div>

</body>
</html>