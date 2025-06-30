<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <nav class="mb-4">
        <a href="/kereta" class="btn btn-primary">Lihat Kereta</a>
        <a href="/tiket" class="btn btn-success">Tiket Saya</a>
        <a href="/pesan" class="btn btn-info">Pesan Tiket</a>
        <a href="/login" class="btn btn-outline-secondary">Login</a>
        <a href="/register" class="btn btn-outline-secondary">Register</a>
    </nav>

    @yield('content')
</body>
</html>
