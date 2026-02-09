<!-- Dashboard Utilisateur -->
<div class="row g-4 mb-4">
    <!-- Bienvenue -->
    <div class="col-12">
        <div class="card bg-gradient" style="background: linear-gradient(135deg, #6366f1, #a855f7);">
            <div class="card-body text-white py-4">
                <h2 class="mb-1">Bienvenue, <?= $_SESSION['user_name'] ?? 'Utilisateur' ?> 👋</h2>
                <p class="mb-0 opacity-75">Prêt à échanger vos objets sur Takalo-Takalo ?</p>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                    <i class="fas fa-box fa-2x text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?= $myObjectsCount ?? 0 ?></h3>
                    <p class="text-muted mb-0">Mes Objets</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?= $pendingExchanges ?? 0 ?></h3>
                    <p class="text-muted mb-0">Échanges en attente</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="fas fa-exchange-alt fa-2x text-success"></i>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>/explorer" class="text-decoration-none">
                        <h5 class="mb-0 text-dark">Explorer</h5>
                        <p class="text-muted mb-0 small">Voir les objets disponibles</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>/mes-objets" class="btn btn-outline-primary">
                        <i class="fas fa-box me-2"></i>Gérer mes objets
                    </a>
                    <a href="<?= BASE_URL ?>/explorer" class="btn btn-outline-success">
                        <i class="fas fa-search me-2"></i>Explorer les objets
                    </a>
                    <a href="<?= BASE_URL ?>/mes-echanges" class="btn btn-outline-warning">
                        <i class="fas fa-exchange-alt me-2"></i>Voir mes échanges
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-info"></i>Comment ça marche ?</h5>
            </div>
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">1</div>
                    <p class="mb-0">Ajoutez vos objets à échanger</p>
                </div>
                <div class="d-flex mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">2</div>
                    <p class="mb-0">Parcourez les objets des autres</p>
                </div>
                <div class="d-flex mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">3</div>
                    <p class="mb-0">Proposez un échange</p>
                </div>
                <div class="d-flex">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">✓</div>
                    <p class="mb-0">Échangez vos objets !</p>
                </div>
            </div>
        </div>
    </div>
</div>
