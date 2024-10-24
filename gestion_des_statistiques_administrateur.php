
<?php

  session_start() ; //je démarre ma session

  
  $identifiant_unique = $_SESSION["identifiant"]   ;
  

  require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

  $ma_base_de_donnee = new interaction() ; ///creation d un objet
  $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée


  require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
  $simplificateur = new Simplificateur_de_syntaxe("gestion_des_statistiques_administrateur") ; //creation d un objet qui va m aider a creer ma liste de presence
  
  function sommeTableau($tableau) { //cette methode va me permettre de fa
    return array_sum($tableau);
  }


  $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_administrateur FROM administrateur WHERE id_administrateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
  $recherche_du_nom_utilisateur->bind_param("i",$identifiant_unique) ;
  $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
  $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_administrateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
  $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
        

?>

<?php
function affichage_des_statistiques($nom_du_produit,$quantite_du_produit,$pourcentage_de_vente_du_produit){

?>
<tr id="ligne1">
    <td><?php echo $nom_du_produit ; ?></td>
    <td><?php echo $quantite_du_produit ; ?></td>
    <td><?php echo $pourcentage_de_vente_du_produit."  %" ; ?></td>       
</tr>

<?php
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte - ZEDUC-SP@CE</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="DailyStat.css">
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
                    <?php echo  "Hey , ".$nom_de_l_utilisateur ;?>
                </div>
            </div>
        </nav>
    <div class="Titre"><h2  class="text-center" >STATISTIQUES JOURNALIERE </h2></div>
    </header>

    <main class="container my-5">
        <section class="text-center mb-5">
            
            <h3> RECAPITULATIF </h3>
            <hr class="w-50 mx-auto">
        </section>
        
    </main>
    <br>
    <br>
    

    <div class="container my-5">
        <div class="Dailystat">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nom du plat</th>
                        <th>Qte passé en commande</th>
                        <th>Pourcentage de vente du produit</th>
                      
                    </tr>
                </thead>
                <tbody>
                   

                        <?php
            
                           			
                            $recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats  ");
                            $simplificateur->execute_la_recherche( $recherche_de_l_id);
                            $tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");

                            foreach ($tableau_d_identifiant as $id_plat) {

                                $recherche_nombre_de_plat = $ma_base_de_donnee->connexion->prepare("SELECT nombre_de_plat FROM commandes WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                                $recherche_nombre_de_plat->bind_param("i", $id_plat) ;
                                $simplificateur->execute_la_recherche( $recherche_nombre_de_plat) ; //cette methode me permet d executer ma requete de  recherche
                                $tableau_nombre_de_plat =   $simplificateur->stocke_le_resultat_de_la_requete(  $recherche_nombre_de_plat,"nombre_de_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                                $nombre_total_d_un_plat_specifique =   sommeTableau(  $tableau_nombre_de_plat ) ; //cette variable va me permettre de compter le nombre de plat consommer par une personne
                                
                                $recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT nom_du_plat FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                                $recherche_du_plat->bind_param("i",$id_plat) ;
                                $simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
                                $tableau_nom_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"nom_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                                $nom_du_plat =  $tableau_nom_du_plat[0] ; //recuperation du nom de l ecran
                                
                                //ensuite je sélectionne tous les plats pour obtenir leur nombre total
                                $recherche_nombre_de_plat_total = $ma_base_de_donnee->connexion->prepare("SELECT nombre_de_plat FROM commandes ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                                $simplificateur->execute_la_recherche(  $recherche_nombre_de_plat_total) ; //cette methode me permet d executer ma requete de  recherche
                                $tableau_nombre_de_plat_total =   $simplificateur->stocke_le_resultat_de_la_requete(   $recherche_nombre_de_plat_total,"nombre_de_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                                $nombre_de_plat_total =   sommeTableau($tableau_nombre_de_plat_total) ; //cette variable va me permettre de compter le nombre de plat consommer par une personne
                                
                                if($nombre_de_plat_total !== 0){
                                  
                                 $pourcentage_de_vente_du_plat = ($nombre_total_d_un_plat_specifique/$nombre_de_plat_total)*100 ; //ceci représente le pourcentage de vente du plat
                                 affichage_des_statistiques( $nom_du_plat, $nombre_total_d_un_plat_specifique, $pourcentage_de_vente_du_plat) ; //l appel de cette fonction me permet d afficher les statistiques de ventes
                                    

                                }

                               
                            }
                            

                        
                
                
                                
                        ?>
                   
                   
                    <tr class="total-row">
                        <td colspan="6" class="text-end">Nombre Total de Plats :<?php echo "   ".$nombre_de_plat_total ;?></td>
                    </tr>
                </tbody>
            </table>
           
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
