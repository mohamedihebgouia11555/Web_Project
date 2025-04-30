<?php
include('db_connect.php');
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="styles.css">
    <title>Espace Prof - Emploi du Temps</title>
</head>
<header>
    <div class="header-container">
            <img src=".\image\logo.jpg" alt="L'Expert School - Expert du succès" class="header-logo">
        <nav>
		 
            <ul>
			
                <li><a href="#emploi">Emploi du Temps</h></a></li>
                <li><a href="#reservation">Réservation de Matériel</a></li>
				<li><a href="#avis">Avis de l'Administration</a></li>
				<li><a href="index.php">Déconnexion</a></li>
				
            </ul>
        </nav>
	</div>
    </header>
<body>



<div class="container mt-5">
	<h2><mark>Emploi du Temps</mark></h2>
	<!--Partie emplois du temps -->
	<!--Filtre pour l'affichage souhaité -->
		<form method="GET" action="">
			<div class="form-group">
				<label for="filter"> Voir par : </label>
				<select class="form-select" name="filter" id="filter">
					<option value="sem">Semaine</option>
					<option value="mois">Mois</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary mt-2">Appliquer</button>
		</form>
		
	<!-- Affichage -->
	<div id="emploi" class="mt-4">
		<center>
		<table class="table table-bordered">
		
			<thead>
				<tr>
					<th>Jour</th>
					<th>Horaire</th>
					<th>Activité</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Lundi</td>
				<td>17h-19h</td>
				<td>Français</td>
			</tr>
			<tr>
				<td>Mardi</td>
				<td>16h-18h</td>
				<td>Anglais</td>
			</tr>
			<tr>
				<td>Mercredi</td>
				<td>17h-19h</td>
				<td>Anglais</td>
			</tr>
			<tr>
				<td>Jeudi</td>
				<td>16h-18h</td>
				<td>Anglais</td>
			</tr>
			<tr>
				<td>Vendredi</td>
				<td>17h-19h</td>
				<td>Anglais</td>
			</tr>
		</tbody>
		</table>
		</center>
		</div>
		<br>
		<hr>
	<div id="reservation" class="container mt-5">
    <h2><mark>Réservation de Matériel</mark></h2>
	<center>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Matériel</th>
                <th>Disponibilité</th>
                <th>Réserver</th>
            </tr>
        </thead>
        <tbody>
            <!-- Exemple de données -->
            <tr>
                <td>Salle 101</td>
                <td>Disponible</td>
                <td><button class="btn btn-success">Réserver</button></td>
            </tr>
            <tr>
                <td>Projecteur</td>
                <td>Réservé</td>
                <td><button class="btn btn-secondary" disabled>Réservé</button></td>
				
            </tr>
            <tr>
                <td>Ordinateur portable</td>
                <td>Disponible</td>
                <td><button class="btn btn-success">Réserver</button></td>
            </tr>
        </tbody>
		</center>
    </table>
	<br>
	<hr>
	<div id="avis" class="container mt-5">
    <h2><mark>Avis de l'Administration</mark></h2>

    <div class="alert alert-info" role="alert">
        <strong>Avis du 15/04/2025 :</strong> Vous êtes en retard de 15 minutes pour votre cours.
        
    </div>

    <div class="alert alert-warning" role="alert">
        <strong>Avis du 16/04/2025 :</strong> N'oubliez pas de réserver le matériel pour votre présentation demain.
        
    </div>
</div>

</div>
</div>
</body>
<footer>
        <div class="footer-container">
            <!-- Section des réseaux sociaux -->
            <div class="footer-section">
                
				<h4>Suivez-nous</h4>
                <ul>
                    <li><a href="https://www.facebook.com/Expertschool.tn/" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                    <li><a href="https://fr.linkedin.com/" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
                    <li><a href="https://twitter.com/login?" target="_blank" rel="noopener noreferrer">Twitter</a></li>
                </ul>
            </div>
            
            <!-- Section Contact -->
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: <a href="mailto:ExpertSchool@gmail.com">ExpertSchool@gmail.com</a></p>
                <p>Téléphone: +216 99 873 999</p>
                <p>Adresse: 1 Bis Rue Etawba, Bardo, Tunis</p>
            </div>
        </div>

        <!-- Section copyright -->
        <div class="footer-bottom">
            <p>Copyright © 2025 L'Expert School Inc. All Rights Reserved</p>
        </div>
    </footer>
</html>