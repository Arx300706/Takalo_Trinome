<!-- Dashboard Admin -->
<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <p>Catégories</p>
                <h3><?= $stats['categories'] ?? 0 ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #10b981;">
            <div class="stat-info">
                <p>Utilisateurs</p>
                <h3><?= $stats['users'] ?? 0 ?></h3>
            </div>
            <div class="stat-icon" style="color: #10b981;">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #f59e0b;">
            <div class="stat-info">
                <p>Objets</p>
                <h3><?= $stats['objects'] ?? 0 ?></h3>
            </div>
            <div class="stat-icon" style="color: #f59e0b;">
                <i class="fas fa-box-open"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #ec4899;">
            <div class="stat-info">
                <p>Échanges</p>
                <h3><?= $stats['exchanges'] ?? 0 ?></h3>
            </div>
            <div class="stat-icon" style="color: #ec4899;">
                <i class="fas fa-exchange-alt"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="table-container">
    <h5 class="mb-4"><i class="fas fa-bolt me-2"></i>Actions Rapides</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-outline-primary w-100 py-3">
                <i class="fas fa-tags fa-2x mb-2 d-block"></i>
                Gérer les Catégories
            </a>
        </div>
        <div class="col-md-4">
            <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-success w-100 py-3">
                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                Gérer les Utilisateurs
            </a>
        </div>
        <div class="col-md-4">
            <a href="<?= BASE_URL ?>/admin/objects" class="btn btn-outline-warning w-100 py-3">
                <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                Voir les Objets
            </a>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="alert alert-info mt-4">
    <h5><i class="fas fa-info-circle me-2"></i>Bienvenue sur le Backoffice</h5>
    <p class="mb-0">
        Vous êtes connecté en tant qu'administrateur. Utilisez le menu de gauche pour gérer les catégories, 
        utilisateurs et objets de la plateforme <?= APP_NAME ?>.
    </p>
</div>
