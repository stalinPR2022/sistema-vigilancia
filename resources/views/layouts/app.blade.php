
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistema de vigilancia')</title>

    <!-- Bootstrap 5 mediante CDN -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

   
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">

            <a class="navbar-brand"
            href="{{ route('horarios.index') }}">
                Sistema de vigilancia
            </a>

            <div class="navbar-nav">
                <a class="nav-link"
                href="{{ route('horarios.index') }}">
                    Horarios
                </a>

                <a class="nav-link"
                href="{{ route('simulacion.index') }}">
                    Simulación
                </a>


                <a class="nav-link"
                href="{{ route('historial.index') }}">
                    Historial
                </a>

            </div>

        </div>
    </nav>


    <main class="container mb-5">
        @yield('content')
    </main>

    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
