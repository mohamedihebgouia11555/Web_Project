<?php
session_start();
require_once 'db_connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formulaire de connexion
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM compte WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['mdp']) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            switch ($user['role']) {
                case 'prof':
                    header("Location: espace_prof.php");
                    exit();
                case 'eleve':
                    header("Location: espace_eleve.php");
                    exit();
                case 'admin':
                    header("Location: espace_admin.php");
                    exit();
            }
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    }

    // Formulaire d'inscription
    elseif (isset($_POST['register'])) {
        $nom_prenom = $_POST['nom_prenom'];
        $date_naissance = $_POST['date'];
        $ville = $_POST['ville'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $created_at = date('Y-m-d H:i:s');

        // Vérification de l'unicité de l'email
        $stmt = $pdo->prepare("SELECT * FROM compte WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO compte (nom_prenom, date_naissance, ville, email, mdp, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom_prenom, $date_naissance, $ville, $email, $password, $role, $created_at]);

            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $role;

            switch ($role) {
                case 'prof':
                    header("Location: espace_prof.php");
                    exit();
                case 'eleve':
                    header("Location: espace_eleve.php");
                    exit();
                case 'admin':
                    header("Location: espace_admin.php");
                    exit();
            }
        }
    }
}
?>



<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Expert School</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
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
<center>
    <section class="form-section container mb-5">
        <div id="login-form">
            <form action="inscription.php" method="post">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login" class="btn btn-danger w-100 mt-3">Se connecter</button>
            </form>
            <center>
                <p class="switch-form mt-2">Pas de compte ? <a href="#" id="show-register">Créer un compte</a></p>

            </center>
        </div>
        <!-- Formulaire d'inscription (caché par défaut) -->
        <div id="register-form" style="display: none;">
            <form action="inscription.php" method="post">
                <label for="nom_prenom">Nom et Prénom :</label>
                <input type="text" id="nom_prenom" name="nom_prenom" required>

                <label for="date">Date de naissance :</label>
                <input type="date" id="date" name="date" required>

                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required>

                <label for="new-email">Email :</label>
                <input type="email" id="new-email" name="email" required>

                <label for="new-password">Mot de passe :</label>
                <input type="password" id="new-password" name="password" required>

                <label for="gender">Votre Sexe : </label>
                <select id="gender" name="gender" required>
                    <option value="">Choisir Votre Sexe : </option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>

                <label for="role">Rôle :</label>
                <select id="role" name="role" required>
                    <option value="">-- Choisir un rôle --</option>
                    <option value="eleve">Élève</option>
                </select>

                <button type="submit" name="register" class="btn btn-danger w-100 mt-3">Créer un compte</button>
            <center>
                <p class="switch-form mt-2">Pas de compte ? <a href="#" id="show-register">Créer un compte</a></p>
            </center>
			</form>
        </div>
    </section>
</center>
    <script>
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        });
    </script>
</body>
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
</html>
