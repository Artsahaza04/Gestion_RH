<?php
require_once "auth.php";

// Connexion à la base de données
require_once "config/db.php";

// Vérifier si l'id du congé est passé dans l'URL
if (!isset($_GET['id'])) {
    // Si pas d'id → retour à la liste
    header("Location: conge.php");
    exit;
}

// Récupérer l'id du congé
$id = $_GET['id'];

/* =========================
   1️⃣ RÉCUPÉRER LE CONGÉ
========================= */

// Préparer la requête
$sql = "SELECT * FROM conge WHERE id = ?";

// Exécuter la requête
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Récupérer les données
$conge = $stmt->fetch();

// Si aucun congé trouvé
if (!$conge) {
    echo "Congé introuvable";
    exit;
}

/* =========================
   2️⃣ MODIFICATION DU CONGÉ
========================= */

// Si le formulaire est envoyé
if (isset($_POST['date_debut'], $_POST['date_fin'])) {

    $date_debut = $_POST['date_debut'];
    $date_fin   = $_POST['date_fin'];

    // Requête de mise à jour
    $sql = "UPDATE conge 
            SET date_debut = ?, date_fin = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$date_debut, $date_fin, $id]);

    // Retour vers la liste des congés
    header("Location: conge.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier congé</title>
</head>
<body>

<h2>Modifier le congé</h2>

<!-- Formulaire de modification -->
<form method="post">

    <!-- Date début -->
    <label>Date début :</label><br>
    <input type="date" name="date_debut"
           value="<?= $conge['date_debut'] ?>" required><br><br>

    <!-- Date fin -->
    <label>Date fin :</label><br>
    <input type="date" name="date_fin"
           value="<?= $conge['date_fin'] ?>" required><br><br>

    <!-- Bouton -->
    <button type="submit">💾 Enregistrer</button>
</form>

<br>

<!-- Retour -->
<a href="conge.php">⬅ Retour à la liste</a>

</body>
</html>
