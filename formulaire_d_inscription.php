<?php

require "pop_pup.php" ;
session_start() ;

if (isset($_SESSION["avertissement"])){
	
   $avertissement = $_SESSION["avertissement"] ;
   appelle_pop_pup($avertissement,"formulaire_d_inscription.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
				
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte - ZEDUC-SP@CE</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="SignUp.css">
</head>
<body>
    <header class="bg-light py-3">
        <div class="container d-flex align-items-center">
            <!-- Remplace cette balise par le logo de l'entreprise -->
            <img src="images/logopetit.png" alt="Logo ZEDUC-SP@CE" class="logo mr-3">
            <h1 class="mb-0">ZEDUC-<span class="text-warning">SP@CE</span></h1>
        </div>
    </header>
    
    <main class="container my-5">
        <section class="text-center mb-5">
            <h2>Création de compte</h2>
            <hr class="w-25 mx-auto">
        </section>
        <form class="mx-auto" method="post" action="backend_d_inscription.php" style="max-width: 600px;">

		    <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="nom_utilisateur"  value="<?php echo isset($_SESSION["formulaire_nom_utilisateur"]) && !empty($_SESSION["formulaire_nom_utilisateur"]) ? htmlspecialchars($_SESSION["formulaire_nom_utilisateur"]) : ''; ?>"placeholder="Nom d'utilisateur">
            </div>

            <div class="form-group">
                <label for="telephone">Numéro de téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="numero_de_telephone"  value="<?php echo isset($_SESSION["formulaire_numero_de_telephone"]) && !empty($_SESSION["formulaire_numero_de_telephone"]) ? htmlspecialchars( $_SESSION["formulaire_numero_de_telephone"]) : ''; ?>" placeholder="Numéro de téléphone">
            </div>

            <div class="form-group">
                <label for="email">Adresse mail</label>
                <input type="email" class="form-control" id="email" name="mail"  value="<?php echo isset($_SESSION['formulaire_email']) && !empty($_SESSION['formulaire_email']) ? htmlspecialchars($_SESSION['formulaire_email']) : ''; ?>" placeholder="Adresse mail">
            </div>
           
            <div class="form-group">
                <label for="parrain">code de parrainage</label>
                <input type="text" class="form-control" id="parrain" name="code_de_parrainage"  value="<?php echo isset($_SESSION["formulaire_code_de_parrainage"]) && !empty($_SESSION["formulaire_code_de_parrainage"]) ? htmlspecialchars($_SESSION["formulaire_code_de_parrainage"]) : ''; ?>" placeholder="Id du parrain">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="mot_de_passe"  value="<?php echo isset($_SESSION["formulaire_mot_de_passe"]) && !empty( $_SESSION["formulaire_mot_de_passe"]) ? htmlspecialchars( $_SESSION["formulaire_mot_de_passe"]) : ''; ?>"placeholder="Mot de passe">
            </div>
            <div class="form-group">
                <label for="confirm-password">Vérifier le mot de passe</label>
                <input type="password" class="form-control" id="confirm-password" name="ma_confirmation_mot_de_passe"  value="<?php echo isset( $_SESSION["formulaire_confirmation_du_mot_de_passe"] ) && !empty( $_SESSION["formulaire_confirmation_du_mot_de_passe"] ) ? htmlspecialchars( $_SESSION["formulaire_confirmation_du_mot_de_passe"] ) : ''; ?>" placeholder="Vérifier le mot de passe">
            </div>
            <button type="submit" class="btn btn-dark btn-block">Créer un compte</button>
        </form>
    </main>
    
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <div class="d-flex justify-content-center">
                <!-- Remplacez les sources d'image avec les icônes appropriées -->
				<a href="#">  <img src="images/Buttonfacebook 2.png" alt="Facebook">  <i class="bi bi-facebook"></i></a>
                <a href="#">  <img src="images/Button twitter 2.png" alt="Twitter"> <i class="bi bi-twitter"></i></a>
                <a href="#">  <img src="images/Button (2) 2.png" alt="IG"> <i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
