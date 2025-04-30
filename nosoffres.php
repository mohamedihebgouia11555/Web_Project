<!doctype html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>L'Expert School</title>
		<link rel="stylesheet" href="styles.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
	crossorigin="anonymous">
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
	
	<div class="section-title"><i class="bi bi-book-half"></i> Offres de la plateforme </div>
	<p class="section-description">
		La plus grande bibliothèque pédagogique vous garantit la meilleur préparation qui vous aide à atteindre l'excellence à travers des offres diverses et variées qui vous accompagnent jusqu'à la fin de l'année scolaire.
	</p>	
	
	<center>
	<div class="tabs">
		<button type="button" class="tab active" onclick="filterOffers('باكالوريا',event)">باكالوريا</button>
		<button type="button" class="tab active" onclick="filterOffers('ثانوي',event)">ثانوي</button>
		<button type="button" class="tab active" onclick="filterOffers('أساسي',event)">أساسي</button>
		<button type="button" class="tab active" onclick="filterOffers('ابتدائي',event)">ابتدائي</button>
	</div>
	</center>
	
	<!--Partie ابتدائي -->
<div class="offers-container" id="offers">
	<div class="offer-box" data-level="ابتدائي">
		<img src="image\semestre 3.jpeg" alt="Offre Trimestre" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض الثلاثي الثالث</div>
		<div class="offer-desc">فرصة لتدارك كل ما فاتك طيلة السنة</div>
		<div class="offer-price">ابتداء من 35د</div>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
	
	<div class="offer-box" data-level="ابتدائي">
		<img src="image\offre spécial.jpeg" alt="Offre spécial" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض نحو النموذجي</div>
		<div class="offer-desc">لمساعدتكم إثر اجتياز المناظرة الوطنية</div>
		<div class="offer-price">ابتداء من 45د</div>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
	
	<div class="offer-box" data-level="ابتدائي">
	<img src="image\silver.jpeg" alt="Offre spécial" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض سيلفر</div>
		<div class="offer-desc">عرض شهري أو سنوي مع تخفيض 15٪ للاشتراكات السنوية</div>
		<div class="offer-price">ابتداء من 60 د</div>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
</div>

	<!--Partie أساسي -->
<div class="offers-container" id="offers">
	<div class="offer-box" data-level="أساسي">
	<img src="image\semestre 3.jpeg" alt="Offre Trimestre" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض الثلاثي الثالث</div>
		<div class="offer-desc">فرصة لتدارك كل ما فاتك طيلة السنة</div>
		<div class="offer-price">ابتداء من 45د</div>
		<br>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
	
	<div class="offer-box" data-level="أساسي">
	<img src="image\offre spécial.jpeg" alt="Offre spécial" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض نحو النموذجي</div>
		<div class="offer-desc">لمساعدتكم إثر اجتياز المناظرة الوطنية</div>
		<div class="offer-price">ابتداء من 55د</div>
		<br>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
	
	<div class="offer-box" data-level="أساسي">
	<img src="image\silver.jpeg" alt="Offre spécial" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض سيلفر</div>
		<div class="offer-desc">عرض شهري أو سنوي مع تخفيض 15٪ للاشتراكات السنوية</div>
		<div class="offer-price">ابتداء من 75 د</div>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
</div>

	<!--Partie ثانوي -->
<div class="offers-container" id="offers">
	<div class="offer-box" data-level="ثانوي">
	<img src="image\semestre 3.jpeg" alt="Offre Trimestre" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض الثلاثي الثالث</div>
		<div class="offer-desc">فرصة لتدارك كل ما فاتك طيلة السنة</div>
		<div class="offer-price">ابتداء من 45د</div>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
	
	<div class="offer-box" data-level="ثانوي">
		<div class="offer-title">عرض سيلفر</div>
		<img src="image\silver.jpeg" alt="Offre spécial" style="width:100%; border-radius:10px;">
		<div class="offer-desc">عرض شهري أو سنوي مع تخفيض 15٪ للاشتراكات السنوية</div>
		<div class="offer-price">ابتداء من 85د</div>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
</div>

		<!--Partie ثانوي -->
<div class="offers-container" id="offers">
	<div class="offer-box" data-level="باكالوريا">
	<img src="image\silver.jpeg" alt="Offre spécial" style="width:100%; border-radius:10px;">
		<div class="offer-title">عرض سيلفر</div>
		<div class="offer-desc">عرض شهري أو سنوي مع تخفيض 15٪ للاشتراكات السنوية</div>
		<div class="offer-price">ابتداء من 99د</div>
		<br>
		<a href="contact.php" class="btn btn-outline-danger">Choisir Cette Offre</a>
	</div>
</div>






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
