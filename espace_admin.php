<?php
session_start();
include 'db_connect.php';

// Vérification de l'accès admin 
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: inscription.php');
    exit;
}

try {
    // 1. Récupération des statistiques avec gestion d'erreurs
    $stats = [
        'users' => $pdo->query("SELECT COUNT(*) FROM compte")->fetchColumn(),
        'eleves' => $pdo->query("SELECT COUNT(*) FROM compte WHERE role = 'eleve'")->fetchColumn(),
        'formations' => $pdo->query("SELECT COUNT(*) FROM formation")->fetchColumn(),
        'alertes' => $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'non_lu'")->fetchColumn() ?? 0
    ];

    // 2. Récupération des utilisateurs avec pagination sécurisée
    $usersPerPage = 10;
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 1,
            'min_range' => 1
        ]
    ]);
    
    $offset = ($page - 1) * $usersPerPage;

    $usersQuery = $pdo->prepare("SELECT id, nom_prenom, email, role FROM compte ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $usersQuery->bindValue(':limit', $usersPerPage, PDO::PARAM_INT);
    $usersQuery->bindValue(':offset', $offset, PDO::PARAM_INT);
    $usersQuery->execute();
    $utilisateurs = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

    // Calcul du nombre total de pages
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM compte")->fetchColumn();
    $totalPages = ceil($totalUsers / $usersPerPage);

} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Admin - Expert School</title>
    
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
        .user-table img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center py-3">
            <img src=".\image\admin.jpg" alt="Logo" width="80" class="rounded-circle mb-2">
            <h4>Expert School</h4>
        </div>
        
        <nav class="mt-4">
            <a href="espace_admin.php" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="utilisateur.php"><i class="fas fa-users me-2"></i> Utilisateurs</a>
            <a href="formation.php"><i class="fas fa-book me-2"></i> Formations</a>
            <a href="seance.php"><i class="fas fa-calendar-alt me-2"></i> Séances</a>
            <a href="parametre.php"><i class="fas fa-cog me-2"></i> Paramètres</a>
            <a href="inscription.php" class="mt-5"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i> Tableau de Bord</h1>
            
            <!-- Widgets de Statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card card-stat text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $stats['users'] ?></h5>
                                    <p class="card-text" href="utilisateur.php">Utilisateurs</p>
                                </div>
                                <i class="fas fa-users fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <a href="?section=users" class="stretched-link"></a>
                    </div>
                </div>
                
                <div class="col-md-3">
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
                        <a href="?section=users&type=eleves" class="stretched-link"></a>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card card-stat text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $stats['formations'] ?></h5>
                                    <p class="card-text">Formations</p>
                                </div>
                                <i class="fas fa-book fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <a href="?section=formations" class="stretched-link"></a>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card card-stat text-white bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $stats['alertes'] ?></h5>
                                    <p class="card-text">Alertes</p>
                                </div>
                                <i class="fas fa-bell fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <a href="?section=alertes" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            
<!-- Recherche Utilisateur -->
<div class="mb-3">
    <form method="GET" action="espace_admin.php" id="searchForm">
        <div class="input-group input-group-sm">
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Rechercher un utilisateur..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="border-radius: 20px;">
            <button class="btn btn-outline-secondary" type="submit" style="border-radius: 20px; background-color: #f0f0f0; color: #007bff;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <div id="searchResults" class="mt-2" style="display: none; background-color: #fff; border: 1px solid #ddd; border-radius: 5px; max-height: 200px; overflow-y: auto;">
        <!-- Les résultats de la recherche seront affichés ici -->
    </div>
</div>
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    let query = this.value.trim();

    if (query.length > 0) {
        // Envoie la requête AJAX vers le serveur
        fetch(`search_results.php?search=${encodeURIComponent(query)}`)
            .then(response => response.json())  // On suppose que le serveur retourne un JSON
            .then(data => {
                console.log('Réponse de la recherche:', data);  // Log des données reçues
                let resultsContainer = document.getElementById('searchResults');
                resultsContainer.innerHTML = '';  // Réinitialiser les anciens résultats
                if (data.length > 0) {
                    resultsContainer.style.display = 'block';
                    data.forEach(item => {
                        let resultItem = document.createElement('div');
                        resultItem.classList.add('p-2', 'border-bottom');
                        resultItem.innerHTML = item.nom_prenom;  // Afficher le nom de l'utilisateur
                        resultItem.addEventListener('click', function() {
                            document.getElementById('searchInput').value = item.nom_prenom;  // Mettre à jour le champ de recherche
                            resultsContainer.style.display = 'none';  // Masquer les résultats
                        });
                        resultsContainer.appendChild(resultItem);
                    });
                } else {
                    resultsContainer.style.display = 'none';  // Masquer si aucun résultat
                }
            })
            .catch(error => {
                console.error('Erreur de la recherche :', error);
            });
    } else {
        document.getElementById('searchResults').style.display = 'none';  // Masquer si le champ est vide
    }
});
</script>




            <!-- Derniers Utilisateurs -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i> Derniers Utilisateurs</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover user-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($utilisateurs as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['nom_prenom']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $user['role'] === 'admin' ? 'danger' : 
                                            ($user['role'] === 'prof' ? 'warning' : 'success') 
                                        ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
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
                            <?php for ($i = 1; $i <= ceil($stats['users'] / $usersPerPage); $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $page >= ceil($stats['users'] / $usersPerPage) ? 'disabled' : '' ?>">
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
    <script>
        // Confirmation pour les actions sensibles
        document.querySelectorAll('.btn-danger').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Cette action est irréversible. Confirmer ?')) {
                    e.preventDefault();
                }
            });
        });
        
        // Gestion du menu actif
        const currentPage = new URL(window.location.href).searchParams.get('section') || 'dashboard';
        document.querySelector(`a[href*="${currentPage}"]`).classList.add('active');
    </script>
</body>
</html> 