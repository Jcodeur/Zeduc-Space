<?php

  session_start() ;

  $identifiant_unique = $_SESSION["identifiant"]   ;
  
  require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

  $ma_base_de_donnee = new interaction() ; ///creation d un objet
  $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée


  require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
  $simplificateur = new Simplificateur_de_syntaxe("formulaire_de_gestion_des_commandes") ; //creation d un objet qui va m aider a creer ma liste de presence
  
  $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_employe FROM employes WHERE id_employe = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
  $recherche_du_nom_utilisateur->bind_param("i",$identifiant_unique) ;
  $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
  $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_employe") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
  $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
			
?>

<?php
function affiche_la_validite_de_la_reclamation($id_commande,$date_de_commande,$nom_utilisateur,$nom_du_plat,$montant_du_plat,$nombre_de_plat,$prix_total_d_un_plat){
?>
<div class="Commandes-card">
<p><div class="Nom"><?php echo "identifiant de la commande : ".$id_commande ; ?></div></p>
<p><div class="Contenu"><?php echo "date de la commande : ".$date_de_commande ; ?></div></p>
<p><div class="Contenu"><?php echo "nom du client : ".$nom_utilisateur ; ?></div></p>
<p><div class="Contenu"><?php echo "nom du plat : ".$nom_du_plat ; ?></div></p>
<p><div class="Contenu"><?php echo "montant du plat  : ".$montant_du_plat ; ?></div></p>
<p><div class="Contenu"><?php echo "nombre de plat :  ".$nombre_de_plat ; ?></div></p>
<p><div class="Contenu"><?php echo "prix total :  ".$prix_total_d_un_plat ; ?></div></p>

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
    <title>Gestion Des Commandes</title>
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
                      <a class="nav-link" href="#" style="color: gold;"><?php echo "Hey, " . $nom_de_l_utilisateur; ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_gestion_des_commandes.php">Commandes</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_mise_a_jour_du_menu.php">Mises à jour du menu</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="formulaire_de_validation_reclamation.php">Réclamations Clients</a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link " href="formulaire_de_statistique.php" >  Statistiques  </a> 
                    </li>
                    
                    <li class="nav-item">
                       <a class="btn btn-warning" href="#">LogOut</a>
                    </li>
                   
                </ul>
                
            </div>
            <div class="ecriture">
                <?php echo  "Hey , ".$nom_de_l_utilisateur ;?>
            </div>
        </div>
    </nav>
    <div class="Titre"><h1 class="text-center "> GESTION DE COMMANDE UTILISATEUR </h1></div>
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
       
                        $recherche_id_commande = $ma_base_de_donnee->connexion->prepare("SELECT id_commande FROM commandes ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
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

                                    $recherche_id_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT id_utilisateur FROM commandes WHERE  id_commande = ?  ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                                    $recherche_id_utilisateur->bind_param("i", $id_commande) ;//remplissage de parametre
                                    $simplificateur->execute_la_recherche(    $recherche_id_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
                                    $tableau_d_id_utilisateur = $simplificateur->stocke_le_resultat_de_la_requete(     $recherche_id_utilisateur,"id_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                                    $id_utilisateur = $tableau_d_id_utilisateur[0] ; //je garde le nom de la commande        
                                            
                                    $recherche_du_nom_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT nom_d_utilisateur FROM utilisateurs WHERE id_utilisateur = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
                                    $recherche_du_nom_utilisateur->bind_param("i",$id_utilisateur) ;
                                    $simplificateur->execute_la_recherche($recherche_du_nom_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
                                    $tableau_nom_de_l_utilisateur =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_nom_utilisateur,"nom_d_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
                                    $nom_de_l_utilisateur =  $tableau_nom_de_l_utilisateur[0] ; //recuperation du nom de l ecran
                                            
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
                                   
                                    affiche_la_validite_de_la_reclamation($id_commande,$date_de_commande,$nom_de_l_utilisateur,$nom_du_plat,$montant_du_plat,$nombre_de_plat,$prix_total_d_un_plat) ; //affichage des commandes

                            }

                        

                        

                        //après l affichage de ma commande je regarde dans le futur pour voir mon identifiant va changer




                        }//fin de cette boucle va me permettre de traiter toutes mes commandes              


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