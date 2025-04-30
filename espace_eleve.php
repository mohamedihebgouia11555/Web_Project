
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Espace_eleve Emploi du Temps</title>
    <style>
        /* Global styles */

        h1, h2 {
            font-weight: bold;
            color: #1e3d58;
        }

        mark {
            background-color: #ffcc00;
        }


        /* Table styling */
        table {
            margin-top: 30px;
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Resource section */
        .resource-container {
            margin-top: 30px;
        }

        .resource-header {
            font-size: 24px;
            color: #1e3d58;
            margin-bottom: 15px;
        }

        .resource-item {
            margin-bottom: 15px;
        }

        .resource-link {
            text-decoration: none;
            color: #007bff;
        }

        .resource-link:hover {
            text-decoration: underline;
        }

        .resource-video {
            width: 100%;
            max-width: 600px;
            height: auto;
            margin-top: 15px;
        }

        /* Calendar Styles */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 10px;
            margin-top: 20px;
        }

        .calendar .day {
            padding: 20px;
            text-align: center;
            background-color: #f4f4f4;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar .day:hover {
            background-color: #ddd;
        }

        .calendar .header {
            font-weight: bold;
            background-color: #343a40;
            color: white;
            padding: 10px;
        }

        .event {
            margin-top: 10px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }
        html{
            scroll-behavior: smooth;
        }
        
    </style>
</head>

<body>
    <!-- Header -->
    <header>
    <div class="header-container">
            <img src=".\image\logo.jpg" alt="L'Expert School - Expert du succès" class="header-logo">
        <nav>
		 
            <ul>
			
                <li><a href="#emploi">Emploi du Temps</a></li>
                <li><a href="#cours">Ressources et Cours </a></li>
				<li><a href="#certif_présence">Demande Certificat de Présence</a></li>
				<li><a href="index.php">Déconnexion</a></li>
				
            </ul>
        </nav>
	</div>
    </header>

    <div class="container mt-5">
        <!-- Emploi du Temps -->
        <h2><mark>Emploi du Temps</mark></h2>
        <div id="emploi" class="mt-4">
        <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Horaire</th>
                        <th>Matières</th>
                        <th>Prof</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Lundi</td>
                        <td>10h-16h</td>
                        <td>Mathématique + Français</td>
                        <td>Amine Gharbi + Rabaa Sboui</td>
                    </tr>
                    <tr>
                        <td>Mardi</td>
                        <td>10h-15h30</td>
                        <td>Science + Anglais</td>
                        <td>Ahmed Bendoub + Kamel Naffeti</td>
                    </tr>
                    <tr>
                        <td>Mercredi</td>
                        <td>09h-16h</td>
                        <td>Anglais + Des Activités Culturelles</td>
                        <td>Kamel Naffeti</td>
                    </tr>
                    <tr>
                        <td>Jeudi</td>
                        <td>09h-14h</td>
                        <td>Mathématique + Arabe</td>
                        <td>Amine Gharbi + Marwa Labiedh</td>
                    </tr>
                    <tr>
                        <td>Vendredi</td>
                        <td>09h-14h</td>
                        <td>Informatique + Activité sportive</td>
                        <td>Meher Labiedh + Yassmine Labiedh</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <br>
        <br>
        
        <!-- Ressources pédagogiques -->
         <div id="cours" class="resource-container">
        <h1><mark>Ressources et Matériel Pédagogique</mark></h1>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Catégorie</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <!-- Documents PDF -->
        <tr>
            <td rowspan="3">Documents PDF</td>
            <td><a href="resources/cours_maths.pdf" target="_blank">Cours de Mathématiques - PDF</a></td>
        </tr>
        <tr>
            <td><a href="resources/exercices_physics.pdf" target="_blank">Exercices de Physique - PDF</a></td>
        </tr>
        <tr>
            <td><a href="resources/algorithmie_cours.pdf" target="_blank">Cours d'Algorithmie - PDF</a></td>
        </tr>

        <!-- Vidéos Éducatives -->
        <tr>
            <td rowspan="2">Vidéos Éducatives</td>
            <td>
                <iframe width="300" src="https://www.youtube.com/embed/ID_de_la_video" title="Vidéo Éducative - Mathématiques" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </td>
        </tr>
        <tr>
            <td>
                <iframe width="300" src="https://www.youtube.com/embed/ID_de_la_video" title="Vidéo Éducative - Physique" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </td>
        </tr>

        <!-- Ressources Externes -->
        <tr>
            <td rowspan="3">Ressources Externes</td>
            <td><a href="https://www.khanacademy.org/" target="_blank">Khan Academy - Ressources en Mathématiques, Physique, et bien plus</a></td>
        </tr>
        <tr>
            <td><a href="https://www.edx.org/" target="_blank">edX - Cours en ligne gratuits de diverses disciplines</a></td>
        </tr>
        <tr>
            <td><a href="https://www.coursera.org/" target="_blank">Coursera - Formation en ligne pour tous les niveaux</a></td>
        </tr>
        </tbody>
        
    </tbody>
