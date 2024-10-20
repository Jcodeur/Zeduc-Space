<?php

	require "pop_pup.php" ;
	session_start() ;

	if (isset($_SESSION["avertissement"])){
		
		$avertissement = $_SESSION["avertissement"] ;
		appelle_pop_pup($avertissement,"formulaire_de_reclamation.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
						
	}

	$identifiant_unique = $_SESSION["identifiant"]   ;
    
    require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

    $ma_base_de_donnee = new interaction() ; ///creation d un objet
    $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
  
  
    require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
    $simplificateur = new Simplificateur_de_syntaxe("page_de_l_utilisateur") ; //creation d un objet qui va m aider a creer ma liste de presence
    

    $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_d_utilisateur FROM utilisateurs WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
    $recherche_du_nom_utilisateur->bind_param("i",$identifiant_unique) ;
    $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
    $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_d_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
    $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
          

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte - ZEDUC-SP@CE</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ServiceClient.css">
</head>
<body>
    

    <header>
        <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <!-- Place here your logo image -->
                <img src="images/logo.png" alt="Logo" width="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="page_de_l_utilisateur.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_visualisation_de_reclamation.php">Visualisation des réclamations</a>
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
                <a class="btn btn-warning" href="#">LogOut</a>
            </div>
            <div class="ecriture">
                <?php echo$nom_de_l_utilisateur ;?> 
            </div>
        </div>
    </nav>
    <div class="Titre"><h2  class="text-center" >SERVICE CLIENT</h2></div>
    </header>

    <main class="container my-5">
        <section class="text-center mb-5">
            
            <h3>FORMULAIRE DE RECLAMATION</h3>
            <hr class="w-50 mx-auto">
        </section>
        <form class="mx-auto" method="post" action="backend_de_reclamation.php"  style="max-width: 600px;">
            
            <div class="form-group mb-4">
                <label for="type">Type de Réclamation</label>
                <select name="type" class="form-control" id="type" onchange="remplirChamp(this.value)">
                    <option  value="Null"> Choisir une option </option>
                    <option  value="Client"> Concernant un autre client </option>
                    <option  value="Employé">Concernant un Employé</option>
                    <option  value="Nourriture">Concernant un Plat</option>
                    <option  value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="sujet">Titre de réclamation</label>
                <input type="text" class="form-control" id="sujet" name="titre" placeholder="Sujet de réclamation">
                
            </div>
            <div class="form-group mb-4">
                <label for="commentaires">Commentaires/Détails</label>
                <textarea class="form-control" id="commentaires" rows="4" name="commentaire" placeholder="Commentaires/Détails"></textarea>
            </div>
            
            <button name="reclame" type="submit" class="btn btn-dark btn-block">Envoyer la réclamation</button>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contact :</h5>
                    <p>Telephone : +237 666666666</p>
                    <p>Email : Zeducspace@gmail.com</p>
                </div>
                <div class="col-md-4">
                    <h5>Social Media :</h5>
                    <div class="social-icons">
                        <a href="#">  <img src="images/Buttonfacebook 2.png" alt="Facebook">  <i class="bi bi-facebook"></i></a>
                        <a href="#">  <img src="images/Button twitter 2.png" alt="Twitter"> <i class="bi bi-twitter"></i></a>
                        <a href="#">  <img src="images/Button (2) 2.png" alt="IG"> <i class="bi bi-linkedin"></i></a>
                    
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Localisation :</h5>
                    <p>Yansoki /Yatchika</p>
                    <p>Situé précisément à la cité Terrasse</p>
                </div>
            </div>
        </div>
    </footer>


    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
