<?php
session_start();
include('db_connect.php');

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

        // Vérification que le professeur existe
        $stmt = $pdo->prepare("SELECT id FROM compte WHERE id = ? AND role = 'prof'");
        $stmt->execute([$prof_id]);
        if (!$stmt->fetch()) {
            $_SESSION['error'] = "Le professeur sélectionné n'existe pas ou n'est pas un professeur valide";
            header('Location: formation_new.php');
            exit();
        }

        // Insertion dans la base de données
        $sql = "INSERT INTO formation (titre, description, date_debut, date_fin, prof_id, niveau, prix, duree_heures, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $description, $date_debut, $date_fin, $prof_id, $niveau, $prix, $duree_heures]);
        
        $_SESSION['success'] = "Formation ajoutée avec succès";
        header('Location: formation.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'ajout de la formation: " . $e->getMessage();
        header('Location: formation_new.php');
        exit();
    }
}

// Récupération de la liste des professeurs pour le select
$professeurs = $pdo->query("SELECT id, nom_prenom FROM compte WHERE role = 'prof'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle Formation - Expert School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-dashboard">
    <div class="sidebar">
        <!-- Votre sidebar existante -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-plus-circle me-2"></i>Nouvelle Formation</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="prof_id" class="form-label">Professeur</label>
                            <select class="form-select" id="prof_id" name="prof_id" required>
                                <option value="">Sélectionner un professeur</option>
                                <?php foreach ($professeurs as $prof): ?>
                                    <option value="<?= $prof['id'] ?>"><?= htmlspecialchars($prof['nom_prenom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="niveau" class="form-label">Niveau</label>
                                <select class="form-select" id="niveau" name="niveau" required>
                                    <option value="Débutant">Débutant</option>
                                    <option value="Intermédiaire">Intermédiaire</option>
                                    <option value="Avancé">Avancé</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="prix" class="form-label">Prix (DT)</label>
                                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duree_heures" class="form-label">Durée (heures)</label>
                                <input type="number" class="form-control" id="duree_heures" name="duree_heures" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2"><i class="fas fa-save me-1"></i> Enregistrer</button>
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