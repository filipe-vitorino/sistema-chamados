<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Sistema de Chamados')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand"
           href="{{ route('dashboard') }}">
            Sistema de Chamados
        </a>

        <div class="navbar-nav">

            <a class="nav-link"
               href="{{ route('dashboard') }}">
                Dashboard
            </a>

            <a class="nav-link"
               href="{{ route('responsaveis.index') }}">
                Responsáveis
            </a>

            <a class="nav-link"
               href="{{ route('chamados.index') }}">
                Chamados
            </a>

        </div>

    </div>
</nav>

<div class="container mt-4">

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>