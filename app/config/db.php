<?php
$host = "localhost";
$port = "3307";      //  MySQL est sur 3307
$dbname = "gestion_rh";
$username = "root";
$password = "";     // vide par défaut avec XAMPP

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
