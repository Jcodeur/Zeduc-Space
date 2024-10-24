<?php 


require "pop_pup.php" ;
session_start() ;

if (isset($_SESSION["avertissement"])){
    
    $avertissement = $_SESSION["avertissement"] ;
    appelle_pop_pup($avertissement,"gestion_du_menu_administrateur.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
                    
}

require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

$ma_base_de_donnee = new interaction() ; ///creation d un objet
$ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée

require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
$simplificateur = new Simplificateur_de_syntaxe("gestion_du_menu_administrateur") ; //creation d un objet qui va m aider a creer ma liste de presence


$identifiant_unique = $_SESSION["identifiant"]   ;

$recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_administrateur FROM administrateur WHERE id_administrateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
$recherche_du_nom_utilisateur->bind_param("i",$identifiant_unique) ;
$simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
$tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_administrateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
$nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
          

 

  function affiche_le_plat($chaine_id_plat,$nom_du_plat){
?>
<div class="form-check">
    <input class="form-check-input" type="checkbox" name=<?php echo "plat_".$chaine_id_plat ;?>  id=<?php echo "plat_".$chaine_id_plat ;?>>

    <label class="form-check-label" for=<?php echo "plat_".$chaine_id_plat ;?>><?php echo $nom_du_plat ;?></label>
</div>
<?php 
  }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEDUC SP@CE GAME</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="GMenu.css">
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
               <?php echo "Hey ,  ".$nom_de_l_utilisateur ; ?>
            </div>
        </div>
    </nav>
 

    <div class="Titre"> <h1 class="text-center">GESTION DU MENU</h1></div>

    <!-- Main Content -->
    <div class="container mt-5">
        <p class="text-center"></p>
    
        <div class="row">
            <div class="col-md-12 mb-12 lg-12">
                <div class="card mb-6">
                    <div class="card-header custom-card-header text-white text-center"> <!-- Classe CSS personnalisée -->
                        <h5>Modification d'un plat</h5>
                    </div>
                    <div class="choice">
                        <form class="list-choice" method="post" action="backend_de_mise_a_jour_du_menu_administrateur.php">
                            
		            <?php 
                                                
                        $recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats  ");
                        $simplificateur->execute_la_recherche( $recherche_de_l_id);
                        $tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");

                        foreach ($tableau_d_identifiant as $id_plat) {
                          
                            $chaine_d_id_plat = strval($id_plat) ; //je convertis l identifiant de chacun de mes plats qui sont des entiers en chaine de caractère

                            $recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                            $recherche_du_plat->bind_param("i",$id_plat) ;
                            $simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
                            $tableau_nom_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"nom_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                            $nom_du_plat =  $tableau_nom_du_plat[0] ; //recuperation du nom de l ecran
                            
                            affiche_le_plat($chaine_d_id_plat,$nom_du_plat) ; //j affiche la liste de plat
                        }


                    ?>
                       
                            <button type="submit" class="btn btn-primary mt-3">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
      
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





