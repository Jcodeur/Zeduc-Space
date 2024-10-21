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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEDUC SP@CE EVENTS</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="evenement/Event.css">
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
                  
                </ul>
                <a class="btn btn-warning" href="#">Log out</a>
            </div>
            <div class="ecriture">
                <?php echo "Hey , ".$nom_de_l_utilisateur ;?>
            </div>
        </div>
    </nav>
    <div class="Titre"> <h1 class="text-center">BIENVENUE A  ZEDUC SP@CE EVENTS</h1></div>
    
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="search"><input type="text" id="searchBar" class="form-control" placeholder="Search..."></div>
        </div>
        <br>
        <br>
        <br>
        <div class="col-md-3 mb-4">
            <div class="card1">
                <h4>Catégories</h4>
                <div class="choice">
                    <input type="checkbox" class="category-filter" name="category" value="Hebdomadaire"> Hebdomadaire<br>
                    <input type="checkbox" class="category-filter" name="category" value="Mensuel"> Mensuel<br>
                    <input type="checkbox" class="category-filter" name="category" value="Noël"> Noël<br>
                    <input type="checkbox" class="category-filter" name="category" value="Spécial"> Spécial<br>
                    <input type="checkbox" class="category-filter" name="category" value="Autres"> Autres
                </div>
                
            </div>
        </div>
    </div>

    
    <!-- Main Content -->
    <div class="container my-5">
        <div class="row" id="eventsContainer"> 
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
    
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="evenement/Eventjs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
