<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice Admin | Takalo-Takalo</title>
    
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
            min-height: calc(100vh - 35px); /* Hauteur totale - bandeau */
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
            margin-bottom: 30px;
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
    </style>
</head>
<body>

    <!-- Bandeau Révision -->
    <div class="revision-banner">
        REVISION – Février 2026– P18/P5DS | Backoffice Administration
    </div>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-sync-alt me-2"></i>Takalo</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
                </li>
                <li>
                    <a href="#" class="active"><i class="fas fa-tags"></i> Catégories</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-box-open"></i> Objets</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-users"></i> Utilisateurs</a>
                </li>
                <li>
                    <a href="index.html" class="text-danger mt-5"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            
            <!-- En-tête avec bouton toggle pour mobile (optionnel) -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Gestion des Catégories</h2>
                <div class="user-profile d-flex align-items-center">
                    <span class="me-2 text-muted">Admin</span>
                    <img src="https://picsum.photos/seed/admin/40/40" class="rounded-circle" alt="Admin">
                </div>
            </div>

            <!-- Carte Statistique (Le nombre de catégories) -->
            <div class="stat-card">
                <div class="stat-info">
                    <p>Total Catégories</p>
                    <h3 id="categoryCount">0</h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>

            <!-- Zone de gestion (Tableau) -->
            <div class="table-container">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="mt-2">Liste des catégories</h5>
                    <div>
                        <button class="btn btn-light text-secondary me-2" onclick="renderCategories()">
                            <i class="fas fa-sync-alt"></i> Afficher tous
                        </button>
                        <button class="btn btn-primary btn-add text-white" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="prepareAdd()">
                            <i class="fas fa-plus me-1"></i> Nouvelle
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de la catégorie</th>
                                <th>Description</th>
                                <th>Date de création</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            <!-- Les lignes seront générées par JS -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Projet Takalo-Takalo | Backend Admin</p>
        <p class="small text-muted">Équipe P18/P5DS | Nom Prénom (ETU...) | Nom Prénom (ETU...)</p>
    </footer>

    <!-- Modal Ajout/Modification -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Ajouter une catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        <input type="hidden" id="catId">
                        <div class="mb-3">
                            <label class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control" id="catName" required placeholder="Ex: Vêtements">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="catDesc" rows="3" placeholder="Détails..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-add text-white" onclick="saveCategory()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // --- 1. Données de test (Simulant la BDD) ---
        let categories = [
            { id: 1, name: "Vêtements", desc: "Hauts, bas, chaussures et accessoires.", date: "2025-10-01" },
            { id: 2, name: "Livres", desc: "Romans, mangas, manuels scolaires.", date: "2025-10-02" },
            { id: 3, name: "High-Tech", desc: "Téléphones, ordinateurs, consoles.", date: "2025-10-05" },
            { id: 4, name: "Meubles", desc: "Chaises, tables, décoration maison.", date: "2025-10-06" },
            { id: 5, name: "Sports & Loisirs", desc: "Vélos, équipements de fitness.", date: "2025-10-10" }
        ];

        // --- 2. Initialisation ---
        document.addEventListener('DOMContentLoaded', () => {
            renderCategories();
        });

        // --- 3. Fonctions d'affichage ---
        
        // Afficher tous et mettre à jour le compteur
        function renderCategories() {
            const tbody = document.getElementById('categoryTableBody');
            tbody.innerHTML = ''; // Vider le tableau

            categories.forEach(cat => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>#${cat.id}</td>
                    <td class="fw-bold text-dark">${cat.name}</td>
                    <td class="text-muted small">${cat.desc}</td>
                    <td class="small">${cat.date}</td>
                    <td class="text-end">
                        <button class="btn btn-action btn-edit" onclick="prepareEdit(${cat.id})" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-action btn-delete" onclick="deleteCategory(${cat.id})" title="Effacer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            updateCount();
        }

        // Mettre à jour le nombre de catégories dans la carte statistique
        function updateCount() {
            const count = categories.length;
            // Animation simple du chiffre
            const counterElement = document.getElementById('categoryCount');
            counterElement.innerText = count;
            
            // Petit effet visuel si le nombre change
            counterElement.style.transform = "scale(1.2)";
            setTimeout(() => counterElement.style.transform = "scale(1)", 200);
        }

        // --- 4. Gestion des Actions ---

        // EFFACER
        function deleteCategory(id) {
            if(confirm("Êtes-vous sûr de vouloir supprimer cette catégorie ?")) {
                // Filtrer le tableau pour retirer l'élément
                categories = categories.filter(c => c.id !== id);
                renderCategories();
                showToast("Catégorie supprimée avec succès", "danger");
            }
        }

        // PRÉPARER MODIFICATION (Ouvrir modal avec données)
        function prepareEdit(id) {
            const cat = categories.find(c => c.id === id);
            if(cat) {
                document.getElementById('catId').value = cat.id;
                document.getElementById('catName').value = cat.name;
                document.getElementById('catDesc').value = cat.desc;
                document.getElementById('modalTitle').innerText = "Modifier la catégorie";
                
                const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
                modal.show();
            }
        }

        // PRÉPARER AJOUT (Vider modal)
        function prepareAdd() {
            document.getElementById('catId').value = '';
            document.getElementById('categoryForm').reset();
            document.getElementById('modalTitle').innerText = "Ajouter une catégorie";
        }

        // SAUVEGARDER (Ajout ou Modif)
        function saveCategory() {
            const id = document.getElementById('catId').value;
            const name = document.getElementById('catName').value;
            const desc = document.getElementById('catDesc').value;

            if(!name) {
                alert("Le nom est obligatoire");
                return;
            }

            if (id) {
                // Mode Modification
                const index = categories.findIndex(c => c.id == id);
                if (index !== -1) {
                    categories[index].name = name;
                    categories[index].desc = desc;
                    showToast("Catégorie modifiée !", "primary");
                }
            } else {
                // Mode Ajout
                const newId = categories.length > 0 ? Math.max(...categories.map(c => c.id)) + 1 : 1;
                const today = new Date().toISOString().split('T')[0];
                categories.push({
                    id: newId,
                    name: name,
                    desc: desc,
                    date: today
                });
                showToast("Nouvelle catégorie ajoutée !", "success");
            }

            // Fermer le modal manuellement
            const modalEl = document.getElementById('categoryModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            renderCategories();
        }

        // Utilitaire pour afficher un message (Toast) sans utiliser l'alert natif moche
        function showToast(message, colorType) {
            // Création dynamique d'un toast
            const toastContainer = document.createElement('div');
            toastContainer.style.position = 'fixed';
            toastContainer.style.top = '20px';
            toastContainer.style.right = '20px';
            toastContainer.style.zIndex = '1060';
            
            let bgClass = colorType === 'danger' ? 'bg-danger' : (colorType === 'primary' ? 'bg-primary' : 'bg-success');
            
            toastContainer.innerHTML = `
                <div class="toast align-items-center text-white ${bgClass} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toastContainer);
            
            // Supprimer après 3 secondes
            setTimeout(() => {
                toastContainer.remove();
            }, 3000);
        }
    </script>
</body>
</html>