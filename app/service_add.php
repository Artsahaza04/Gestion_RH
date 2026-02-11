<?php
require_once "auth.php";
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);

    if ($nom) {
        $stmt = $pdo->prepare("INSERT INTO service (nom) VALUES (?)");
        $stmt->execute([$nom]);
        header("Location: service.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter service</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4" style="max-width:400px">
    <h4>➕ Ajouter un service</h4>
    
    <form method="post">
        <input class="form-control mb-3" name="nom" placeholder="Nom du service" required>
        <button class="btn btn-success w-100">Enregistrer</button>
    </form>
</div>
</body>
</html>
