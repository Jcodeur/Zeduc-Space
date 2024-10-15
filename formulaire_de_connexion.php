<?php

	require "pop_pup.php" ;
	session_start() ;

	if (isset($_SESSION["avertissement"])){
		
		$avertissement = $_SESSION["avertissement"] ;
		appelle_pop_pup($avertissement,"formulaire_de_connexion.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
						
	}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="LoginPage.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <!-- Place here your logo image -->
                <img src="images/logopetit.png" alt="Logo" width="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services Clients</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Autres
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Événement</a></li>
                            <li><a class="dropdown-item" href="#">Programme de fidélité</a></li>
                            <li><a class="dropdown-item" href="#">Historique des commandes</a></li>
                            <li><a class="dropdown-item" href="#">Réclamations</a></li>
                            <li><a class="dropdown-item" href="#">Jeux</a></li>
                            <li><a class="dropdown-item" href="#">10 Meilleurs clients</a></li>
                        </ul>
                    </li>
                </ul>
                <a class="btn btn-warning" href="formulaire_de_connexion.php">Login</a>
            </div>
        </div>
    </nav>

    <!-- Form Section -->
    <div class="container">
        <div class="form-container">
            <img src="images/LOGO.png" alt="Logo" width="200" class="mb-4 rotating-logo">
            <form method="post" action="backend_de_connexion.php">
                <div class="mb-3">
                    <input type="email" class="form-control form-control-lg" name="mail" value="<?php echo isset($_SESSION["formulaire_email"]) && !empty( $_SESSION["formulaire_email"] ) ? htmlspecialchars( $_SESSION["formulaire_email"] ) : ''; ?>" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control form-control-lg" name="mot_de_passe" value="<?php echo isset( $_SESSION["formulaire_mot_de_passe"] ) && !empty( $_SESSION["formulaire_mot_de_passe"]) ? htmlspecialchars( $_SESSION["formulaire_mot_de_passe"] ) : ''; ?>" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-custom btn-lg w-100 mb-3">Connexion</button>
                <a href="index.php" class="text-warning">Accueil</a><br>
                <a href="formulaire_d_inscription.php" class="text-warning">Inscription</a>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <p>Contact:</p>
                    <ul>
                        <li>Téléphone : +237 666666666</li>
                        <li>Email : zeducspace@gmail.com</li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-4 text-center">
                    <p>Social Media:</p>
                    <a href="#">  <img src="images/Buttonfacebook 2.png" alt="Facebook">  <i class="bi bi-facebook"></i></a>
                    <a href="#">  <img src="images/Button twitter 2.png" alt="Twitter"> <i class="bi bi-twitter"></i></a>
                    <a href="#">  <img src="images/Button (2) 2.png" alt="IG"> <i class="bi bi-linkedin"></i></a>
                </div>

                <div class="col-md-4 col-lg-4">
                    <p>Localisation:</p>
                    <ul>
                        <li>Yansoki / Yatchika</li>
                        <li>Site précisément à la cité Terrasse</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
