<!-- Mes Objets -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fas fa-box me-2"></i>Mes Objets</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#objectModal" onclick="prepareAdd()">
        <i class="fas fa-plus me-1"></i> Ajouter un objet
    </button>
</div>

<?php if (empty($objects)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3 opacity-25"></i>
        <h5 class="text-muted">Aucun objet pour le moment</h5>
        <p class="text-muted mb-3">Commencez par ajouter des objets à échanger</p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#objectModal" onclick="prepareAdd()">
            <i class="fas fa-plus me-1"></i> Ajouter mon premier objet
        </button>
    </div>
</div>
<?php else: ?>
<div class="row g-4">
    <?php foreach ($objects as $obj): ?>
    <div class="col-md-4">
        <div class="card object-card h-100">
            <img src="https://picsum.photos/seed/obj<?= $obj['id'] ?>/400/300" class="card-img-top" alt="<?= htmlspecialchars($obj['title']) ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="category-badge"><?= htmlspecialchars($obj['category_name'] ?? 'N/A') ?></span>
                    <span class="badge bg-<?= $obj['status'] === 'available' ? 'success' : 'secondary' ?>">
                        <?= $obj['status'] === 'available' ? 'Disponible' : 'Échangé' ?>
                    </span>
                </div>
                <h5 class="card-title"><?= htmlspecialchars($obj['title']) ?></h5>
                <p class="card-text text-muted small"><?= htmlspecialchars(substr($obj['description'] ?? '', 0, 80)) ?>...</p>
                <div class="price-badge mb-3"><?= number_format($obj['estimated_price'], 0, ',', ' ') ?> Ar</div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <div class="btn-group w-100">
                    <button class="btn btn-outline-primary btn-sm" onclick="prepareEdit(<?= htmlspecialchars(json_encode($obj)) ?>)">
                        <i class="fas fa-edit me-1"></i>Modifier
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteObject(<?= $obj['id'] ?>)">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Modal Ajout/Modification -->
<div class="modal fade" id="objectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Ajouter un objet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="objectForm" method="POST" action="<?= BASE_URL ?>/objets/create" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input type="hidden" name="id" id="objId">
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Titre de l'objet *</label>
                            <input type="text" class="form-control" name="title" id="objTitle" required placeholder="Ex: Vélo VTT Rockrider">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Catégorie *</label>
                            <select class="form-select" name="category_id" id="objCategory" required>
                                <option value="">Choisir...</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="objDesc" rows="3" placeholder="Décrivez votre objet en détail..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prix estimatif (Ar)</label>
                            <input type="number" class="form-control" name="estimated_price" id="objPrice" min="0" placeholder="Ex: 50000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Photos</label>
                            <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                            <small class="text-muted">Max 5 images, 5MB chacune</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form de suppression -->
<form id="deleteForm" method="POST" action="<?= BASE_URL ?>/objets/delete" style="display:none;">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <input type="hidden" name="id" id="deleteId">
</form>

<script>
function prepareAdd() {
    document.getElementById('objId').value = '';
    document.getElementById('objectForm').reset();
    document.getElementById('modalTitle').innerText = 'Ajouter un objet';
    document.getElementById('objectForm').action = '<?= BASE_URL ?>/objets/create';
}

function prepareEdit(obj) {
    document.getElementById('objId').value = obj.id;
    document.getElementById('objTitle').value = obj.title;
    document.getElementById('objCategory').value = obj.category_id;
    document.getElementById('objDesc').value = obj.description || '';
    document.getElementById('objPrice').value = obj.estimated_price || 0;
    document.getElementById('modalTitle').innerText = 'Modifier l\'objet';
    document.getElementById('objectForm').action = '<?= BASE_URL ?>/objets/update';
    
    const modal = new bootstrap.Modal(document.getElementById('objectModal'));
    modal.show();
}

function deleteObject(id) {
    if(confirm("Supprimer cet objet ?")) {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteForm').submit();
    }
}
</script>
