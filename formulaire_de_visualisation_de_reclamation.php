<?php

	require "pop_pup.php" ;
	session_start() ;

	if (isset($_SESSION["avertissement"])){
		
		$avertissement = $_SESSION["avertissement"] ;
		appelle_pop_pup($avertissement,"formulaire_de_visualisation_de_reclamation.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
						
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
    <title>Suivi de Réclamations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Claim.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Logo" width="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse  test" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="page_de_l_utilisateur.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_reclamation.php">Services Clients</a>
                    </li>
                    <li class="nav-item">
                       <a class="btn btn-warning" href="deconnection.php">Log out</a>
                    </li>
                  
                </ul>
              
                <div class="ecriture">
                <?php echo "Hey , ".$nom_de_l_utilisateur;?>          
                </div>
            </div>
            
        </div>
       
    </nav>
    <?php 
      function affiche_la_reclamation($titre,$type,$ma_reclamation,$etat_de_la_reclamation){
    ?>
    <div class="fidelity-card">
        <h2 id=""><?php echo $titre;?></h2>
        <h3 id=""><?php echo $type;?></h3>

        <p><?php echo $ma_reclamation." : ".$etat_de_la_reclamation ;?></p>
    </div>
    <?php
      }
    ?>
    <div class="Titre"><h1 class="text-center ">ZEDUC SP@CE LIST OF CLAIMS </h1></div>
    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center mt-4">PRESENTATION DES RECLAMATION</h2>
        <p class="text-center">Les points de fidélité sont un système de récompense mis en place pour encourager les étudiants à passer régulièrement des commandes et à participer aux activités du restaurant :</p>
        
        <div class="fidelity-section">
         
           <?php
            
              $recherche_du_titre = $ma_base_de_donnee->connexion->prepare("SELECT titre FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
              $recherche_du_titre->bind_param("i",$identifiant_unique) ;//remplissage de parametre
              $simplificateur->execute_la_recherche( $recherche_du_titre) ; //cette methode me permet d executer ma requete de  recherche
              $tableau_de_titre =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_du_titre,"titre") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
              
              $recherche_du_type = $ma_base_de_donnee->connexion->prepare("SELECT type FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
              $recherche_du_type->bind_param("i",$identifiant_unique) ;//remplissage de parametre
              $simplificateur->execute_la_recherche(  $recherche_du_type) ; //cette methode me permet d executer ma requete de  recherche
              $tableau_de_type =   $simplificateur->stocke_le_resultat_de_la_requete(   $recherche_du_type,"type") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                         
              $recherche_de_la_reclamation = $ma_base_de_donnee->connexion->prepare("SELECT commentaire FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
              $recherche_de_la_reclamation->bind_param("i",$identifiant_unique) ;//remplissage de parametre
              $simplificateur->execute_la_recherche($recherche_de_la_reclamation) ; //cette methode me permet d executer ma requete de  recherche
              $tableau_de_la_reclamation =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_de_la_reclamation,"commentaire") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
              
              $recherche_de_l_etat_de_reclamation = $ma_base_de_donnee->connexion->prepare("SELECT etat_de_la_reclamation FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
              $recherche_de_l_etat_de_reclamation->bind_param("i",$identifiant_unique) ;//remplissage de parametre
              $simplificateur->execute_la_recherche(  $recherche_de_l_etat_de_reclamation) ; //cette methode me permet d executer ma requete de  recherche
              $tableau_de_l_etat_de_reclamation =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_de_l_etat_de_reclamation,"etat_de_la_reclamation") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
              
              for($i= 0 ;$i<=count($tableau_de_la_reclamation)-1 ;$i++){
                affiche_la_reclamation($tableau_de_titre[$i],$tableau_de_la_reclamation[$i],$tableau_de_type[$i],$tableau_de_l_etat_de_reclamation[$i]) ;
              }
             
                            
           
           
           ?>
          
           
            <br>
            <br>
            
        </div>
    
    </div>

    <!-- Footer -->
    <footer class="text-white bg-dark">
        <div class="container d-flex justify-content-between py-3">
            <div>
                <p>Contact:</p>
                <ul>
                    <li>Téléphone: +237 666666666</li>
                    <li>Email: zeducspace@gmail.com</li>
                </ul>
            </div>
            <div>
                <p>Social Media:</p>
                <div class="social-icons">
                    <a href="#">  <img src="images/Buttonfacebook 2.png" alt="Facebook">  <i class="bi bi-facebook"></i></a>
                    <a href="#">  <img src="images/Button twitter 2.png" alt="Twitter"> <i class="bi bi-twitter"></i></a>
                    <a href="#">  <img src="images/Button (2) 2.png" alt="IG"> <i class="bi bi-linkedin"></i></a>
                    
                </div>
            </div>
            <div>
                <p>Localisation</p>
                <ul>
                    <li>Yansoki / Yatchika</li>
                    <li>Situé précisément à la cité Terrasse</li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>