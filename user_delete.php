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

    try {
        // Suppression de l'utilisateur
        $deleteQuery = $pdo->prepare("DELETE FROM compte WHERE id = :id");
        $deleteQuery->bindValue(':id', $userId, PDO::PARAM_INT);
        $deleteQuery->execute();

        // Redirection après suppression
        header('Location: utilisateur.php');
        exit;
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
} else {
    // Si aucun ID n'est spécifié
    header('Location: utilisateur.php');
    exit;
}
?>
