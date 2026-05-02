<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksales — @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --booksales-dark: #1a1816;
            --booksales-card: #221f1b;
            --booksales-border: #3a342c;
            --booksales-accent: #e8a849;
            --booksales-text: #f0e8dc;
            --booksales-muted: #9a8e7e;
        }

        body {
            background-color: var(--booksales-dark);
            color: var(--booksales-text);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-booksales {
            background-color: var(--booksales-card) !important;
            border-bottom: 1px solid var(--booksales-border);
        }
        .navbar-booksales .navbar-brand {
            color: var(--booksales-accent) !important;
            font-weight: 800;
            font-size: 1.4rem;
        }
        .navbar-booksales .nav-link {
            color: var(--booksales-muted) !important;
            font-weight: 500;
        }
        .navbar-booksales .nav-link:hover,
        .navbar-booksales .nav-link.active {
            color: var(--booksales-accent) !important;
        }

        /* Card */
        .card-booksales {
            background-color: var(--booksales-card);
            border: 1px solid var(--booksales-border);
            border-radius: 12px;
        }
        .card-booksales .card-header {
            background-color: rgba(0,0,0,0.2);
            border-bottom: 1px solid var(--booksales-border);
            color: var(--booksales-text);
            font-weight: 700;
        }

        /* Tabel */
        .table-booksales {
            color: var(--booksales-text);
            margin-bottom: 0;
        }
        .table-booksales thead th {
            background-color: rgba(0,0,0,0.15);
            border-bottom: 1px solid var(--booksales-border);
            color: var(--booksales-muted);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }
        .table-booksales tbody td {
            border-bottom: 1px solid var(--booksales-border);
            vertical-align: middle;
        }
        .table-booksales tbody tr:hover {
            background-color: rgba(232,168,73,0.05);
        }
        .table-booksales tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge buku */
        .badge-book {
            background-color: rgba(232,168,73,0.15);
            color: var(--booksales-accent);
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* Status badge */
        .badge-active {
            background-color: rgba(79,173,106,0.15);
            color: #4fad6a;
        }
        .badge-inactive {
            background-color: rgba(217,79,79,0.12);
            color: #d94f4f;
        }

        /* Halaman utama */
        .page-header {
            margin-bottom: 28px;
        }
        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .page-header p {
            color: var(--booksales-muted);
            font-size: 0.9rem;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--booksales-border);
            padding: 20px 0;
            color: var(--booksales-muted);
            font-size: 0.82rem;
            margin-top: 40px;
            text-align: center;
        }
        footer span { color: var(--booksales-accent); font-weight: 600; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-booksales">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-book"></i> Booksales
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('genres')) active @endif" href="/genres">
                            <i class="bi bi-tags"></i> Genre
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('authors')) active @endif" href="/authors">
                            <i class="bi bi-feather"></i> Author
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten utama -->
    <main class="container my-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            Laravel MVC Pattern &middot; <span>Booksales v1.0</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>