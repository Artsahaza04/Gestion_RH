<?php
require_once "auth.php";
require_once "config/db.php";

if ($_SESSION['admin']['role'] !== 'admin') {
    die("⛔ Accès refusé");
}
$id = $_GET['id'] ?? null;

if ($id) {
    $pdo->prepare("UPDATE employe SET service_id=NULL WHERE service_id=?")->execute([$id]);
    $pdo->prepare("DELETE FROM service WHERE id=?")->execute([$id]);
}

header("Location: service.php");
exit;
