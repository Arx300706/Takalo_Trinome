<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Takalo-Takalo | Admin & User</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
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

        /* Bandeau de révision */
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

        /* Conteneur principal centré */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Carte de connexion */
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

        /* Côté visuel (Image/Branding) */
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

        /* Côté Formulaire */
        .login-form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Navigation onglets (Admin / User) */
        .role-switcher {
            display: flex;
            background: #eef2ff;
            padding: 5px;
            border-radius: 50px;
            margin-bottom: 2rem;
            position: relative;
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
            z-index: 2;
        }

        .role-btn.active {
            color: var(--primary-color);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Styles des inputs */
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

        /* Bouton submit */
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

        /* Toast de notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
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

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
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
        
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <!-- Bandeau Révision (Consigne Projet) -->
    <div class="revision-banner">
        REVISION – Février 2026– P18/P5DS
    </div>

    <!-- Notification Toast -->
    <div class="toast-container">
        <div id="loginToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Connexion réussie !
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="login-card fade-in">
            <!-- Partie Visuelle (Gauche) -->
            <div class="login-visual d-none d-md-flex">
                <div class="visual-content">
                    <h2>Takalo-Takalo</h2>
                    <p class="mb-0">La plateforme d'échange d'objets simple et solidaire.</p>
                </div>
            </div>

            <!-- Partie Formulaire (Droite) -->
            <div class="login-form-section">
                <!-- Logo Mobile -->
                <div class="text-center d-md-none mb-4">
                    <h4 class="fw-bold text-primary"><i class="fas fa-sync-alt me-2"></i>Takalo-Takalo</h4>
                </div>

                <!-- Sélecteur de Rôle (Admin vs Client) -->
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
                <form id="clientForm" onsubmit="handleLogin(event, 'client')">
                    <div class="mb-3">
                        <label for="clientEmail" class="form-label text-muted small">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control with-icon" id="clientEmail" placeholder="exemple@takalo.mg" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="clientPassword" class="form-label text-muted small">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control with-icon" id="clientPassword" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit">Se connecter</button>
                    <div class="text-center mt-3">
                        <a href="#" class="text-decoration-none small text-muted">Mot de passe oublié ?</a>
                    </div>
                </form>

                <!-- Formulaire Admin (Caché par défaut) -->
                <form id="adminForm" class="hidden" onsubmit="handleLogin(event, 'admin')">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Accès réservé au backoffice
                    </div>
                    <div class="mb-3">
                        <label for="adminLogin" class="form-label text-muted small">Identifiant Admin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                            <!-- Valeur par défaut comme demandé -->
                            <input type="text" class="form-control with-icon" id="adminLogin" value="admin" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="adminPassword" class="form-label text-muted small">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control with-icon" id="adminPassword" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrer au Backoffice
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Footer avec infos étudiantes -->
    <footer>
        <p class="mb-1 text-muted">Projet Takalo-Takalo | Révision Février 2026</p>
        <div class="team-info">
            NOM Prénom (ETU00000) • NOM Prénom (ETU00001) • NOM Prénom (ETU00002)
        </div>
        <div class="mt-3">
            <a href="#" class="btn btn-sm btn-outline-secondary me-2"><i class="fab fa-github"></i> Repo GIT</a>
            <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fas fa-tasks"></i> Liste des tâches</a>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Logique -->
    <script>
        // Gestion du basculement Admin / Client
        function switchRole(role) {
            const btnClient = document.getElementById('btnClient');
            const btnAdmin = document.getElementById('btnAdmin');
            const clientForm = document.getElementById('clientForm');
            const adminForm = document.getElementById('adminForm');
            const formTitle = document.getElementById('formTitle');

            if (role === 'admin') {
                // Activation UI Admin
                btnAdmin.classList.add('active');
                btnClient.classList.remove('active');
                
                clientForm.classList.add('hidden');
                adminForm.classList.remove('hidden');
                adminForm.classList.add('fade-in');
                
                formTitle.textContent = "Connexion Administrateur";
            } else {
                // Activation UI Client
                btnClient.classList.add('active');
                btnAdmin.classList.remove('active');
                
                adminForm.classList.add('hidden');
                clientForm.classList.remove('hidden');
                clientForm.classList.add('fade-in');
                
                formTitle.textContent = "Connexion Membre";
            }
        }

        // Simulation de connexion (Feedback visuel)
        function handleLogin(e, type) {
            e.preventDefault();
            
            const toastEl = document.getElementById('loginToast');
            const toastBody = document.getElementById('toastMessage');
            const toast = new bootstrap.Toast(toastEl);
            
            // Logique simulée
            if (type === 'admin') {
                const login = document.getElementById('adminLogin').value;
                // Ici on vérifierait normalement contre la BDD
                toastBody.innerHTML = `<i class="fas fa-check-circle me-2"></i> Bienvenue Admin <strong>${login}</strong>. Redirection vers le backoffice...`;
                toastEl.classList.remove('bg-success');
                toastEl.classList.add('bg-primary');
            } else {
                const email = document.getElementById('clientEmail').value;
                toastBody.innerHTML = `<i class="fas fa-check-circle me-2"></i> Connexion réussie pour <strong>${email}</strong>. Bienvenue sur Takalo !`;
                toastEl.classList.remove('bg-primary');
                toastEl.classList.add('bg-success');
            }

            toast.show();

            // Simulation de délai de redirection
            setTimeout(() => {
                console.log(`Tentative de connexion ${type} réussie.`);
                // window.location.href = 'dashboard.php'; // Exemple pour FlightMvc
            }, 2000);
        }
    </script>
</body>
</html>