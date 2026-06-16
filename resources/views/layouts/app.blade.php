<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Chamados')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* O Verde Codificar */
            --codificar-green: #00b37e; 
            --codificar-green-hover: #00966a;
            --sidebar-bg: #1e1e24;
            --sidebar-hover: #2b2b36;
            --bg-color: #f4f6f8;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Estrutura Principal */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Estilos da Barra Lateral (Sidebar) */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .brand {
            padding: 1.5rem;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--codificar-green);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #a0a0ab;
            text-decoration: none;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--sidebar-hover);
            color: #fff;
            border-left: 4px solid var(--codificar-green);
        }

        /* Área de Conteúdo */
        .main-content {
            flex: 1;
            padding: 2.5rem;
            width: calc(100% - 260px);
        }

        /* Cards Suaves */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Botões Personalizados */
        .btn-codificar {
            background-color: var(--codificar-green);
            color: #fff;
            border: none;
            font-weight: 500;
        }

        .btn-codificar:hover {
            background-color: var(--codificar-green-hover);
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <nav class="sidebar">
            <div class="brand">
                <i class="fa-solid fa-code"></i> CODIFICAR
            </div>
            <div class="mt-4">
                {{-- <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a> --}}
                
                <a href="{{ route('chamados.index') }}" class="{{ request()->routeIs('chamados.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-ticket"></i> Chamados
                </a>
                
                <a href="{{ route('responsaveis.index') }}" class="{{ request()->routeIs('responsaveis.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Responsáveis
                </a>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>