<?php
session_start();
require 'db_connect.php'; // Connexion DB

// 1. Gestion des données
$formationsPerPage = 8;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $formationsPerPage;

$formations = $pdo->query("
    SELECT f.*, c.nom_prenom AS prof_name 
    FROM formation f
    LEFT JOIN compte c ON f.prof_id = c.id
    ORDER BY f.created_at DESC
    LIMIT $formationsPerPage OFFSET $offset
")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Formations - Expert School</title>
    
    <!-- CSS (identique à espace_admin.php) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/admin.css" rel="stylesheet">
    
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
        .user-table img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="admin-dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center py-3">
            <img src="./image/admin.jpg" alt="Logo" width="80" class="rounded-circle mb-2">
            <h4>Expert School</h4>
        </div>
        
        <nav class="mt-4">
            <a href="espace_admin.php" class=""><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="utilisateur.php"><i class="fas fa-users me-2"></i> Utilisateurs</a>
            <a href="formation.php"><i class="fas fa-book me-2"></i> Formations</a>
            <a href="seance.php"><i class="fas fa-calendar-alt me-2"></i> Séances</a>
            <a href="parametre.php"><i class="fas fa-cog me-2"></i> Paramètres</a>
            <a href="inscription.php" class="mt-5"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
        </nav>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-book me-2"></i>Formations</h1>
            
            <!-- Bouton d'ajout modifié pour rediriger directement -->
            <a href="formation_new.php" class="btn btn-success mb-3">
                <i class="fas fa-plus me-2"></i>Nouvelle formation
            </a>

            <!-- Tableau -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Professeur</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($formations as $formation): ?>
                                <tr>
                                    <td><?= $formation['id'] ?></td>
                                    <td><?= htmlspecialchars($formation['titre']) ?></td>
                                    <td><?= substr(htmlspecialchars($formation['description']), 0, 50) ?>...</td>
                                    <td><?= $formation['prof_name'] ?? 'Non assigné' ?></td>
                                    <td>
                                        <a href="formation_edit.php?id=<?= $formation['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="formation_delete.php?id=<?= $formation['id'] ?>"class="btn btn-sm btn-danger delete-formation">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS (identique à espace_admin.php) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>