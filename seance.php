<?php
session_start();
require 'db_connect.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: inscription.php');
    exit;
}

// Récupération des séances
try {
    $seances = $pdo->query("
        SELECT s.*, f.titre as formation_titre, c.nom_prenom as prof_nom
        FROM seances s
        JOIN formation f ON s.formation_id = f.id
        JOIN compte c ON f.prof_id = c.id
        ORDER BY s.date_seance, s.heure_debut
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Exemple de données statiques pour démo (à remplacer par votre vraie data)
    $exemplesSeances = [
        [
            'prof_nom' => 'Madame Rabaa',
            'formation_titre' => 'Français',
            'date_seance' => '2024-04-28',
            'heure_debut' => '14:00:00',
            'heure_fin' => '16:00:00',
            'salle' => 'Salle A12'
        ],
        [
            'prof_nom' => 'Monsieur Mohamed',
            'formation_titre' => 'Physique ',
            'date_seance' => '2024-04-29',
            'heure_debut' => '10:00:00',
            'heure_fin' => '12:00:00',
            'salle' => 'Salle B07'
        ]
    ];

} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}

// Génération des données pour le calendrier
$events = [];
foreach ($seances as $seance) {
    $events[] = [
        'title' => $seance['formation_titre'] . ' (' . $seance['prof_nom'] . ')',
        'start' => $seance['date_seance'] . 'T' . $seance['heure_debut'],
        'end' => $seance['date_seance'] . 'T' . $seance['heure_fin'],
        'extendedProps' => [
            'salle' => $seance['salle'],
            'prof' => $seance['prof_nom']
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Séances - Expert School</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    
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
        .fc-event {
            cursor: pointer;
        }
        .badge-prof {
            background-color: #6f42c1;
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
            <a href="espace_admin.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="utilisateur.php"><i class="fas fa-users me-2"></i> Utilisateurs</a>
            <a href="formation.php"><i class="fas fa-book me-2"></i> Formations</a>
            <a href="seance.php" class="active"><i class="fas fa-calendar-alt me-2"></i> Séances</a>
            <a href="parametre.php"><i class="fas fa-cog me-2"></i> Paramètres</a>
            <a href="inscription.php" class="mt-5"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4"><i class="fas fa-calendar-alt me-2"></i> Planning des Séances</h1>
            
            <!-- Exemples de séances -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i> Prochaines Séances</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($exemplesSeances as $seance): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($seance['formation_titre']) ?></h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge bg-info">
                                            <i class="fas fa-user-tie me-1"></i> <?= htmlspecialchars($seance['prof_nom']) ?>
                                        </span>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-door-open me-1"></i> <?= htmlspecialchars($seance['salle']) ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="far fa-calendar me-1"></i> <?= date('d/m/Y', strtotime($seance['date_seance'])) ?>
                                        </span>
                                        <span class="text-muted">
                                            <i class="far fa-clock me-1"></i> <?= date('H:i', strtotime($seance['heure_debut'])) ?> - <?= date('H:i', strtotime($seance['heure_fin'])) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Calendrier -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="far fa-calendar-alt me-2"></i> Calendrier des Cours</h5>
                        <div>
                            <button id="prevWeek" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="nextWeek" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <button id="todayBtn" class="btn btn-sm btn-primary">
                                Aujourd'hui
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'fr',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                events: <?= json_encode($events) ?>,
                eventContent: function(arg) {
                    return {
                        html: `
                            <div class="fc-event-main-frame">
                                <div class="fc-event-title-container">
                                    <div class="fc-event-title">${arg.event.title}</div>
                                </div>
                                <div class="fc-event-time">${arg.timeText}</div>
                                <div class="fc-event-salle">${arg.event.extendedProps.salle}</div>
                            </div>
                        `
                    };
                },
                eventDidMount: function(arg) {
                    // Style différent selon le professeur
                    if (arg.event.extendedProps.prof.includes('Rabaa')) {
                        arg.el.style.backgroundColor = '#ff6384';
                        arg.el.style.borderColor = '#ff6384';
                    }
                },
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                allDaySlot: false,
                weekends: false
            });

            calendar.render();

            // Navigation
            document.getElementById('prevWeek').addEventListener('click', function() {
                calendar.prev();
            });

            document.getElementById('nextWeek').addEventListener('click', function() {
                calendar.next();
            });

            document.getElementById('todayBtn').addEventListener('click', function() {
                calendar.today();
            });

            // Gestion du menu actif
            document.querySelector('.sidebar a[href*="seance.php"]').classList.add('active');
        });
    </script>
</body>
</html>