<!-- Gestion des Catégories -->

<!-- Carte Statistique -->
<div class="stat-card">
    <div class="stat-info">
        <p>Total Catégories</p>
        <h3 id="categoryCount"><?= count($categories ?? []) ?></h3>
    </div>
    <div class="stat-icon">
        <i class="fas fa-layer-group"></i>
    </div>
</div>

<!-- Tableau des catégories -->
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="mt-2">Liste des catégories</h5>
        <button class="btn btn-primary btn-add text-white" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="prepareAdd()">
            <i class="fas fa-plus me-1"></i> Nouvelle catégorie
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la catégorie</th>
                    <th>Description</th>
                    <th>Nb. Objets</th>
                    <th>Date de création</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Aucune catégorie pour le moment
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td>#<?= $cat['id'] ?></td>
                    <td class="fw-bold text-dark"><?= htmlspecialchars($cat['name']) ?></td>
                    <td class="text-muted small"><?= htmlspecialchars($cat['description'] ?? '-') ?></td>
                    <td>
                        <span class="badge bg-primary"><?= $cat['object_count'] ?? 0 ?></span>
                    </td>
                    <td class="small"><?= date('d/m/Y', strtotime($cat['created_at'])) ?></td>
                    <td class="text-end">
                        <button class="btn btn-action btn-edit" onclick="prepareEdit(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($cat['description'] ?? '', ENT_QUOTES) ?>')" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-action btn-delete" onclick="deleteCategory(<?= $cat['id'] ?>)" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Ajout/Modification -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Ajouter une catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input type="hidden" name="id" id="catId">
                    <div class="mb-3">
                        <label class="form-label">Nom de la catégorie *</label>
                        <input type="text" class="form-control" name="name" id="catName" required placeholder="Ex: Vêtements">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="catDesc" rows="3" placeholder="Description de la catégorie..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-add text-white">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form de suppression caché -->
<form id="deleteForm" method="POST" action="<?= BASE_URL ?>/admin/categories/delete" style="display:none;">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <input type="hidden" name="id" id="deleteId">
</form>

<script>
    function prepareAdd() {
        document.getElementById('catId').value = '';
        document.getElementById('catName').value = '';
        document.getElementById('catDesc').value = '';
        document.getElementById('modalTitle').innerText = 'Ajouter une catégorie';
        document.getElementById('categoryForm').action = '<?= BASE_URL ?>/admin/categories/create';
    }

    function prepareEdit(id, name, desc) {
        document.getElementById('catId').value = id;
        document.getElementById('catName').value = name;
        document.getElementById('catDesc').value = desc;
        document.getElementById('modalTitle').innerText = 'Modifier la catégorie';
        document.getElementById('categoryForm').action = '<?= BASE_URL ?>/admin/categories/update';
        
        const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
        modal.show();
    }

    function deleteCategory(id) {
        if(confirm("Êtes-vous sûr de vouloir supprimer cette catégorie ?")) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteForm').submit();
        }
    }
</script>
