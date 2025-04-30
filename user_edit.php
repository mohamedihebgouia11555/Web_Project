<?php
session_start();
require 'db_connect.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: inscription.php');
    exit;
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Récupération des informations de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM compte WHERE id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Utilisateur non trouvé");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des nouvelles valeurs
        $nom_prenom = $_POST['nom_prenom'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];

        // Mise à jour des informations de l'utilisateur
        $updateStmt = $pdo->prepare("
            UPDATE compte SET 
                nom_prenom = :nom_prenom,
                email = :email,
                role = :role,
                gender = :gender
            WHERE id = :id
        ");
        $updateStmt->bindParam(':nom_prenom', $nom_prenom);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':role', $role);
        $updateStmt->bindParam(':gender', $gender);
        $updateStmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            // Redirection vers la page des utilisateurs après la mise à jour
            header("Location: utilisateur.php");
            exit;
        } else {
            echo "Erreur lors de la mise à jour de l'utilisateur.";
        }
    }
} else {
    die("Aucun ID d'utilisateur spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier l'utilisateur</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nom_prenom" class="form-label">Nom et Prénom</label>
                <input type="text" class="form-control" id="nom_prenom" name="nom_prenom" value="<?= htmlspecialchars($user['nom_prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="prof" <?= $user['role'] === 'prof' ? 'selected' : '' ?>>Professeur</option>
                    <option value="eleve" <?= $user['role'] === 'eleve' ? 'selected' : '' ?>>Élève</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Genre</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Homme" <?= $user['gender'] === 'Homme' ? 'selected' : '' ?>>Homme</option>
                    <option value="Femme" <?= $user['gender'] === 'Femme' ? 'selected' : '' ?>>Femme</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
