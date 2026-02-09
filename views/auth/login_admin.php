<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin | <?= APP_NAME ?></title>
    
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
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            padding: 3rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 15px;
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

        .back-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .back-link:hover {
            opacity: 1;
            color: white;
        }
    </style>
</head>
<body>

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

    <a href="<?= BASE_URL ?>/login" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour au site
    </a>

    <div class="login-card">
        <div class="login-header">
            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <h3 class="fw-bold">Backoffice Admin</h3>
            <p class="text-muted small"><?= APP_NAME ?></p>
        </div>

        <form action="<?= BASE_URL ?>/admin/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="alert alert-info py-2 small mb-4">
                <i class="fas fa-info-circle me-1"></i> Identifiants par défaut pré-remplis
            </div>

            <div class="mb-3">
                <label for="login" class="form-label text-muted small">Identifiant</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                    <input type="text" class="form-control with-icon" id="login" name="login" value="<?= $default_login ?? 'admin' ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label text-muted small">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="password" class="form-control with-icon" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-submit">
                <i class="fas fa-sign-in-alt me-2"></i>Connexion Admin
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => toast.classList.remove('show'), 5000);
            });
        });
    </script>
</body>
</html>
