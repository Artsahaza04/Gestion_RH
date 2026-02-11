<?php
require_once "auth.php";
require_once "config/db.php";

/* =========================
   ID EMPLOYÉ
   ========================= */
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

/* =========================
   MODIFICATION
   ========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $email      = $_POST['email'];
    $service_id = $_POST['service_id'];

    // ✅ CORRECTION service_id
    $sql = "UPDATE employe 
            SET nom = ?, prenom = ?, email = ?, service_id = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $service_id, $id]);

    header("Location: index.php");
    exit;
}

/* =========================
   DONNÉES EMPLOYÉ
   ========================= */
$stmt = $pdo->prepare("SELECT * FROM employe WHERE id = ?");
$stmt->execute([$id]);
$employe = $stmt->fetch();

if (!$employe) {
    header("Location: index.php");
    exit;
}

/* =========================
   SERVICES
   ========================= */
$services = $pdo->query("SELECT id, nom FROM service")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width:600px;">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-3">✏️ Modifier employé</h4>

            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= htmlspecialchars($employe['nom']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control"
                           value="<?= htmlspecialchars($employe['prenom']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($employe['email']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Service</label>
                    <select name="service_id" class="form-select">
                        <?php foreach ($services as $s): ?>
                            <option value="<?= $s['id'] ?>"
                                <?= $s['id'] == $employe['service_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary">Mettre à jour</button>
                <a href="index.php" class="btn btn-secondary">Annuler</a>

            </form>

        </div>
    </div>
</div>

</body>
</html>
