<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Takalo-Takalo' ?> | <?= APP_NAME ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #a855f7;
            --bg-color: #f3f4f6;
            --text-color: #1f2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-color);
        }

        /* Bandeau de révision */
        .revision-banner {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 5px 0;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: #64748b !important;
            transition: color 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Main content */
        main {
            flex: 1;
            padding: 2rem 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Footer */
        footer {
            background: white;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid #eee;
            margin-top: auto;
        }

        .team-info {
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 5px;
        }

        /* Toast container */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1055;
        }

        /* Object cards */
        .object-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .object-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .object-card img {
            height: 180px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .price-badge {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .category-badge {
            background: #eef2ff;
            color: var(--primary-color);
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <!-- Bandeau Révision -->
    <div class="revision-banner">
        REVISION – Février 2026– P18/P5DS
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">
                <i class="fas fa-sync-alt me-2"></i><?= APP_NAME ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/dashboard"><i class="fas fa-home me-1"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/mes-objets"><i class="fas fa-box me-1"></i> Mes Objets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/explorer"><i class="fas fa-search me-1"></i> Explorer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/mes-echanges"><i class="fas fa-exchange-alt me-1"></i> Échanges</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= $_SESSION['user_name'] ?? 'Utilisateur' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/profil"><i class="fas fa-cog me-2"></i>Mon Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/logout"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Toast Container -->
    <div class="toast-container">
        <?php if (isset($flash) && $flash): ?>
        <div class="toast align-items-center text-white bg-<?= $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'warning' ? 'warning' : 'success') ?> border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <?= $flash['message'] ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <main class="container">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer>
        <p class="mb-1 text-muted">Projet <?= APP_NAME ?> | Révision Février 2026</p>
        <div class="team-info">
            <?php 
            $members = [];
            foreach (TEAM_INFO as $member) {
                $members[] = $member['nom'] . ' (' . $member['etu'] . ')';
            }
            echo implode(' • ', $members);
            ?>
        </div>
        <div class="mt-3">
            <a href="<?= GITHUB_LINK ?>" class="btn btn-sm btn-outline-secondary me-2" target="_blank">
                <i class="fab fa-github"></i> Repo GIT
            </a>
            <a href="<?= TASKS_LINK ?>" class="btn btn-sm btn-outline-secondary" target="_blank">
                <i class="fas fa-tasks"></i> Liste des tâches
            </a>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 5000);
            });
        });
    </script>
</body>
</html>
