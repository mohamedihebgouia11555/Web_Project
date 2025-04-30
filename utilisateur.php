<?php
session_start();
require 'db_connect.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: inscription.php');
    exit;
}

try {
    // Récupération des statistiques
    $stats = [
        'total' => $pdo->query("SELECT COUNT(*) FROM compte")->fetchColumn(),
        'hommes' => $pdo->query("SELECT COUNT(*) FROM compte WHERE gender = 'Homme'")->fetchColumn(),
        'femmes' => $pdo->query("SELECT COUNT(*) FROM compte WHERE gender = 'Femme'")->fetchColumn(),
        'profs' => $pdo->query("SELECT COUNT(*) FROM compte WHERE role = 'prof'")->fetchColumn(),
        'eleves' => $pdo->query("SELECT COUNT(*) FROM compte WHERE role = 'eleve'")->fetchColumn(),
        'admins' => $pdo->query("SELECT COUNT(*) FROM compte WHERE role = 'admin'")->fetchColumn()
    ];

    // Récupération des utilisateurs avec pagination sécurisée
    $usersPerPage = 10;
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 1,
            'min_range' => 1
        ]
    ]);
    
    $offset = ($page - 1) * $usersPerPage;

    $usersQuery = $pdo->prepare("
        SELECT id, nom_prenom, email, role, gender 
        FROM compte 
        ORDER BY created_at DESC 
        LIMIT :limit OFFSET :offset
    ");
    $usersQuery->bindValue(':limit', $usersPerPage, PDO::PARAM_INT);
    $usersQuery->bindValue(':offset', $offset, PDO::PARAM_INT);
    $usersQuery->execute();
    $users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

    // Calcul du nombre total de pages
    $totalPages = ceil($stats['total'] / $usersPerPage);

} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs - Expert School</title>
    
    <!-- CSS -->
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
    </style>
</head>
<body class="admin-dashboard">
    <!-- Sidebar (identique à espace_admin.php) -->
    <div class="sidebar">
        <div class="text-center py-3">
            <img src="./image/admin.jpg" alt="Logo" width="80" class="rounded-circle mb-2">
            <h4>Expert School</h4>
        </div>
        
        <nav class="mt-4">
            <a href="espace_admin.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="utilisateur.php" class="active"><i class="fas fa-users me-2"></i> Utilisateurs</a>
            <a href="formation.php"><i class="fas fa-book me-2"></i> Formations</a>
            <a href="seance.php"><i class="fas fa-calendar-alt me-2"></i> Séances</a>
            <a href="?section=settings"><i class="fas fa-cog me-2"></i> Paramètres</a>
            <a href="inscription.php" class="mt-5"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-users me-2"></i> Gestion des Utilisateurs</h1>
            
            <!-- Widgets de Statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card card-stat text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $stats['total'] ?></h5>
                                    <p class="card-text">Total Utilisateurs</p>
                                </div>
                                <i class="fas fa-users fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-stat text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $stats['eleves'] ?></h5>
                                    <p class="card-text">Élèves</p>
                                </div>
                                <i class="fas fa-graduation-cap fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-stat text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $stats['profs'] ?></h5>
                                    <p class="card-text">Professeurs</p>
                                </div>
                                <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-venus-mars me-2"></i> Répartition par Genre</h5>
                            <canvas id="genderChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-tag me-2"></i> Répartition par Rôle</h5>
                            <canvas id="roleChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des utilisateurs -->
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Liste des Utilisateurs</h5>
                        <a href="user_add.php" class="btn btn-sm btn-success">
                            <i class="fas fa-plus me-1"></i> Nouveau
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Genre</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['nom_prenom']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['gender'] === 'Femme' ? 'danger' : 'primary' ?>">
                                            <?= $user['gender'] ?? 'Non spécifié' ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-<?= 
                                            $user['role'] === 'admin' ? 'danger' : 
                                            ($user['role'] === 'prof' ? 'warning' : 'success') 
                                        ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="user_add.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="user_edit.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="user_delete.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>">Précédent</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique genre
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: ['Hommes', 'Femmes'],
                datasets: [{
                    data: [<?= $stats['hommes'] ?>, <?= $stats['femmes'] ?>],
                    backgroundColor: ['#36a2eb', '#ff99cc'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Graphique rôles
        new Chart(document.getElementById('roleChart'), {
            type: 'pie',
            data: {
                labels: ['Élèves', 'Professeurs', 'Admins'],
                datasets: [{
                    data: [<?= $stats['eleves'] ?>, <?= $stats['profs'] ?>, <?= $stats['admins'] ?>],
                    backgroundColor: ['#4bc0c0', '#ffcd56', '#ff6384'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Gestion du menu actif
        document.querySelector('.sidebar a[href*="utilisateur.php"]').classList.add('active');
    </script>
</body>
</html>