</table>
</div>



        <br>
        <br>

        

        <!-- Demande de certificat de présence -->
        <h2><mark> Demande Certificat de Présence </mark></h2>
        <br>
        <center>
        <form id="certif_présence" class="row g-3" method="POST" action="traitement_formulaire.php">
  
  <!-- Nom et Prénom -->
  <div class="col-md-6">
    <label for="nomPrenom" class="form-label">Nom et Prénom :</label>
    <input type="text" class="form-control" id="nomPrenom" name="nom_prenom" required>
  </div>

  <!-- Date de naissance -->
  <div class="col-md-6">
    <label for="dateNaissance" class="form-label">Date de naissance :</label>
    <input type="date" class="form-control" id="dateNaissance" name="date_naissance" required>
  </div>

  <!-- Numéro d'identification -->
  <div class="col-md-6">
    <label for="numeroIdentification" class="form-label">Numéro d'identification :</label>
    <input type="text" class="form-control" id="numeroIdentification" name="numero_identification" required>
  </div>

  <!-- Ville -->
  <div class="col-md-6">
    <label for="ville" class="form-label">Ville :</label>
    <input type="text" class="form-control" id="ville" name="ville" required>
  </div>

  <!-- Motif de la demande -->
  <div class="col-12">
    <label for="motifDemande" class="form-label">Motif de la demande :</label>
    <input type="text" class="form-control" id="motifDemande" name="motif_demande" placeholder="(Dossier personnel, inscription universitaire, etc.)" required>
  </div>

  <!-- Format de réception souhaité -->
  <div class="col-12">
    <label class="form-label">Format de réception souhaité :</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="formatReception" id="formatPapier" value="papier" required>
      <label class="form-check-label" for="formatPapier">
        Format papier
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="formatReception" id="formatNumerique" value="numerique" required>
      <label class="form-check-label" for="formatNumerique">
        Format numérique (à envoyer par email)
      </label>
    </div>
  </div>

  <!-- Conditions d'acceptation -->
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="termsConditions" name="terms_conditions" required>
      <label class="form-check-label" for="termsConditions">
        J'accepte les termes et conditions
      </label>
    </div>
  </div>

  <!-- Bouton Envoyer -->
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Envoyer la demande</button>
  </div>

  <!-- Certificat de Présence -->

<?php
if (isset($_GET['certificat']) && $_GET['certificat'] == 1): ?>
    <div class="mt-5 p-4 border rounded shadow-sm bg-light">
        <h2 class="text-center">📄 Certificat de Présence</h2>
        <p>Nous certifions que <strong><?= htmlspecialchars($_GET['nom_prenom']) ?></strong>, né(e) le <strong><?= htmlspecialchars($_GET['date_naissance']) ?></strong>, identifié(e) par le numéro <strong><?= htmlspecialchars($_GET['numero_identification']) ?></strong> et résidant à <strong><?= htmlspecialchars($_GET['ville']) ?></strong>, est bien inscrit(e) à notre établissement.</p>
        <p>Date de génération : <strong><?= date('d/m/Y') ?></strong> <br><strong><span style="color:red;">En Attente</span></strong> </p>
        <p class="text-end mt-4">Signature de l'administration</p>
        <center>
        <button type="button" class="btn btn-primary" onclick="genererCertificat()">Télécharger le certificat</button>
        </center>
<?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  async function genererCertificat() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Certificat de présence", 20, 20);
    doc.text("Nom : Mohamed Iheb Gouia", 20, 30); // à personnaliser dynamiquement
    doc.text("Date : " + new Date().toLocaleDateString(), 20, 40);

    doc.save("certificat.pdf");
  }
</script>



  <script>
    async function genererCertificat() {
      const { jsPDF } = window.jspdf;

      const nom = document.getElementById('nom').value;
      const date = document.getElementById('date').value;

      const doc = new jsPDF();
      doc.setFontSize(20);
      doc.text("Certificat de Présence", 60, 30);
      doc.setFontSize(14);
      doc.text(`Nous certifions que ${nom_prenom}`, 20, 60);
      doc.text(`a bien été présent le ${date_naissance}`, 20, 70);
      doc.text("Signature : ____________________", 20, 100);

      doc.save(`certificat_${nom_prenom}.pdf`);
    }
  </script>

</form>


</center>


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
