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
    <title>Page de Fidélité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fidelite/fidelite.css">
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
                <?php echo "Hey , ".$nom_de_l_utilisateur?>
            </div>
        </div>
       
    </nav>
    <div class="Titre"><h1 class="text-center ">ZEDUC SP@CE LOYALTY</h1></div>
    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center mt-4">QU’EST CE QUE LES POINTS DE FIDÉLITÉS</h2>
        <p class="text-center">Les points de fidélité sont un système de récompense mis en place pour encourager les étudiants à passer régulièrement des commandes et à participer aux activités du restaurant :</p>
        
        <div class="fidelity-section">
            <div class="fidelity-card">
                <h3>Passer Une Commande</h3>
                <p>Chaque commande effectuée rapporte un certain nombre de points, le montant de points peut varier en fonction du total de la commande ou des offres promotionnelles en cours.</p>
            </div>
            <div class="fidelity-card">
                <h3>Commentaires sur les commandes :</h3>
                <p>Un moment convivial pour échanger et partager nos expériences généralistes.</p>
            </div>
            <div class="fidelity-card">
                <h3>Participer au programme de parrainage</h3>
                <p>Lorsqu’un étudiant utilise son code de parrainage pour inviter d’autres étudiants, il gagne des points supplémentaires chaque fois qu’un filleul passe une commande.</p>
            </div>
            <div class="fidelity-card">
                <h3>Participer Aux Jeux Et Événements</h3>
                <p>Le restaurant organise des mini-jeux ou des événements pour les étudiants, leur permettant de gagner des points supplémentaires en fonction de leur performance ou de leur participation.</p>
                <button class="visit-btn">Visiter</button>
            </div>
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
