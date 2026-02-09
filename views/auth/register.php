<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | <?= APP_NAME ?></title>
    
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
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
        }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 15px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
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
            padding: 1rem;
            text-align: center;
            font-size: 0.85rem;
            margin-top: auto;
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

    <div class="main-container">
        <div class="register-card">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary"><i class="fas fa-sync-alt me-2"></i><?= APP_NAME ?></h3>
                <p class="text-muted">Créer votre compte</p>
            </div>

            <form action="<?= BASE_URL ?>/register" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label small text-muted">Nom *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required placeholder="Votre nom">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label small text-muted">Prénom *</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required placeholder="Votre prénom">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small text-muted">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="exemple@email.com">
                </div>

                <div class="mb-3">
                    <label for="telephone" class="form-label small text-muted">Téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="+261 34 00 000 00">
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label small text-muted">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Votre adresse">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label small text-muted">Mot de passe *</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Min. 6 caractères">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirm" class="form-label small text-muted">Confirmer *</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required placeholder="Confirmer">
                    </div>
                </div>

                <button type="submit" class="btn btn-submit mt-3">
                    <i class="fas fa-user-plus me-2"></i>S'inscrire
                </button>

                <div class="text-center mt-3">
                    <a href="<?= BASE_URL ?>/login" class="text-decoration-none small text-primary">
                        Déjà inscrit ? Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p class="mb-0 text-muted"><?= APP_NAME ?> | Révision Février 2026</p>
    </footer>

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
