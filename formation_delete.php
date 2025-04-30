<?php
session_start();
require 'db_connect.php';

// Vérifier si l'utilisateur est autorisé
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Accès non autorisé";
    header('Location: login.php');
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    $_SESSION['error'] = "ID de formation invalide";
    header('Location: formation.php');
    exit();
}

try {
    // Vérifier l'existence de la formation et récupérer plus d'infos
    $stmt = $pdo->prepare("SELECT f.*, c.nom_prenom AS prof_name 
                          FROM formation f
                          LEFT JOIN compte c ON f.prof_id = c.id
                          WHERE f.id = ?");
    $stmt->execute([$id]);
    $formation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$formation) {
        $_SESSION['error'] = "Formation non trouvée";
        header('Location: formation.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de base de données: " . $e->getMessage();
    header('Location: formation.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Vérifier d'abord s'il y a des séances associées
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM seance WHERE formation_id = ?");
        $stmt->execute([$id]);
        $seancesCount = $stmt->fetchColumn();
        
        if ($seancesCount > 0) {
            $_SESSION['error'] = "Impossible de supprimer: cette formation a des séances associées";
            header("Location: formation.php");
            exit();
        }

        // Suppression de la formation
        $stmt = $pdo->prepare("DELETE FROM formation WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['success'] = "Formation '".htmlspecialchars($formation['titre'])."' supprimée avec succès";
        header('Location: formation.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la suppression: " . $e->getMessage();
        header("Location: formation_edit.php?id=$id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supprimer Formation - Expert School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/admin.css" rel="stylesheet">
</head>
<body class="admin-dashboard">
    <div class="sidebar">
        <!-- Votre sidebar existante -->
        <?php include('sidebar.php'); ?>
    </div>

    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-trash-alt me-2"></i> Supprimer Formation</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h4><i class="fas fa-exclamation-triangle me-2"></i> Confirmation de suppression</h4>
                        <hr>
                        <p><strong>Titre :</strong> <?= htmlspecialchars($formation['titre']) ?></p>
                        <p><strong>Description :</strong> <?= substr(htmlspecialchars($formation['description']), 0, 100) ?>...</p>
                        <p><strong>Professeur :</strong> <?= $formation['prof_name'] ?? 'Non assigné' ?></p>
                        <p><strong>Dates :</strong> Du <?= date('d/m/Y', strtotime($formation['date_debut'])) ?> au <?= date('d/m/Y', strtotime($formation['date_fin'])) ?></p>
                        
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Cette action est irréversible et supprimera définitivement la formation.
                        </div>
                    </div>
                    
                    <form method="POST">
                        <input type="hidden" name="formation_id" value="<?= $id ?>">
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="formation.php" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Confirmer la suppression
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>