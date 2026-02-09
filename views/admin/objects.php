<!-- Gestion des Objets - Admin -->

<!-- Stat Card -->
<div class="stat-card" style="border-left-color: #f59e0b;">
    <div class="stat-info">
        <p>Total Objets</p>
        <h3><?= count($objects ?? []) ?></h3>
    </div>
    <div class="stat-icon" style="color: #f59e0b;">
        <i class="fas fa-box-open"></i>
    </div>
</div>

<!-- Tableau des objets -->
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="mt-2">Liste des objets sur la plateforme</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Propriétaire</th>
                    <th>Prix estimé</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($objects)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-box-open fa-3x mb-3 d-block opacity-25"></i>
                        Aucun objet enregistré
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($objects as $obj): ?>
                <tr>
                    <td>#<?= $obj['id'] ?></td>
                    <td class="fw-bold text-dark"><?= htmlspecialchars($obj['title']) ?></td>
                    <td>
                        <span class="badge bg-light text-primary"><?= htmlspecialchars($obj['category_name'] ?? 'N/A') ?></span>
                    </td>
                    <td><?= htmlspecialchars(($obj['prenom'] ?? '') . ' ' . ($obj['nom'] ?? '')) ?></td>
                    <td class="fw-bold"><?= number_format($obj['estimated_price'] ?? 0, 0, ',', ' ') ?> Ar</td>
                    <td>
                        <?php 
                        $statusColors = [
                            'available' => 'success',
                            'exchanged' => 'info',
                            'unavailable' => 'secondary'
                        ];
                        $statusLabels = [
                            'available' => 'Disponible',
                            'exchanged' => 'Échangé',
                            'unavailable' => 'Indisponible'
                        ];
                        $status = $obj['status'] ?? 'available';
                        ?>
                        <span class="badge bg-<?= $statusColors[$status] ?? 'secondary' ?>">
                            <?= $statusLabels[$status] ?? $status ?>
                        </span>
                    </td>
                    <td class="small"><?= date('d/m/Y', strtotime($obj['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
