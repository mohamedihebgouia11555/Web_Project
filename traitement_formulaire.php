<?php
session_start(); // Démarrer la session pour les messages

// Connexion à la base de données
$host = 'localhost';
$dbname = 'expert_school';
$username = 'root';
$password = '';

try {
    // Connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // Récupération sécurisée des champs du formulaire
        $nom_prenom = htmlspecialchars(trim($_POST['nom_prenom']));
        $date_naissance = $_POST['date_naissance'];
        $numero_identification = htmlspecialchars(trim($_POST['numero_identification']));
        $ville = htmlspecialchars(trim($_POST['ville']));
        $motif_demande = htmlspecialchars(trim($_POST['motif_demande']));
        $format_reception = $_POST['formatReception'];
        $terms_conditions = isset($_POST['terms_conditions']) ? 'Accepted' : 'Not Accepted';

        // Préparation de la requête SQL
        $sql = "INSERT INTO certificat_presence 
                (nom_prenom, date_naissance, numero_identification, ville, motif_demande, format_reception, terms_conditions) 
                VALUES 
                (:nom_prenom, :date_naissance, :numero_identification, :ville, :motif_demande, :format_reception, :terms_conditions)";

        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nom_prenom', $nom_prenom);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':numero_identification', $numero_identification);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':motif_demande', $motif_demande);
        $stmt->bindParam(':format_reception', $format_reception);
        $stmt->bindParam(':terms_conditions', $terms_conditions);

        // Exécution
        $stmt->execute();

        // Message de succès dans la session
        $_SESSION['success'] = "✅ Demande envoyée avec succès !";

        // Redirection vers espace_eleve.php avec les infos utiles en GET
        header("Location: espace_eleve.php?certificat=1&nom_prenom=" . urlencode($nom_prenom) . "&date_naissance=" . urlencode($date_naissance) . "&numero_identification=" . urlencode($numero_identification) . "&ville=" . urlencode($ville));
        exit();
    }

} catch (PDOException $e) {
    // Message d'erreur en cas de problème
    $_SESSION['error'] = "❌ Erreur lors de la soumission : " . $e->getMessage();
    header("Location: espace_eleve.php");
    exit();
}
?>
