
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Lapor-mbg')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                Lapor-mbg
            </a>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

</body>
</html>
