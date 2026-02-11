<?php
require_once "config/db.php";
session_start();

// Si déjà connecté → redirection
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$error = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Recherche de l'admin
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    // Vérification mot de passe
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = [
            'username' => $admin['username'],
            'role' => $admin['role']
        ];

        header("Location: index.php");
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="text-center mb-3">🔐 Connexion Admin</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nom d'utilisateur</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">
                    Se connecter
                </button>
            </form>

        </div>
    </div>
</div>

</body>
</html>
