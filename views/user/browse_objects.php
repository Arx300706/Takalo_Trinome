<!-- Explorer les Objets -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fas fa-search me-2"></i>Explorer les Objets</h4>
</div>

<!-- Filtres -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">Filtrer par catégorie</label>
                <select class="form-select" name="category" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $selectedCategory == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <a href="<?= BASE_URL ?>/explorer" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-1"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<?php if (empty($objects)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3 opacity-25"></i>
        <h5 class="text-muted">Aucun objet trouvé</h5>
        <p class="text-muted">Il n'y a pas d'objets disponibles pour le moment.</p>
    </div>
</div>
<?php else: ?>
<div class="row g-4">
    <?php foreach ($objects as $obj): ?>
    <div class="col-md-4 col-lg-3">
        <div class="card object-card h-100">
            <img src="https://picsum.photos/seed/obj<?= $obj['id'] ?>/400/300" class="card-img-top" alt="<?= htmlspecialchars($obj['title']) ?>">
            <div class="card-body">
                <span class="category-badge mb-2 d-inline-block"><?= htmlspecialchars($obj['category_name'] ?? 'N/A') ?></span>
                <h5 class="card-title mb-1"><?= htmlspecialchars($obj['title']) ?></h5>
                <p class="text-muted small mb-2">
                    <i class="fas fa-user me-1"></i><?= htmlspecialchars(($obj['prenom'] ?? '') . ' ' . ($obj['nom'] ?? '')) ?>
                </p>
                <p class="card-text text-muted small"><?= htmlspecialchars(substr($obj['description'] ?? '', 0, 60)) ?>...</p>
                <div class="price-badge"><?= number_format($obj['estimated_price'] ?? 0, 0, ',', ' ') ?> Ar</div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exchangeModal" 
                        onclick="prepareExchange(<?= $obj['id'] ?>, '<?= htmlspecialchars($obj['title'], ENT_QUOTES) ?>')">
                    <i class="fas fa-exchange-alt me-1"></i>Proposer un échange
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Modal Proposition d'échange -->
<div class="modal fade" id="exchangeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exchange-alt me-2"></i>Proposer un échange</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/echanges/propose">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input type="hidden" name="requested_object_id" id="requestedObjectId">
                    
                    <div class="alert alert-info">
                        <strong>Objet demandé:</strong> <span id="requestedObjectTitle"></span>
                    </div>
                    
                    <?php if (empty($myObjects)): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Vous n'avez aucun objet à proposer. 
                        <a href="<?= BASE_URL ?>/mes-objets">Ajoutez un objet d'abord</a>.
                    </div>
                    <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">Sélectionnez votre objet à échanger *</label>
                        <select class="form-select" name="my_object_id" required>
                            <option value="">Choisir un de mes objets...</option>
                            <?php foreach ($myObjects as $myObj): ?>
                            <?php if ($myObj['status'] === 'available'): ?>
                            <option value="<?= $myObj['id'] ?>">
                                <?= htmlspecialchars($myObj['title']) ?> (<?= number_format($myObj['estimated_price'], 0, ',', ' ') ?> Ar)
                            </option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <?php if (!empty($myObjects)): ?>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i>Envoyer la proposition
                    </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function prepareExchange(objectId, objectTitle) {
    document.getElementById('requestedObjectId').value = objectId;
    document.getElementById('requestedObjectTitle').innerText = objectTitle;
}
</script>
