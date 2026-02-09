<!-- Mes Échanges -->
<div class="mb-4">
    <h4><i class="fas fa-exchange-alt me-2"></i>Mes Échanges</h4>
</div>

<!-- Nav Tabs -->
<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#received" type="button">
            <i class="fas fa-inbox me-1"></i>Reçues 
            <span class="badge bg-primary"><?= count($receivedProposals ?? []) ?></span>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sent" type="button">
            <i class="fas fa-paper-plane me-1"></i>Envoyées
            <span class="badge bg-secondary"><?= count($sentProposals ?? []) ?></span>
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <!-- Propositions Reçues -->
    <div class="tab-pane fade show active" id="received">
        <?php if (empty($receivedProposals)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucune proposition reçue</h5>
                <p class="text-muted">Vous n'avez pas encore reçu de propositions d'échange.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($receivedProposals as $prop): ?>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars(($prop['proposer_prenom'] ?? '') . ' ' . ($prop['proposer_nom'] ?? '')) ?>
                        </span>
                        <span class="badge bg-<?= $prop['status'] === 'pending' ? 'warning' : ($prop['status'] === 'accepted' ? 'success' : 'secondary') ?>">
                            <?= $prop['status'] === 'pending' ? 'En attente' : ($prop['status'] === 'accepted' ? 'Accepté' : 'Refusé') ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-5 text-center">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-box fa-2x text-primary mb-2"></i>
                                    <p class="mb-0 fw-bold small"><?= htmlspecialchars($prop['proposer_object_title'] ?? '') ?></p>
                                    <small class="text-muted"><?= number_format($prop['proposer_object_price'] ?? 0, 0, ',', ' ') ?> Ar</small>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <i class="fas fa-exchange-alt fa-2x text-muted"></i>
                            </div>
                            <div class="col-5 text-center">
                                <div class="p-3 bg-primary bg-opacity-10 rounded">
                                    <i class="fas fa-box fa-2x text-success mb-2"></i>
                                    <p class="mb-0 fw-bold small"><?= htmlspecialchars($prop['requested_object_title'] ?? '') ?></p>
                                    <small class="text-muted"><?= number_format($prop['requested_object_price'] ?? 0, 0, ',', ' ') ?> Ar</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($prop['status'] === 'pending'): ?>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex gap-2">
                            <form method="POST" action="<?= BASE_URL ?>/echanges/accept" class="flex-fill">
                                <input type="hidden" name="exchange_id" value="<?= $prop['id'] ?>">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-1"></i>Accepter
                                </button>
                            </form>
                            <form method="POST" action="<?= BASE_URL ?>/echanges/refuse" class="flex-fill">
                                <input type="hidden" name="exchange_id" value="<?= $prop['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-times me-1"></i>Refuser
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Propositions Envoyées -->
    <div class="tab-pane fade" id="sent">
        <?php if (empty($sentProposals)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-paper-plane fa-4x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucune proposition envoyée</h5>
                <p class="text-muted">Vous n'avez pas encore proposé d'échange.</p>
                <a href="<?= BASE_URL ?>/explorer" class="btn btn-primary">Explorer les objets</a>
            </div>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($sentProposals as $prop): ?>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            <i class="fas fa-user me-1"></i>À <?= htmlspecialchars(($prop['owner_prenom'] ?? '') . ' ' . ($prop['owner_nom'] ?? '')) ?>
                        </span>
                        <span class="badge bg-<?= $prop['status'] === 'pending' ? 'warning' : ($prop['status'] === 'accepted' ? 'success' : 'danger') ?>">
                            <?= $prop['status'] === 'pending' ? 'En attente' : ($prop['status'] === 'accepted' ? 'Accepté' : 'Refusé') ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-5 text-center">
                                <div class="p-3 bg-primary bg-opacity-10 rounded">
                                    <i class="fas fa-box fa-2x text-primary mb-2"></i>
                                    <p class="mb-0 fw-bold small"><?= htmlspecialchars($prop['proposer_object_title'] ?? '') ?></p>
                                    <small class="text-muted">Mon objet</small>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <i class="fas fa-arrow-right fa-2x text-muted"></i>
                            </div>
                            <div class="col-5 text-center">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-box fa-2x text-success mb-2"></i>
                                    <p class="mb-0 fw-bold small"><?= htmlspecialchars($prop['requested_object_title'] ?? '') ?></p>
                                    <small class="text-muted">Demandé</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Proposé le <?= date('d/m/Y à H:i', strtotime($prop['created_at'])) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
