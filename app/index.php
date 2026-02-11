<?php
require_once "auth.php";

// Inclusion du fichier de connexion à la base de données
require_once "config/db.php";

// 🔹 Charger les services pour le filtre
$sqlServices = "SELECT id, nom FROM service ORDER BY nom";
$stmtServices = $pdo->prepare($sqlServices);
$stmtServices->execute();
$services = $stmtServices->fetchAll(PDO::FETCH_ASSOC);

$where = [];
$params = [];

// 🔍 Recherche texte
if (isset($_GET['q']) && trim($_GET['q']) !== '') {
    $q = '%' . $_GET['q'] . '%';
    $where[] = "(employe.nom LIKE ? OR employe.prenom LIKE ? OR employe.email LIKE ?)";
    $params[] = $q;
    $params[] = $q;
    $params[] = $q;
}



// 🏢 Filtre service
if (!empty($_GET['service'])) {
    $where[] = "employe.service_id = ?";
    $params[] = $_GET['service'];
}

// 🔹 Requête principale
$sql = "
SELECT 
    employe.id,
    employe.nom,
    employe.prenom,
    employe.email,
    service.nom AS service
FROM employe
LEFT JOIN service ON employe.service_id = service.id
";

// 🔹 Ajout WHERE si nécessaire
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// 🔹 Exécution
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Requête SQL pour récupérer les employés et leur service
$sql = "
    SELECT 
        employe.id,
        employe.nom,
        employe.prenom,
        employe.email,
        service.nom AS service
    FROM employe
    LEFT JOIN service ON employe.service_id = service.id
";

// Préparation de la requête SQL (sécurité et performance)
$stmt = $pdo->prepare($sql);

// Exécution de la requête
$stmt->execute();
// 🔹 Récupérer les services pour le filtre

// Récupération de tous les résultats sous forme de tableau associatif
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion RH – Employés</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- 🔹 NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">💼 Gestion RH</span>

        <div>
            <a href="employe_add.php" class="btn btn-success btn-sm me-2">
                ➕ Ajouter
            </a>

            <a href="conge.php" class="btn btn-outline-light btn-sm">
                📅 Congés
            </a>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">
                📊 Dashboard
            </a>
            <a href="service.php" class="btn btn-outline-light btn-sm">
                service
            </a>
            <a href="logout.php" class="btn btn-danger btn-sm me-2">
                deconnecter
            </a>

        </div>
    </div>
</nav>

 <!-- 🔍 RECHERCHE & FILTRES -->
            <form method="get" class="row g-2 mb-4">

                <div class="col-md-4">
                    <input type="text"
                           name="q"
                           class="form-control"
                           placeholder="🔍 Rechercher (nom, prénom, email)"
                           value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <select name="service" class="form-select">
                        <option value="">Tous les services</option>

                        <?php foreach ($services as $s): ?>
                            <option value="<?= $s['id'] ?>"
                                <?= (($_GET['service'] ?? '') == $s['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Filtrer
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="index.php" class="btn btn-secondary w-100">
                        Réinitialiser
                    </a>
                </div>
            </form>


<!-- 🔹 CONTENU -->
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-body">

            <h4 class="card-title mb-3">Liste des employés</h4>

            <?php if (!empty($employes)): ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($employes as $employe): ?>
                            <tr>
                                <td><?= htmlspecialchars($employe['nom']) ?></td>
                                <td><?= htmlspecialchars($employe['prenom']) ?></td>
                                <td><?= htmlspecialchars($employe['email']) ?></td>
                                <td><?= htmlspecialchars($employe['service'] ?? 'Non affecté') ?></td>

                                <!-- 🔹 ACTIONS -->
                                <td class="text-center">
                                    <a href="employe_edit.php?id=<?= $employe['id'] ?>"
                                       class="btn btn-outline-primary btn-sm me-1"
                                       title="Modifier">
                                        ✏️
                                    </a>

                                    <?php if ($_SESSION['admin']['role'] === 'admin'): ?>
                                        <a href="employe_delete.php?id=<?= $employe['id'] ?>"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Supprimer cet employé ?')">
                                            🗑️
                                        </a>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

            <?php else: ?>

                <div class="alert alert-warning text-center">
                    Aucun employé trouvé.
                </div>

            <?php endif; ?>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

