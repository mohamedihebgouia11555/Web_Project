<?php
session_start();
include 'db_connect.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: inscription.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $settings = [
            'school_name' => htmlspecialchars($_POST['school_name']),
            'logo_url' => filter_var($_POST['logo_url'], FILTER_SANITIZE_URL),
            'notifications' => isset($_POST['notifications']) ? 1 : 0
        ];

        $pdo->prepare("
            INSERT INTO parametres (school_name, logo_url, email_notifications) 
            VALUES (:school_name, :logo_url, :notifications)
            ON DUPLICATE KEY UPDATE
                school_name = VALUES(school_name),
                logo_url = VALUES(logo_url),
                email_notifications = VALUES(email_notifications)
        ")->execute($settings);
        
        $_SESSION['success'] = "Paramètres mis à jour avec succès";
        header("Location: parametre.php");
        exit;

    } catch (PDOException $e) {
        $error = "Erreur: " . $e->getMessage();
    }
}

// Récupération des paramètres
$settings = $pdo->query("SELECT * FROM parametres LIMIT 1")->fetch(PDO::FETCH_ASSOC) ?: [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Expert School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            position: fixed;
            width: 250px;
        }
        .sidebar a {
            color: white;
            padding: 12px 15px;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
            padding-left: 20px;
        }
        .sidebar a.active {
            background-color: #007bff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .card-stat {
            transition: transform 0.3s;
        }
        .card-stat:hover {
            transform: translateY(-5px);
        }
        .logo-preview {
            max-width: 200px;
            max-height: 80px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar identique -->
     
    <div class="sidebar">
        <div class="text-center py-3">
            <img src="<?= htmlspecialchars($settings['.\image\admin.jpg'] ?? '.\image\admin.jpg') ?>" 
                 alt="Logo" width="80" class="rounded-circle mb-2">
            <h4><?= htmlspecialchars($settings['school_name'] ?? 'Expert School') ?></h4>
        </div>
        <nav class="mt-4">
            <a href="espace_admin.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="utilisateur.php"><i class="fas fa-users me-2"></i> Utilisateurs</a>
            <a href="formation.php"><i class="fas fa-book me-2"></i> Formations</a>
            <a href="seance.php"><i class="fas fa-calendar-alt me-2"></i> Séances</a>
            <a href="parametre.php" class="active"><i class="fas fa-cog me-2"></i> Paramètres</a>
            <a href="inscription.php" class="mt-5"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
        </nav>
    </div>

    <!-- Contenu Principal -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-cog me-2"></i> Paramètres</h1>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="row">
                <!-- Carte Identité -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <i class="fas fa-school me-2"></i> Identité de l'École
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Nom de l'école</label>
                                    <input type="text" name="school_name" class="form-control" 
                                           value="<?= htmlspecialchars($settings['school_name'] ?? 'Expert School') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">URL du logo</label>
                                    <input type="text" name="logo_url" class="form-control" 
                                           value="<?= htmlspecialchars($settings['logo_url'] ?? './images/logo.png') ?>">
                                    <img src="<?= htmlspecialchars($settings['logo_url'] ?? './images/logo.png') ?>" 
                                         class="logo-preview img-thumbnail" id="logoPreview">
                                </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Notifications -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="notifications" 
                                       id="notifications" <?= ($settings['email_notifications'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="notifications">Activer les emails</label>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Sauvegarde -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-save me-2"></i> Sauvegarde
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i> Enregistrer
                            </button>
                            </form>
                            
                            <hr>
                            
                            <button class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-file-export me-2"></i> Exporter les données
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prévisualisation du logo
        document.querySelector('input[name="logo_url"]').addEventListener('input', function() {
            document.getElementById('logoPreview').src = this.value;
        });
        
        // Gestion du menu actif
        document.querySelector('.sidebar a[href*="parametre.php"]').classList.add('active');
    </script>
</body>
</html>