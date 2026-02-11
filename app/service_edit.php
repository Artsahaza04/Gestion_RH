<?php
require_once "auth.php";
require_once "config/db.php";

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM service WHERE id=?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if (!$service) die("Service introuvable");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $pdo->prepare("UPDATE service SET nom=? WHERE id=?")->execute([$nom, $id]);
    header("Location: service.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier service</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4" style="max-width:400px">
    <h4>✏️ Modifier service</h4>

    <form method="post">
        <input class="form-control mb-3" name="nom"
               value="<?= htmlspecialchars($service['nom']) ?>" required>
        <button class="btn btn-primary w-100">Modifier</button>
    </form>
</div>
</body>
</html>
