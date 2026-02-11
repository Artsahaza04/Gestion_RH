<?php
require_once "auth.php";
require_once "config/db.php";

// Seul l'admin peut supprimer
if ($_SESSION['admin']['role'] !== 'admin') {
    die("⛔ Accès refusé");
}

// Vérifier l'id
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Supprimer l'employé
$sql = "DELETE FROM employe WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Retour à la liste
header("Location: index.php");
exit;
