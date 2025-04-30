<?php
session_start();
require 'db_connect.php';

// Vérification accès admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: inscription.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_prenom = trim($_POST['nom_prenom']);
    $email = trim($_POST['email']);
    $mdp = trim($_POST['mdp']); 
    $role = $_POST['role'];
    $gender = $_POST['gender'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO compte (nom_prenom, email, mdp, role, gender, created_at) 
            VALUES (:nom_prenom, :email, :mdp, :role, :gender, NOW())
        ");
        $stmt->execute([
            ':nom_prenom' => $nom_prenom,
            ':email' => $email,
            ':mdp' => $mdp,
            ':role' => $role,
            ':gender' => $gender
        ]);
        header('Location: utilisateur.php?success=1');
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1>Ajouter un Utilisateur</h1>
        <form method="post">
            <div class="mb-3">
                <label>Nom Prénom</label>
                <input type="text" name="nom_prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="mdp" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label>Genre</label>
                <select name="gender" class="form-control" required>
                    <option value="">Sélectionner</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Rôle</label>
                <select name="role" class="form-control" required>
                    <option value="">Sélectionner</option>
                    <option value="eleve">Élève</option>
                    <option value="prof">Professeur</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="utilisateur.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
