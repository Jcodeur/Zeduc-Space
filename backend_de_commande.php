<?php

    function obtenirCleUnique() { //cette fonction me permet d obtenir un idenifiant unique pour chacune de mes commandes
        return uniqid();  // Génère une clé unique
    }

   
	session_start() ;



	$identifiant_unique = $_SESSION["identifiant"]   ;
    
    
    require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

    $ma_base_de_donnee = new interaction() ; ///creation d un objet
    $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
  
  
    require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
    $simplificateur = new Simplificateur_de_syntaxe("formulaire_de_commande") ; //creation d un objet qui va m aider a creer ma liste de presence
    //echo"je suis dans le fichier" ;
    if(isset($_POST["commande"])){ //je vérifie si j appuie sur le bouton commander
  
        $recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats ; ");
        $simplificateur->execute_la_recherche( $recherche_de_l_id);
        $tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");
    
        foreach ($tableau_d_identifiant as $id_plat) {
          
            $chaine_de_caractere_de_id_plat = strval($id_plat) ; //ceci me permet de convertir l identifiant de mon plat qui est un entier en chaine de caractère
        
            if( isset($_SESSION['plat_' . $chaine_de_caractere_de_id_plat] )){ //je vérifie si un certains plat doit se trouver dans la session si ce retrouve dans la session alors il fait partir de la commande
    
                $cle_unique_de_la_commande = obtenirCleUnique(); //me permet d avoir une clé unique pour la commande
    
                $insertion_de_la_commande = $ma_base_de_donnee->connexion->prepare("INSERT INTO commandes(id_commande,id_plat,id_utilisateur,montant_total,nombre_de_point_accumuler,date_de_commande) VALUES (?,?,?,?,?,?) ;") ;
                $insertion_de_la_commande->bind_param("siisis",    $cle_unique_de_la_commande,
                $_SESSION['plat_' . $chaine_de_caractere_de_id_plat]["id_du_plat"],
                $identifiant_unique,
                $_SESSION['plat_' . $chaine_de_caractere_de_id_plat]["prix_du_plat"],
                $_SESSION['plat_' . $chaine_de_caractere_de_id_plat]["nbre_de_point"],
                $_SESSION['plat_' . $chaine_de_caractere_de_id_plat]["date_du_jour"]
                ) ;  //remplissage de parametre
                $simplificateur->execute_la_recherche( $insertion_de_la_commande) ; //cette methode me permet d executer ma requete de  recherche
                
             
                //après avoir enregistré une partie de la commande 
                //je peux supprimer une partie de la commande

                setcookie($chaine_de_caractere_de_id_plat, "", time() - 3600, "/"); //une fois enregistrer je supprime ton cookie vu que j en n aurais plus besoin

              
              
            }//fin de si je vérifie si un certains plat doit se trouver dans la session si ce retrouve dans la session alors il fait partir de la commande
            
        }
        
        
        $_SESSION["avertissement"] = "votre commande a été pris en compte merci bien" ;
        header("Location:page_de_l_utilisateur.php");//redirection de ma page vers la page de connexion
        exit();//fermeture de la redirection
           

    } // fin de je vérifie si j appuie sur le bouton commander
    			
   
				
    

  

?>