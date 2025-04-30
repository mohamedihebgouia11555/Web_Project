<?php
// Connexion à la base de données
include('db_connect.php');

// Récupérer la requête de recherche
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    try {
        // Requête préparée
        $query = "SELECT nom_prenom FROM compte WHERE nom_prenom LIKE :search LIMIT 10";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['search' => "%$search%"]);

        // Récupérer les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Débogage : afficher les résultats
        if (count($results) > 0) {
            echo json_encode($results);  // Renvoyer les résultats en JSON
        } else {
            echo json_encode(['message' => 'Aucun résultat trouvé']);  // Message si aucun résultat
        }
    } catch (PDOException $e) {
        // Gestion des erreurs SQL
        echo json_encode(['error' => 'Erreur lors de la requête : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['message' => 'Aucun terme de recherche fourni']);
}
?>
