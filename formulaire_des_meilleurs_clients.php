<?php
  
  session_start() ;

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

<?php
   function sommeTableau($tableau) { //cette methode va me permettre de fa
     return array_sum($tableau);
   }


   function topDixUtilisateurs($tableau_de_personne_avec_le_total_de_plat_consomme) {
        // Trier le tableau en fonction de 'nombre_total_de_plat_consomme' dans l'ordre décroissant
        usort($tableau_de_personne_avec_le_total_de_plat_consomme, function ($a, $b) {
            return $b['nombre_total_de_plat_consomme'] - $a['nombre_total_de_plat_consomme'];
        });
        
        // Garder uniquement les dix premiers éléments
        $topDix = array_slice($tableau_de_personne_avec_le_total_de_plat_consomme, 0, 10);
        
        return $topDix;
   }

?>

<?php 
function affichage_meilleur_client($nom_de_mon_client,$nombre_de_plat_du_client){
?>
<div class="fidelity-card">
    <h3 id=""><?php echo $nom_de_mon_client ; ?></h3>
    <p id=""><?php echo $nombre_de_plat_du_client." Plat à son actif " ; ?></p>

</div>
<?php 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos meilleurs clients</title>
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
                <?php echo "Hey ,  ".$nom_de_l_utilisateur ; ?>
            </div>
        </div>
       
    </nav>
    <div class="Titre"><h1 class="text-center ">NOS MEILLEURS CLIENTS</h1></div>
    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center mt-4">PRESENTATION DE NOS CLIENTS</h2>
        <p class="text-center">Ici vous trouverez la liste de nos 10 meilleurs clients :</p>
        
        <div class="fidelity-section">

         <?php
             
            $recherche_de_tous_les_utilisateurs = $ma_base_de_donnee->connexion->prepare("SELECT id_utilisateur FROM utilisateurs ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
            $simplificateur->execute_la_recherche( $recherche_de_tous_les_utilisateurs) ; //cette methode me permet d executer ma requete de  recherche
            $tableau_de_tous_les_utilisateurs =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_de_tous_les_utilisateurs,"id_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
            $tableau_de_personne_avec_le_total_de_plat_consomme = [] ; //ce tableau me permettra de contenir le nom des personnes avec le nbre de plat qu ils ont déjà acheté

            foreach ($tableau_de_tous_les_utilisateurs as $id_specifique_d_un_utilisateur) {
                
                
                $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_d_utilisateur FROM utilisateurs WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                $recherche_du_nom_utilisateur->bind_param("i", $id_specifique_d_un_utilisateur) ;
                $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
                $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_d_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
                      
                $recherche_du_nombre_de_commande = $ma_base_de_donnee->connexion->prepare("SELECT nombre_de_plat FROM commandes WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                $recherche_du_nombre_de_commande->bind_param("i",$id_specifique_d_un_utilisateur) ;
                $simplificateur->execute_la_recherche( $recherche_du_nombre_de_commande) ; //cette methode me permet d executer ma requete de  recherche
                $tableau_du_nombre_de_commande = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nombre_de_commande,"nombre_de_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                $nombre_total_de_plat_consomme = sommeTableau( $tableau_du_nombre_de_commande ) ; //cette variable va me permettre de compter le nombre de plat consommer par une personne
                
                   
                $tableau_de_personne_avec_le_total_de_plat_consomme[$id_specifique_d_un_utilisateur] = [
                  
                    "nom_de_l_utilisateur" =>  $nom_de_l_utilisateur,
                    "nombre_total_de_plat_consomme" =>   $nombre_total_de_plat_consomme
                    
                ] ;

            }

            $tableau_de_personne_avec_le_total_de_plat_consomme  = topDixUtilisateurs($tableau_de_personne_avec_le_total_de_plat_consomme) ; //cette méthode va me permettre de classer un tableau avec dix meilleurs nombres de plats
           
            foreach ($tableau_de_personne_avec_le_total_de_plat_consomme  as $personne_avec_le_total_de_plat_consomme) {
                
                affichage_meilleur_client($personne_avec_le_total_de_plat_consomme["nom_de_l_utilisateur"],$personne_avec_le_total_de_plat_consomme["nombre_total_de_plat_consomme"]) ;

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