<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> | Backoffice <?= APP_NAME ?></title>
    
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
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --text-light: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            overflow-x: hidden;
        }

        /* Bandeau révision */
        .revision-banner {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 5px 0;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Layout */
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: calc(100vh - 35px);
        }

        /* Sidebar */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: var(--sidebar-bg);
            color: var(--text-light);
            transition: all 0.3s;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #47748b;
        }

        #sidebar ul li a {
            padding: 15px 25px;
            font-size: 1.1em;
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        #sidebar ul li a:hover, #sidebar ul li a.active {
            color: white;
            background: var(--sidebar-hover);
            border-left: 4px solid var(--secondary-color);
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Contenu Principal */
        #content {
            width: 100%;
            padding: 30px;
        }

        /* Cartes de Stats */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-left: 5px solid var(--primary-color);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            opacity: 0.2;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-info p {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Tableau Style */
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 5px;
            transition: transform 0.2s;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        .btn-edit { background-color: #e0f2fe; color: #0284c7; border: none; }
        .btn-delete { background-color: #fee2e2; color: #dc2626; border: none; }
        .btn-add { background: linear-gradient(to right, var(--primary-color), var(--secondary-color)); border: none; }
        .btn-add:hover { opacity: 0.9; color: white; }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            color: #64748b;
            font-size: 0.85rem;
        }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 50px;
            right: 20px;
            z-index: 1060;
        }
    </style>
</head>
<body>

    <!-- Bandeau Révision -->
    <div class="revision-banner">
        REVISION – Février 2026– P18/P5DS | Backoffice Administration
    </div>

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

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-sync-alt me-2"></i>Takalo</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="<?= BASE_URL ?>/admin/dashboard" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') !== false ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Tableau de bord
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/categories" class="<?= strpos($_SERVER['REQUEST_URI'], '/categories') !== false ? 'active' : '' ?>">
                        <i class="fas fa-tags"></i> Catégories
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/objects">
                        <i class="fas fa-box-open"></i> Objets
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/users">
                        <i class="fas fa-users"></i> Utilisateurs
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/logout" class="text-danger mt-5">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark"><?= $title ?? 'Administration' ?></h2>
                <div class="user-profile d-flex align-items-center">
                    <span class="me-2 text-muted"><?= $_SESSION['admin_login'] ?? 'Admin' ?></span>
                    <img src="https://picsum.photos/seed/admin/40/40" class="rounded-circle" alt="Admin">
                </div>
            </div>

            <!-- Contenu de la page -->
            <?= $content ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Projet <?= APP_NAME ?> | Backend Admin</p>
        <p class="small text-muted">
            Équipe P18/P5DS | 
            <?php 
            $members = [];
            foreach (TEAM_INFO as $member) {
                $members[] = $member['nom'] . ' (' . $member['etu'] . ')';
            }
            echo implode(' | ', $members);
            ?>
        </p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-hide toasts
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 4000);
            });
        });
    </script>
</body>
</html>
