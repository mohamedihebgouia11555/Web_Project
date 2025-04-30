<?php
session_start();
include ('db_connect.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    $_SESSION['error'] = "ID de formation non spécifié";
    header('Location: formation.php');
    exit();
}

// Récupération des données de la formation
try {
    $stmt = $pdo->prepare("SELECT * FROM formation WHERE id = ?");
    $stmt->execute([$id]);
    $formation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$formation) {
        $_SESSION['error'] = "Formation non trouvée";
        header('Location: formation.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de récupération: " . $e->getMessage();
    header('Location: formation.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupération et validation des données
        $titre = htmlspecialchars($_POST['titre']);
        $description = htmlspecialchars($_POST['description']);
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $prof_id = intval($_POST['prof_id']);
        $niveau = htmlspecialchars($_POST['niveau']);
        $prix = floatval($_POST['prix']);
        $duree_heures = intval($_POST['duree_heures']);

        // Mise à jour dans la base de données
        $sql = "UPDATE formation SET 
                titre = ?, 
                description = ?, 
                date_debut = ?, 
                date_fin = ?, 
                prof_id = ?, 
                niveau = ?, 
                prix = ?, 
                duree_heures = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $description, $date_debut, $date_fin, $prof_id, $niveau, $prix, $duree_heures, $id]);
        
        $_SESSION['success'] = "Formation mise à jour avec succès";
        header('Location: formation.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour: " . $e->getMessage();
        header('Location: formation_edit.php?id='.$id);
        exit();
    }
}

// Récupération de la liste des professeurs
$professeurs = $pdo->query("SELECT id, nom_prenom FROM compte WHERE role = 'prof'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Formation - Expert School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-dashboard">
    <div class="sidebar">
        <!-- Votre sidebar existante -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-edit me-2"></i>Modifier Formation</h1>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($formation['titre']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($formation['description']) ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut" value="<?= $formation['date_debut'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?= $formation['date_fin'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="prof_id" class="form-label">Professeur</label>
                            <select class="form-select" id="prof_id" name="prof_id" required>
                                <option value="">Sélectionner un professeur</option>
                                <?php foreach ($professeurs as $prof): ?>
                                    <option value="<?= $prof['id'] ?>" <?= $prof['id'] == $formation['prof_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prof['nom_prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="niveau" class="form-label">Niveau</label>
                                <select class="form-select" id="niveau" name="niveau" required>
                                    <option value="Débutant" <?= $formation['niveau'] == 'Débutant' ? 'selected' : '' ?>>Débutant</option>
                                    <option value="Intermédiaire" <?= $formation['niveau'] == 'Intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
                                    <option value="Avancé" <?= $formation['niveau'] == 'Avancé' ? 'selected' : '' ?>>Avancé</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="prix" class="form-label">Prix (DT)</label>
                                <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="<?= $formation['prix'] ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duree_heures" class="form-label">Durée (heures)</label>
                                <input type="number" class="form-control" id="duree_heures" name="duree_heures" value="<?= $formation['duree_heures'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save me-1"></i> Mettre à jour</button>
                            <a href="formation.php" class="btn btn-secondary"><i class="fas fa-times me-1"></i> Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>