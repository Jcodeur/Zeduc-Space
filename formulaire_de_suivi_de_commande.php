<?php 
function affiche_la_commande($identifiant_de_la_commande,$date_de_la_commande, $nom_du_plat,$montant_du_plat,$nombre_de_plat, $prix_total_d_un_plat){
    
?>
<div class="fidelity-card">
    <h2 id=""><?php echo "Identifiant de la commande : ".$identifiant_de_la_commande ; ?></h2>
    <h3 id=""><?php echo "Date de la commande : ".$date_de_la_commande ; ?></h3>

    <p><?php echo $nom_du_plat ;?></p>
    <p><?php echo "nombre de plat acheté  "." : ".$nombre_de_plat ;?></p>
    <p><?php echo "prix unitaire "." : ".$montant_du_plat." Francs " ;?></p>
    <p><?php echo "prix total  "." : ".$prix_total_d_un_plat." Francs " ;?></p>
    

</div>
<?php
    }

    
    session_start() ;
 
    $identifiant_unique = $_SESSION["identifiant"]   ;
    
    require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

    $ma_base_de_donnee = new interaction() ; ///creation d un objet
    $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
  
  
    require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
    $simplificateur = new Simplificateur_de_syntaxe("formulaire_de_suivi_de_commande") ; //creation d un objet qui va m aider a creer ma liste de presence
    
              
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
    <title>Suivi de Commande</title>
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
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="page_de_l_utilisateur.php">Home</a>
                    </li>
                 
                    <li class="nav-item">
                       <a class="btn btn-warning" href="#">Log out</a>
                    </li>

                </ul>
                
            </div>
            <div class="ecriture">
                <?php echo  "Hey , ".$nom_de_l_utilisateur ; ?>
            </div>
        </div>
       
    </nav>
    <div class="Titre"><h1 class="text-center ">TES COMMANDES AU ZEDUC SP@CE</h1></div>
    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center mt-4">PRESENTATION DES COMMANDES</h2>
        <p class="text-center">suivez toutes vos commandes faites au zeduc space en toute sécurité</p>
        
        <div class="fidelity-section">

        <?php

            
              $recherche_id_commande = $ma_base_de_donnee->connexion->prepare("SELECT id_commande FROM commandes WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
              $recherche_id_commande->bind_param("i",$identifiant_unique) ;//remplissage de parametre
              $simplificateur->execute_la_recherche( $recherche_id_commande) ; //cette methode me permet d executer ma requete de  recherche
              $tableau_id_commande =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_id_commande,"id_commande") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
              $nbre_total_de_commande = count($tableau_id_commande) ; //cette variable me permet d avoir le nombre de commande d un utilisateur
            

              for ($i = 0 ; $i<=($nbre_total_de_commande-1) ; $i++){ //cette boucle va me permettre de traiter toutes mes commandes
                        
                        $id_commande =  $tableau_id_commande[$i] ;//cette ligne me permet de récupérer chaque identifiant de commande

                        $recherche_nombre_lignes = $ma_base_de_donnee->connexion->prepare("
                            SELECT COUNT(*) AS nombre_lignes 
                            FROM commandes 
                            WHERE id_commande = ? 
                        ");

                        // Remplissage du paramètre
                        $recherche_nombre_lignes->bind_param("s", $id_commande);

                        // Exécution de la requête
                        $simplificateur->execute_la_recherche($recherche_nombre_lignes);

                        // Récupération du résultat
                        $resultat = $recherche_nombre_lignes->get_result();
                        $ligne = $resultat->fetch_assoc();
                        $nombre_lignes = $ligne['nombre_lignes'];
               
                  for($j=0 ;$j <= ($nombre_lignes-1) ;$j++){  

                    $recherche_date_de_commande = $ma_base_de_donnee->connexion->prepare("SELECT date_de_commande FROM commandes WHERE  id_commande = ?  ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                    $recherche_date_de_commande->bind_param("s", $id_commande) ;//remplissage de parametre
                    $simplificateur->execute_la_recherche(  $recherche_date_de_commande) ; //cette methode me permet d executer ma requete de  recherche
                    $tableau_de_date_de_commande =   $simplificateur->stocke_le_resultat_de_la_requete(   $recherche_date_de_commande,"date_de_commande") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                    $date_de_commande =  $tableau_de_date_de_commande[0] ; //je garde la date de ma commande        
    
                    $recherche_du_montant_total = $ma_base_de_donnee->connexion->prepare("SELECT montant_total FROM commandes WHERE  id_commande = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                    $recherche_du_montant_total->bind_param("s", $id_commande) ;//remplissage de parametre
                    $simplificateur->execute_la_recherche($recherche_du_montant_total) ; //cette methode me permet d executer ma requete de  recherche
                    $tableau_de_montant_total =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_du_montant_total,"montant_total") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                    $montant_du_plat =   $tableau_de_montant_total[$j] ; //je récupère le montant de chaque plat a chaque commande
    
                    $recherche_de_l_id_plat = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM commandes WHERE  id_commande = ?  ;  ");
                    $recherche_de_l_id_plat->bind_param("s", $id_commande) ;//remplissage de parametre
                    $simplificateur->execute_la_recherche(  $recherche_de_l_id_plat);
                    $tableau_d_id_plat = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id_plat, "id_plat");
                    $id_plat =  $tableau_d_id_plat[$j] ;//je récupère un identifiant spécifique de plat
                   
                    $recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT nom_du_plat FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                    $recherche_du_plat->bind_param("i",$id_plat) ;
                    $simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
                    $tableau_nom_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"nom_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                    $nom_du_plat = $tableau_nom_du_plat[0] ; //je garde le nom spécifique de ce plat
    
                    $recherche_du_nombre_de_plat = $ma_base_de_donnee->connexion->prepare("SELECT nombre_de_plat FROM commandes WHERE  id_commande = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                    $recherche_du_nombre_de_plat->bind_param("s", $id_commande) ;//remplissage de parametre
                    $simplificateur->execute_la_recherche($recherche_du_nombre_de_plat) ; //cette methode me permet d executer ma requete de  recherche
                    $tableau_du_nombre_de_plat =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_du_nombre_de_plat,"nombre_de_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                    $nombre_de_plat = $tableau_du_nombre_de_plat[$j] ; //je récupère le montant de chaque plat a chaque commande
    
                    $prix_total_d_un_plat = ($montant_du_plat*$nombre_de_plat) ; //ceci me permet d avoir le prix total d un plat
                    affiche_la_commande( $id_commande, $date_de_commande, $nom_du_plat , $montant_du_plat , $nombre_de_plat ,  $prix_total_d_un_plat) ; //affichage de l historique de commandes

                   // affiche_la_commande( $id_commande, $date_de_commande, $nom_du_plat , $montant_du_plat) ; //affichage de l historique de commandes
                

                  }

               
              
               
              
                //après l affichage de ma commande je regarde dans le futur pour voir mon identifiant va changer

              


              }//fin de cette boucle va me permettre de traiter toutes mes commandes
             



            
             




             
            
                            
           
           
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