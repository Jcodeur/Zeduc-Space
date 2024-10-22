<?php

	require "pop_pup.php" ;
	session_start() ;

	if (isset($_SESSION["avertissement"])){
		
		$avertissement = $_SESSION["avertissement"] ;
		appelle_pop_pup($avertissement,"page_de_l_utilisateur.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
						
	}

	$identifiant_unique = $_SESSION["identifiant"]   ;

?>

				
<?php
  function affiche_le_plat($nom_du_plat,$nom_de_la_photo_du_plat,$prix_du_plat,$description,$id_plat){
?>

<div class="col-md-4 mb-4">
    <div class="card">
        <img src="<?php echo $nom_de_la_photo_du_plat ; ?>" class="card-img-top" alt="Produit 1">
            <div class="card-body">
              <h5 class="card-title"><?php echo $nom_du_plat ; ?></h5>
              <p class="card-text"><?php echo $description ; ?></p>
              <p class="text-warning"><?php echo $prix_du_plat ; ?></p>
              <a  id="<?php echo $id_plat ; ?>"  class="btn btn-warning">Commander</a>
            </div>
    </div>
</div>
				
<?php
  }
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
    <title>Menu - Zeduc-Space</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Menu.css">
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
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_commande.php">Voir Le Panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_reclamation.php">Ecrire une réclamation</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Autres
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="formulaire_d_evenement.php">Événement</a></li>
                            <li><a class="dropdown-item" href="formulaire_de_fidelite.php">Programme de fidélité</a></li>
                            <li><a class="dropdown-item" href="formulaire_de_suivi_de_commande.php">Historique des commandes</a></li>
                            <li><a class="dropdown-item" href="formulaire_de_jeu.php">Jeux</a></li>
                            <li><a class="dropdown-item" href="formulaire_des_meilleurs_clients.php">10 Meilleurs clients</a></li>
                            <li><a class="dropdown-item" href="formulaire_d_information_personnelle.php">informations sur mon compte personnelle</a></li>

                        </ul>
                    </li>
                </ul>
                <a class="btn btn-warning" href="#">Logout</a>
            </div>
                
			<div class="ecriture"><p> <h6 style ="color :white; ">Bienvenue sur Zeduc Space </h6> <?php echo$nom_de_l_utilisateur ;?> </div></p>
			
        </div>
        
    </nav>
    
    <div class="Titre">
        <h1 class="text-center mb-4">Menu </h1>
        <h3> ZEDUC-SP@CE la Gastronomie à petit prix </h3>
    </div>
    <!-- Menu Section -->
    <div class="container my-5">
        <div class="row">
       

	
		<?php 
						
			$recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats  ");
			$simplificateur->execute_la_recherche( $recherche_de_l_id);
			$tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");

			foreach ($tableau_d_identifiant as $id_plat) {

			$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
			$recherche_du_plat->bind_param("i",$id_plat) ;
			$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
			$tableau_nom_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"nom_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
			$nom_du_plat =  $tableau_nom_du_plat[0] ; //recuperation du nom de l ecran
			
			$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
			$recherche_du_plat->bind_param("i",$id_plat) ;
			$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
			$tableau_photo_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"photo_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
			$nom_de_la_photo_du_plat =  $tableau_photo_du_plat[0] ; //recuperation du nom de l ecran
			
				
			$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
			$recherche_du_plat->bind_param("i",$id_plat) ;
			$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
			$tableau_prix_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"prix") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
			$prix_du_plat =  $tableau_prix_du_plat[0] ; //recuperation du nom de l ecran
			
			$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
			$recherche_du_plat->bind_param("i",$id_plat) ;
			$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
			$tableau_de_description_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"description") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
			$description =  $tableau_de_description_du_plat[0] ; //recuperation du nom de l ecran
			
			affiche_le_plat($nom_du_plat,$nom_de_la_photo_du_plat,$prix_du_plat,$description,$id_plat) ;
			
			}
						
		?>
        
      
      
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
    <script>
                // Fonction pour créer un cookie avec un nom, une valeur et un délai d'expiration
                function setCookie(name, value, days) {
                    var expires = "";
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                        expires = "; expires=" + date.toUTCString();
                    }
                    document.cookie = name + "=" + (value || "") + expires + "; path=/";
                }

                // Fonction pour obtenir la valeur d'un cookie par son nom
                function getCookie(name) {
                    var nameEQ = name + "=";
                    var ca = document.cookie.split(';');
                    for (var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                    }
                    return null;
                }

                // Récupérer tous les éléments qui ont un attribut "id"
                var elements_avec_id = document.querySelectorAll('[id]');

                // Boucle pour parcourir chaque élément
                elements_avec_id.forEach(element => {
                    // Ajouter un EventListener pour détecter le clic sur chaque élément
                    element.addEventListener('click', function() {
                        // Convertir l'ID de l'élément en chaîne de caractères
                        var id_as_string = String(element.id);

                        // Afficher l'ID de l'élément cliqué dans la console
                        if (!isNaN(id_as_string)) { // Si l'ID est un nombre après conversion

                            console.log("ID de l'élément cliqué :", id_as_string);

                            // Vérifier si un cookie existe déjà pour cet élément
                            var valeur_du_cookie = getCookie(id_as_string);

                            // Si le cookie n'existe pas, on initialise à 1, sinon on incrémente la valeur
                            if (valeur_du_cookie === null) {
                                valeur_du_cookie = 1; // Initialiser à 1 si le cookie n'existe pas encore
                                alert("Le plat numéro : " + id_as_string + " a été ajouté"); // Ceci informe l'utilisateur
                            } else {
                                valeur_du_cookie = parseInt(valeur_du_cookie) + 1; // Incrémenter la valeur si le cookie existe
                                alert("Le plat numéro : " + id_as_string + " a été ajouté au panier"); // Signalement à l'utilisateur
                            }

                            // Enregistrer le cookie avec l'ID de l'élément comme nom et la valeur incrémentée
                            setCookie(id_as_string, valeur_du_cookie, 1);

                            // Afficher dans la console la nouvelle valeur du cookie
                            console.log("Nouvelle valeur du cookie pour", id_as_string, ":", valeur_du_cookie);

                        } else {
                            console.log("L'ID n'est pas un nombre.");
                        }
                    });
                });
                
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



