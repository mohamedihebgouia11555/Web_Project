<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>L'Expert School</title>
	<link rel="stylesheet" href="styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
	crossorigin="anonymous">
	<!-- lien pour Bootstrap les Icons des boutons-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

	<script src="scripts.js"></script>
</head>
<body>
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
	<!--Les boutons Scroll-->
	<button id="back-to-top" class="scroll-btn"onclick="scrollToTop()">
	<i class="bi bi-arrow-up-circle-fill"></i>
	</button>
	<button id="go-to-footer" class="scroll-btn"onclick="scrollToFooter()">
	<i class="bi bi-arrow-down-circle-fill"></i>
	</button>
    
    <section id="accueil">
        <div class="container">
            <h1>Bienvenue à l'Expert School</h1>
            <p>Nous offrons une éducation de qualité pour préparer nos élèves à un avenir brillant.</p>
        </div>
    </section>
	
	<hr>
	
	<section id="presentation" class="presentation-section">
    <div class="container">
        <div class="text-content">
            <h2><span class="highlight">Qui sommes-nous ?</span></h2>
            <h3>Un établissement d'<span class="highlight">excellence</span>, un cadre exigeant</h3>
            <p><strong>L’Expert School</strong> est un centre académique privé en Tunisie qui accompagne les élèves de la <strong>primaire jusqu’au baccalauréat</strong>, avec un seul objectif : leur <span class="highlight">réussite</span>.</p>

            <p>Nous nous distinguons par :</p>
            <ul>
                <li>✔ <strong>Une éducation de haute qualité</strong> qui allie rigueur et <span class="highlight">innovation</span> pédagogique</li>
                <li>✔ <strong>Une équipe enseignante</strong> passionnée et expérimentée</li>
                <li>✔ <strong>Un encadrement strict</strong> et bienveillant pour un environnement propice à l’épanouissement</li>
            </ul>

            <h4><span class="highlight"><br> Un directeur engagé</span></h4>
            <p>Sous la direction de <strong>Monsieur Jamel Werfelli</strong>, notre école crée une synergie entre enseignants, élèves et parents, avec un suivi personnalisé.</p>

            <p>Chez <strong>L’Expert School</strong>, chaque élève est unique, et notre mission est de l’amener vers la <span class="highlight">réussite</span>.</p>
        </div>

        <div class="image-content">
            <img src=".\image\expert.jpg" alt="Logo Expert School" >
        </div>
    </div>
</section>

<!-- shema -->
<section id="expert-school">
	<div class="expert-container">
	<img src=".\image\schema2.png" alt="photo pour un schema">
	</div>
	<div>
	<br>
	<a href="contact.php" class="btn btn-outline-danger">Nous contacter</a>
	
	</div>
</section>


	<!--deepseek Code-->
<div style="font-family: 'Arial', sans-serif; max-width: 800px; margin: 0 auto; color: #333;">
    <!-- Titre avec effet -->
    <h1 style="color: #2c3e50; text-align: center; font-size: 2.5em; margin-bottom: 30px; position: relative;">
        <span style="background: linear-gradient(90deg, #3498db, #2c3e50); -webkit-background-clip: text; color: transparent;">
            D'une passion est née une mission
        </span>
    </h1>
    
    <!-- Introduction -->
    <p style="font-size: 1.1em; line-height: 1.6; text-align: center; margin-bottom: 40px;">
        Fondée en 2014 à Tunis, L'Expert School a commencé comme un petit projet porté par une équipe de passionnés, déterminés à changer les choses dans le domaine de l'éducation.
    </p>
    
    <!-- Statistiques en icônes -->
    <div style="display: flex; justify-content: space-around; flex-wrap: wrap; margin: 50px 0; text-align: center;">
        <div style="margin: 15px;">
            <div style="font-size: 3em; color: #e74c3c; font-weight: bold;">10+</div>
            <div style="font-weight: bold;">ans d'expertise</div>
        </div>
        <div style="margin: 15px;">
            <div style="font-size: 3em; color: #2ecc71; font-weight: bold;">5000+</div>
            <div style="font-weight: bold;">élèves accompagnés</div>
        </div>
        <div style="margin: 15px;">
            <div style="font-size: 3em; color: #3498db; font-weight: bold;">15+</div>
            <div style="font-weight: bold;">professionnels dévoués</div>
        </div>
    </div>
    
    <!-- Notre philosophie -->
    <div style="background-color: #f8f9fa; padding: 30px; border-radius: 10px; margin: 40px 0;">
        <h2 style="color: #2c3e50; text-align: center; margin-bottom: 20px;">Notre philosophie</h2>
        <p style="font-style: italic; text-align: center; margin-bottom: 20px;">
            Nous croyons en l'excellence, l'innovation et l'accessibilité. Notre objectif ?
        </p>
        <ul style="list-style-type: none; padding: 0;">
            <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center;">
                <span style="color: #27ae60; margin-right: 10px; font-size: 1.5em;">→</span>
                Offrir des formations de qualité adaptées aux besoins réels
            </li>
            <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center;">
                <span style="color: #27ae60; margin-right: 10px; font-size: 1.5em;">→</span>
                Encourager l'épanouissement personnel et professionnel
            </li>
            <li style="padding: 10px 0; display: flex; align-items: center;">
                <span style="color: #27ae60; margin-right: 10px; font-size: 1.5em;">→</span>
                Bâtir une communauté soudée et dynamique
            </li>
        </ul>
    </div>
    
    <!-- Citation -->
    <div style="border-left: 4px solid #3498db; padding-left: 20px; margin: 40px 0;">
        <p style="font-style: italic; font-size: 1.2em;">
            "Chez L'Expert School, chaque parcours est unique – et nous mettons tout en œuvre pour le rendre réussi."
        </p>
        <p style="font-weight: bold; text-align: right;">Monsieur Jamel Werfelli, Fondateur</p>
    </div>
</div>
<!--deepseek Code-->





	
    <footer id="footer">
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
</body>
</html>
