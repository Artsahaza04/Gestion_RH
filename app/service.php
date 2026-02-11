<?php
require_once "auth.php";
require_once "config/db.php";

$stmt = $pdo->query("SELECT * FROM service ORDER BY nom");
$services = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Services</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h4>🏢 Services</h4>
        <a href="index.php" class="btn btn-outline-dark btn-sm">
            retour
        </a>
        <a href="service_add.php" class="btn btn-success btn-sm">➕ Ajouter</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['nom']) ?></td>
                <td>
                    <a href="service_edit.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">✏️</a>
                    <?php if ($_SESSION['admin']['role'] === 'admin'): ?>
                        <a href="service_delete.php?id=<?= $s['id'] ?>"
                        class="btn btn-outline-danger btn-sm"
                        onclick="return confirm('Supprimer cet service ?')">
                        🗑️
                        </a>
                    <?php endif; ?>
                    <!-- <a href="service_delete.php?id=<?= $s['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Supprimer ce service ?')">🗑️</a> -->
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>
