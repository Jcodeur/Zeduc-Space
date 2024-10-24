<?php
   

    require "pop_pup.php" ;
	session_start() ;

	$identifiant_unique = $_SESSION["identifiant"]   ;

    if (isset($_SESSION["avertissement"])){
		
		$avertissement = $_SESSION["avertissement"] ;
		appelle_pop_pup($avertissement,"formulaire_de_commande.php") ; //cette fonction me permet d afficher mon pup pop et de rediriger ma page apres la fermeture du pop pup 
						
	}
    
    require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

    $ma_base_de_donnee = new interaction() ; ///creation d un objet
    $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
  
  
    require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
    $simplificateur = new Simplificateur_de_syntaxe("formulaire_de_commande") ; //creation d un objet qui va m aider a creer ma liste de presence
    	
						
    $recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats ;");
    $simplificateur->execute_la_recherche( $recherche_de_l_id);
    $tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");

    $tableau_de_commande = [] ; //ceci est un tableau associatif dont je vais me servir pour garder les différentes commandes d un utilisateur

    foreach ($tableau_d_identifiant as $id_plat) {
        
        $chaine_de_caractere_de_id_plat = strval($id_plat) ; //ceci me permet de convertir l identifiant de mon plat qui est un entier en chaine de caractère

        if(isset($_COOKIE[$chaine_de_caractere_de_id_plat])){ //je vérifie tous les plats que les utilisateurs ont eu passer en commande 
            
           $tableau_de_commande[$chaine_de_caractere_de_id_plat] = $_COOKIE[$chaine_de_caractere_de_id_plat] ;//j enregistre les commandes de mon utilisateur dans un tableau associatif

        } // fin de si je vérifie tous les plats que les utilisateurs ont eu passer en commande 
       
    }
    
    //ici je récupère le nom d utilisateur de la personne connecté

    $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_d_utilisateur FROM utilisateurs WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
    $recherche_du_nom_utilisateur->bind_param("i",$identifiant_unique) ;
    $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
    $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_d_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
    $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
          
    
  
?>
<?php
     function affiche_la_commande ($chaine_de_caractere_de_id_plat,$nom_du_plat,$quantite_de_plat,$prix_du_plat){
?>
 <tr id="<?php echo $chaine_de_caractere_de_id_plat ;?>">
    <td><?php echo $nom_du_plat ;?></td>
    <td><?php echo $quantite_de_plat ;?></td>
    <td><?php echo $prix_du_plat ;?></td>
    <td><?php echo $prix_du_plat*$quantite_de_plat ;?></td>
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
    <link rel="stylesheet" href="Paiement.css">
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

                  
                </ul>
                <a class="btn btn-warning" href="deconnection.php">LogOut</a>
            </div>
            <div class="ecriture">
                <?php echo  "Hey , ".$nom_de_l_utilisateur ; ?>
            </div>
        </div>
    </nav>
    <div class="Titre"><h2  class="text-center" >PANIER DE COMMANDES </h2></div>
    </header>

    <main class="container my-5">
        <section class="text-center mb-5">
            
            <h3> ARTICLES DU PANIER </h3>
            <hr class="w-50 mx-auto">
        </section>
        
    </main>
    <br>
    <br>
    

    <div class="container my-5">
        <div class="Facture">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Designation</th>
                        <th>Qte</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $tableau_de_session = [] ;//ce tableau va me permettre d enregistrer toutes mes données dans un tableau que je vais transmettre dans une session
                    $prix_de_la_commande = 0 ; //ceci est une variable qui va me permettre de sauvegarder le total d une commande

                        foreach ($tableau_de_commande as $chaine_de_caractere_de_id_plat => $nbre_de_plat ) {

                            $chaine_de_caractere_de_id_plat = strval($chaine_de_caractere_de_id_plat ) ; //je convertis ma clé en chaine de caractère
                            $id_plat = intval($chaine_de_caractere_de_id_plat) ; //je reconvertie la chaine de mon identifiant en entier que je peux exploter dans mes requetes
                            
                            $recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                            $recherche_du_plat->bind_param("i",$id_plat) ;
                            $simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
                            $tableau_nom_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"nom_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                            $nom_du_plat =  $tableau_nom_du_plat[0] ; //recuperation du nom de l ecran
                            
                                
                            $recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                            $recherche_du_plat->bind_param("i",$id_plat) ;
                            $simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
                            $tableau_prix_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"prix") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                            $prix_du_plat =  $tableau_prix_du_plat[0] ; //recuperation du nom de l ecran
                            
                            $quantite_de_plat = $nbre_de_plat ; //vu que dans mon tableau associatif je garde les différentes quantité de plat

                            //en sachant que pour mille francs dépenser on un point 
                            //calculons donc le nbre de point gagné pour chaque plat

                            $nbre_de_point = ($prix_du_plat*$quantite_de_plat)/1000 ; //et nous avons donc le nombre de point gagné sur ce plat

                            //ensuite nous avons besoin de connaitre la date de la commande dans un certains formats
                                                        
                            $date = new DateTime(); //me permet d avoir la date actuelle
                            // echo $date->format("Y-m-d H:i:s");  // Affichera "2024-10-18 14:35:26"
                           
                           $tableau_de_session[$chaine_de_caractere_de_id_plat] = [

                                "id_du_plat" => $id_plat,
                                "nom_du_plat" => $nom_du_plat,
                                "prix_du_plat" => $prix_du_plat,
                                "quantite_de_plat" => $quantite_de_plat,
                                "nbre_de_point" => $nbre_de_point,
                                "date_du_jour" => $date->format("Y-m-d H:i:s")

                            ];

                            $_SESSION['plat_' . $chaine_de_caractere_de_id_plat] = $tableau_de_session[$chaine_de_caractere_de_id_plat];

                            $prix_de_la_commande += ($prix_du_plat*$quantite_de_plat) ;//ceci me permet d avoir un montant réelle de la commande
                            affiche_la_commande ($chaine_de_caractere_de_id_plat,$nom_du_plat,$quantite_de_plat,$prix_du_plat) ; //cette ligne me permet d afficher ma commande sous forme de ligne
                        }
                    ?>
                   
                  
                    <tr class="total-row">
                        <td colspan="3" class="text-end">Total :</td>
                        <td><?php echo "  ".$prix_de_la_commande." Francs" ;?></td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
              <form method="post" action="backend_de_commande.php"><input type="submit" name="commande" class="btn btn-dark mt-3" value="valider la commande"></form>
            </div>
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
</body>
</html>
