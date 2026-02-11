<?php
require_once "auth.php";
require_once "config/db.php";

$totalEmployes = $pdo->query("SELECT COUNT(*) FROM employe")->fetchColumn();
$totalServices = $pdo->query("SELECT COUNT(*) FROM service")->fetchColumn();

$parService = $pdo->query("
    SELECT service.nom, COUNT(employe.id) total
    FROM service
    LEFT JOIN employe ON employe.service_id = service.id
    GROUP BY service.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard RH</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

<h3 class="mb-4">📊 Dashboard RH</h3>
<a href="index.php" class="btn btn-outline-primary btn-sm">
            retour
        </a>
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5>👥 Employés</h5>
                <h2><?= $totalEmployes ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5>🏢 Services</h5>
                <h2><?= $totalServices ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <h5>Répartition par service</h5>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Service</th>
                    <th>Employés</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parService as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= $row['total'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</body>
</html>
