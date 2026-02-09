<!-- Gestion des Utilisateurs -->

<!-- Stat Card -->
<div class="stat-card" style="border-left-color: #10b981;">
    <div class="stat-info">
        <p>Total Utilisateurs</p>
        <h3><?= count($users ?? []) ?></h3>
    </div>
    <div class="stat-icon" style="color: #10b981;">
        <i class="fas fa-users"></i>
    </div>
</div>

<!-- Tableau des utilisateurs -->
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="mt-2">Liste des utilisateurs inscrits</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-users fa-3x mb-3 d-block opacity-25"></i>
                        Aucun utilisateur inscrit
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>#<?= $user['id'] ?></td>
                    <td class="fw-bold text-dark">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['prenom'] . '+' . $user['nom']) ?>&size=32&background=6366f1&color=fff" 
                             class="rounded-circle me-2" alt="">
                        <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
                    </td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['telephone'] ?? '-') ?></td>
                    <td class="small"><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                    <td>
                        <span class="badge bg-<?= ($user['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?>">
                            <?= ($user['status'] ?? 'active') === 'active' ? 'Actif' : 'Inactif' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
