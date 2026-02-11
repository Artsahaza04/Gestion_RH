<?php
require_once "auth.php";

// Connexion à la base
require_once "config/db.php";

// Vérifier si l'id existe
if (isset($_GET['id'])) {

    // Récupérer l'id
    $id = $_GET['id'];

    // Requête de suppression
    $sql = "DELETE FROM conge WHERE id = ?";

    // Préparer et exécuter
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

// Retour à la page congé
header("Location: conge.php");
exit;
