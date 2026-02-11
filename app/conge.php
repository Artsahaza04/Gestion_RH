<?php
require_once "auth.php";

// Connexion à la base de données
require_once "config/db.php";

/* =========================
   1. AJOUT D’UN CONGÉ
   ========================= */
if (isset($_POST['ajouter'])) {

    // Récupération des données du formulaire
    $employe_id = $_POST['employe_id'];
    $date_debut = $_POST['date_debut'];
    $date_fin   = $_POST['date_fin'];

    // Requête SQL pour insérer un congé
    $sql = "INSERT INTO conge (employe_id, date_debut, date_fin)
            VALUES (?, ?, ?)";

    // Préparation de la requête
    $stmt = $pdo->prepare($sql);

    // Exécution sécurisée
    $stmt->execute([$employe_id, $date_debut, $date_fin]);

    // Redirection pour éviter le double envoi
    header("Location: conge.php");
    exit;
}

/* =========================
   2. RÉCUPÉRER LES CONGÉS
   ========================= */
$sql = "
    SELECT 
        conge.id,
        employe.nom,
        employe.prenom,
        conge.date_debut,
        conge.date_fin
    FROM conge
    JOIN employe ON conge.employe_id = employe.id
";

$conges = $pdo->query($sql)->fetchAll();

/* =========================
   3. RÉCUPÉRER LES EMPLOYÉS
   ========================= */
$employes = $pdo->query("SELECT id, nom, prenom FROM employe")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des congés</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- 🔹 NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">📅 Gestion des congés</span>

        <a href="index.php" class="btn btn-outline-light btn-sm">
            retour
        </a>
    </div>
</nav>

<!-- 🔹 CONTENU -->
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-body">

            <!-- Bouton ajouter -->
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAjout">
                    ➕ Ajouter un congé
                </button>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Employé</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($conges as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['nom'].' '.$c['prenom']) ?></td>
                            <td><?= htmlspecialchars($c['date_debut']) ?></td>
                            <td><?= htmlspecialchars($c['date_fin']) ?></td>

                            <!-- Actions -->
                            <td class="text-center" style="white-space: nowrap;">
                                <a href="conge_edit.php?id=<?= $c['id'] ?>"
                                   title="Modifier"
                                   class="text-decoration-none me-2">
                                    ✏️
                                </a>

                                <a href="conge_delete.php?id=<?= $c['id'] ?>"
                                   title="Supprimer"
                                   class="text-decoration-none"
                                   onclick="return confirm('Supprimer ce congé ?')">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- 🔹 MODAL AJOUT -->
<div class="modal fade" id="modalAjout" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post">

                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un congé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Employé -->
                    <div class="mb-3">
                        <label class="form-label">Employé</label>
                        <select name="employe_id" class="form-select" required>
                            <?php foreach ($employes as $e): ?>
                                <option value="<?= $e['id'] ?>">
                                    <?= htmlspecialchars($e['nom'].' '.$e['prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dates -->
                    <div class="mb-3">
                        <label class="form-label">Date début</label>
                        <input type="date" name="date_debut" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date fin</label>
                        <input type="date" name="date_fin" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit"
                            name="ajouter"
                            class="btn btn-primary">
                        Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

