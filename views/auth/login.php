<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | <?= APP_NAME ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #a855f7;
            --bg-color: #f3f4f6;
            --text-color: #1f2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-color);
        }

        .revision-banner {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            text-align: center;
            padding: 5px 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #555;
            border-bottom: 1px solid rgba(255,255,255,0.5);
        }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 500px;
        }

        .login-visual {
            flex: 1;
            background: url('https://picsum.photos/seed/takalo/600/800') no-repeat center center/cover;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            color: white;
        }

        .login-visual::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        }

        .visual-content {
            position: relative;
            z-index: 1;
        }

        .login-form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .role-switcher {
            display: flex;
            background: #eef2ff;
            padding: 5px;
            border-radius: 50px;
            margin-bottom: 2rem;
        }

        .role-btn {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px;
            border-radius: 50px;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .role-btn.active {
            color: var(--primary-color);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 1.5rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #9ca3af;
        }

        .form-control.with-icon {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-submit {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: transform 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }

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

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 400px;
            }
            .login-visual {
                min-height: 150px;
                padding: 1rem;
            }
            .login-form-section {
                padding: 2rem;
            }
        }
        
        .hidden { display: none; }
    </style>
</head>
<body>

    <div class="revision-banner">
        REVISION – Février 2026– P18/P5DS
    </div>

    <!-- Toast Notification -->
    <div class="toast-container">
        <?php if (isset($flash) && $flash): ?>
        <div class="toast align-items-center text-white bg-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><?= $flash['message'] ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="main-container">
        <div class="login-card fade-in">
            <!-- Partie Visuelle -->
            <div class="login-visual d-none d-md-flex">
                <div class="visual-content">
                    <h2><?= APP_NAME ?></h2>
                    <p class="mb-0">La plateforme d'échange d'objets simple et solidaire.</p>
                </div>
            </div>

            <!-- Partie Formulaire -->
            <div class="login-form-section">
                <div class="text-center d-md-none mb-4">
                    <h4 class="fw-bold text-primary"><i class="fas fa-sync-alt me-2"></i><?= APP_NAME ?></h4>
                </div>

                <!-- Sélecteur de Rôle -->
                <div class="role-switcher">
                    <button class="role-btn active" id="btnClient" onclick="switchRole('client')">
                        <i class="fas fa-user me-2"></i>Utilisateur
                    </button>
                    <button class="role-btn" id="btnAdmin" onclick="switchRole('admin')">
                        <i class="fas fa-user-shield me-2"></i>Admin
                    </button>
                </div>

                <h3 class="mb-4" id="formTitle">Connexion Membre</h3>

                <!-- Formulaire Client -->
                <form id="clientForm" action="<?= BASE_URL ?>/login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="mb-3">
                        <label for="clientEmail" class="form-label text-muted small">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control with-icon" id="clientEmail" name="email" placeholder="exemple@takalo.mg" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="clientPassword" class="form-label text-muted small">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control with-icon" id="clientPassword" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit">Se connecter</button>
                    <div class="text-center mt-3">
                        <a href="<?= BASE_URL ?>/register" class="text-decoration-none small text-primary">Pas encore inscrit ? Créer un compte</a>
                    </div>
                </form>

                <!-- Formulaire Admin -->
                <form id="adminForm" class="hidden" action="<?= BASE_URL ?>/admin/login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Accès réservé au backoffice
                    </div>
                    <div class="mb-3">
                        <label for="adminLogin" class="form-label text-muted small">Identifiant Admin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                            <input type="text" class="form-control with-icon" id="adminLogin" name="login" value="<?= DEFAULT_ADMIN_LOGIN ?>" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="adminPassword" class="form-label text-muted small">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control with-icon" id="adminPassword" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrer au Backoffice
                    </button>
                </form>
            </div>
        </div>
    </div>

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
            <a href="<?= GITHUB_LINK ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="fab fa-github"></i> Repo GIT</a>
            <a href="<?= TASKS_LINK ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-tasks"></i> Liste des tâches</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function switchRole(role) {
            const btnClient = document.getElementById('btnClient');
            const btnAdmin = document.getElementById('btnAdmin');
            const clientForm = document.getElementById('clientForm');
            const adminForm = document.getElementById('adminForm');
            const formTitle = document.getElementById('formTitle');

            if (role === 'admin') {
                btnAdmin.classList.add('active');
                btnClient.classList.remove('active');
                clientForm.classList.add('hidden');
                adminForm.classList.remove('hidden');
                adminForm.classList.add('fade-in');
                formTitle.textContent = "Connexion Administrateur";
            } else {
                btnClient.classList.add('active');
                btnAdmin.classList.remove('active');
                adminForm.classList.add('hidden');
                clientForm.classList.remove('hidden');
                clientForm.classList.add('fade-in');
                formTitle.textContent = "Connexion Membre";
            }
        }

        // Auto-hide toasts
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => toast.classList.remove('show'), 5000);
            });
        });
    </script>
</body>
</html>
