<?php
require_once "config/db.php"; // 🔥 OBLIGATOIRE
echo password_hash("rh123", PASSWORD_DEFAULT);
// creee mot de pass
// password_hash("nouveau_mot_de_passe", PASSWORD_DEFAULT)
// password admin: password
// $password rh:rh123

// 1️⃣ Mamorona hash vaovao (PHP)

// Ouvre phpMyAdmin → SQL ary exécute :

// UPDATE admin
// SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2...'
// WHERE username = 'admin';
// 🔹 Charger les services pour le filtre
$sqlServices = "SELECT id, nom FROM service ORDER BY nom";
$stmtServices = $pdo->prepare($sqlServices);
$stmtServices->execute();
$services = $stmtServices->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($services);
echo '</pre>';
exit;
