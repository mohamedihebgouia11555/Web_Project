<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//connexion a la bd
	$host = 'localhost';
	$dbName = 'expert_school';
	$username = 'root';
	$password = '';
	
	$conn = new mysqli($host, $username, $password, $dbName);
	
	//vérifier la cnnx 
	if($conn -> connect_error){
		die("connexion échouée: ".$conn->connect_error);
	}
	
	//récupération des données et sécurisation
	$nom_prenom = $conn -> real_escape_string($_POST["nom_prenom"]);
	$email = $conn -> real_escape_string($_POST["email"]);
	$telephone = $conn -> real_escape_string($_POST["telephone"]);
	$message = $conn -> real_escape_string($_POST["message"]);
	
	//requete d'insertion avec des resuetes préparé pour plus de sécurité
	$stmt = $conn -> prepare("INSERT INTO eleve (nom_prenom, email, telephone, message) VALUES(?,?,?,?)");
	
	//ici on va lier la variable $nom au paramètre
	$stmt ->bind_param("ssss", $nom_prenom, $email, $telephone, $message);
	
	if($stmt->execute()){
		echo"<script>alert('Message envoyé avec succès !!');</script>";
	}else{
		echo"Erreur: ".$stmt->error;
	}
	
	//fermer la Connexion
	
	$stmt -> close();
	$conn -> close();
}
?>

<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>L'Expert School</title>
	<link rel="stylesheet" href="styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
	crossorigin="anonymous">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
	  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
	  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
    <header>
	<div class="header-container">
        <a href="index.php" class="logo-link">
            <img src=".\image\logo.jpg" alt="L'Expert School - Expert du succès" class="header-logo">
        </a>
        <nav>
		 
            <ul>
			
                <li><a href="index.php">Accueil</a></li>
                <li><a href="nosformation.php">Nos Formations</a></li>
				<li><a href="nosoffres.php">Nos Offres</a></li>
                <li><a href="contact.php">Contact</a></li>
				<li><a href="inscription.php">Connexion</a></li>
				
            </ul>
        </nav>
		
	</div>
    </header>
<body>
<!--intro-->
	<div class="intro-message">
		<h2><i class="bi bi-envelope-paper-heart-fill"> Contactez-nous </i></h2>
	<p>
	Vous avez une question, une suggestion ou vous souhaitez simplement échanger avec nous ? <br>
	Remplissez le formulaire ci-dessous ou utilisez l'un des moyens de disponibles .  <i class="bi bi-arrow-down-left-square-fill"></i>
	</p>
	</div>
	
	  <body class="p-3 m-0 border-0 bd-example m-0 border-0">
	  <!--formulaire-->
    <form method="POST" action="">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nom et Prénom</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="nom_prenom" aria-describedby="emailHelp" required>
    <div id="emailHelp" class="form-text">Ce champ est obligatoire.</div>
  </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name ="email" aria-describedby="emailHelp" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Téléphone</label>
        <input type="text" class="form-control" name ="telephone" id="exampleInputPassword1">
		<div id="emailHelp" class="form-text">Ce champ n'est pas obligatoire</div>
      </div>
      <div class="form-group">
      <label for="exampleInputPassword1" class="form-label">Votre message</label>
      <textarea class="form-control message-input" id="message" name="message" rows="5" placeholder="Écrivez votre message ici..." required></textarea>
      <small class="form-text">Nous vous répondrons dans les plus brefs délais.</small>
    </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
	<!-- la fin du formulaire-->
	<br>
	<hr>
	<br>
	<div class="contact-direct">
		<h3> Coordnées directes </h3>
		<ul> 
			<li class="contact-item">
				<span class="icon"><i class="bi bi-envelope" style="font-size: 20px;"></i> </span>
				<a href="mailto:ExpertSchool@gmail.com">ExpertSchool@gmail.com</a>
			</li>
			<li class="contact-item">
				<span class="icon"><i class="bi bi-telephone" style="font-size: 20px;"></i></span>
				<a href="tel: +216 99 873 999"> +216 99 873 999 </a>
			</li>
			<li class="contact-item">
				<span class="icon"><i class="bi bi-geo-alt" style="font-size: 20px;"></i></span>
				<span>Adresse: 1 Bis Rue Etawba, Bardo, Tunis </span>
			</li>
			</ul>
	</div>
	<!--partie des réseaux sociaux-->
	<center>
	<div class="social-links">
		<h3>Suivez-nous sur les réseaux sociaux !</h3>
		<ul>
			<li>
				<a href="https://www.facebook.com/Expertschool.tn/" target="_blank" class="social-icon">
				<i class="bi bi-facebook"></i>
				</a>
			</li>
			<li>
				<a href="https://www.instagram.com/" target="_blank" class="social-icon">
				<i class="bi bi-instagram"></i>
				</a>
			</li>
			<li>
				<a href="https://www.linkedin.com/feed/" target="_blank" class="social-icon">
				<i class="bi bi-linkedin"></i>
				</a>
			</li>
		</ul>
	</div>
	</center>
			
  </body>
<section id="map">
			<center>
			<h2>Nous trouver sur la carte </h2>
			<br>
			<iframe src="https://www.google.com/maps/embed?pb=..." width="650" height="550" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</center>
		</section>
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

