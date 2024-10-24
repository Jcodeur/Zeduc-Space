<?php

  session_start() ;

  $identifiant_unique = $_SESSION["identifiant"]   ;
  
  require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

  $ma_base_de_donnee = new interaction() ; ///creation d un objet
  $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée


  require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
  $simplificateur = new Simplificateur_de_syntaxe("gestion_des_reclamations_administrateur") ; //creation d un objet qui va m aider a creer ma liste de presence
  
  $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_administrateur FROM administrateur WHERE id_administrateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
  $recherche_du_nom_utilisateur->bind_param("i",$identifiant_unique) ;
  $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
  $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_administrateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
  $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
            
?>

<?php
function affiche_la_validite_de_la_reclamation($nom_du_client,$titre_de_la_reclamation,$type_de_la_reclamation,$contenu_de_la_reclamation){
?>
<div class="Claims-card">
    <p><div class="Nom"><?php echo "nom du client : ".$nom_du_client ; ?></div></p>
    <p><div class="TitreClaim"><?php echo  "titre de la réclamation : ".$titre_de_la_reclamation ; ?></div></p>
    <p><div class="Contenu"><?php echo  "type de la réclamation : ".$type_de_la_reclamation ; ?></div></p>
    <p><div class="Contenu"><?php echo  " description de la réclamation : ".$contenu_de_la_reclamation ; ?></div></p>
    <button class="btn btn-primary valider-btn float-end" onclick="validerReclamation(this)">Valider</button>
</div>
<?php
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Réclamations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ListofClaim.css">
</head>
<body>
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
                        <a class="nav-link" href="formulaire_d_administrateur_de_gestion_d_employe.php">Employes</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="gestion_du_menu_administrateur.php">Menu</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="gestion_des_statistiques_administrateur.php">Statistiques</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_des_reclamations_administrateur.php">Reclamations</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="gestion_de_promotion_administrateur.php">Promotion</a>
                    </li>

                    
                    <li class="nav-item ">
                        <a class="nav-link " href="formulaire_de_politique_administrateur.php" >Paramètres </a>
                    </li>
                    
                    <li class="nav-item">
                       <a class="btn btn-warning" href="deconnection.php">LogOut</a>
                    </li>
                    
                </ul>
                
            </div>
            <div class="ecriture">
                
            </div>
        </div>
    </nav>
    <div class="Titre"><h1 class="text-center "> RECLAMATIONS CLIENTS </h1></div>
    <!-- Main Content -->
    <div class="container my-5">
        
        <script>
            function validerReclamation(button) {
                if (button.classList.contains('btn-primary')) {
                    // Si le bouton est encore à l'état "Valider"
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-success');
                    button.innerHTML = "Validé";
                } else {
                    // Si le bouton est déjà à l'état "Validé", on le remet à "Valider"
                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');
                    button.innerHTML = "Valider";
                }
            }
        </script>

        <div class="Claims-section">
           
          
                <?php
                    
                 
                 
                    $recherche_de_tous_les_utilisateurs = $ma_base_de_donnee->connexion->prepare("SELECT id_utilisateur FROM reclamation ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                    $simplificateur->execute_la_recherche( $recherche_de_tous_les_utilisateurs) ; //cette methode me permet d executer ma requete de  recherche
                    $tableau_de_tous_les_utilisateurs =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_de_tous_les_utilisateurs,"id_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                 
                    foreach ($tableau_de_tous_les_utilisateurs as $id_specifique_d_un_utilisateur) {

                        $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_d_utilisateur FROM utilisateurs WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                        $recherche_du_nom_utilisateur->bind_param("i",$id_specifique_d_un_utilisateur) ;
                        $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
                        $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_d_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                       

                        $recherche_du_titre = $ma_base_de_donnee->connexion->prepare("SELECT titre FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                        $recherche_du_titre->bind_param("i",$id_specifique_d_un_utilisateur) ;//remplissage de parametre
                        $simplificateur->execute_la_recherche( $recherche_du_titre) ; //cette methode me permet d executer ma requete de  recherche
                        $tableau_de_titre =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_du_titre,"titre") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                        
                        $recherche_du_type = $ma_base_de_donnee->connexion->prepare("SELECT type FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                        $recherche_du_type->bind_param("i",$id_specifique_d_un_utilisateur) ;//remplissage de parametre
                        $simplificateur->execute_la_recherche(  $recherche_du_type) ; //cette methode me permet d executer ma requete de  recherche
                        $tableau_de_type =   $simplificateur->stocke_le_resultat_de_la_requete(   $recherche_du_type,"type") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                                
                        $recherche_de_la_reclamation = $ma_base_de_donnee->connexion->prepare("SELECT commentaire FROM reclamation WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                        $recherche_de_la_reclamation->bind_param("i",$id_specifique_d_un_utilisateur) ;//remplissage de parametre
                        $simplificateur->execute_la_recherche($recherche_de_la_reclamation) ; //cette methode me permet d executer ma requete de  recherche
                        $tableau_de_la_reclamation =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_de_la_reclamation,"commentaire") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                        
                  
                        affiche_la_validite_de_la_reclamation( $tableau_nom_de_l_utilisateur[0] ,$tableau_de_titre[0] ,$tableau_de_type[0] , $tableau_de_la_reclamation[0]) ; //cette ligne me permet de d afficher chaque commande
                           
                        
                    
                        
                    }       

                   
                                
                ?>
           
            <br>
            <br>
           
        </div>
        
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>