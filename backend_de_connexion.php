<?php

session_start() ; //ouverture de la session
      
if (isset($_POST["mail"]) && isset($_POST["mot_de_passe"]) ){

  require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée
  $ma_base_de_donnee = new interaction() ; ///creation d un objet
  $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée

  $email = $_POST["mail"] ;/// recuperation de l email
  $mot_de_passe = $_POST["mot_de_passe"] ;//recuperation du mot de passe
  
  require "verification_d_un_formulaire.php" ;//je recupere le fichier qui contient ma classe de verification d email
  
  $verificateur = new verification_de_ce_formulaire("formulaire_de_connexion") ;//creation de l objet de cette classe en question
  $verificateur->case_vide($email,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case email vide
  $verificateur->case_vide($mot_de_passe,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case mot de passe vide

  require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
  $simplificateur = new Simplificateur_de_syntaxe("formulaire_de_connexion") ; //creation d un objet qui va m aider a creer ma liste de presence
  
  $recherche_de_l_utilisateur = $ma_base_de_donnee->connexion->prepare("SELECT * FROM utilisateurs WHERE email = ? ; ") ; //recherche de l utilsateur dans ma requete preparer
  $recherche_de_l_utilisateur->bind_param("s",$email) ;//chargement  des parametres dans ma requetes preparés
  $simplificateur->execute_la_recherche($recherche_de_l_utilisateur) ; //cette methode me permet d executer ma requete de  recherche
  $tableau_d_utilisateur =  $simplificateur->stocke_le_resultat_de_la_requete($recherche_de_l_utilisateur,"mot_de_passe") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
  $mot_de_passe_de_la_BD = $tableau_d_utilisateur[0] ;//recuperation du mot de passe 

  require "hachage_d_un_mot_de_passe.php";//appel du fichier qui permet d utiliser le hache
  $hacheur = new hachage() ;//appel de ma classe
  $mot_de_passe_hacher = $hacheur->cryptage($mot_de_passe) ; //ceci est une methode pour crypter mon mot de passe

  $mon_identifiant_unique = $ma_base_de_donnee->connexion->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ? ; ") ; //requete permettant de rechercher mon identifiant
  $mon_identifiant_unique->bind_param("s",$email) ; //remplissage du parametre
  $simplificateur->execute_la_recherche($mon_identifiant_unique) ; //cette methode me permet d executer ma requete de  recherche
  $tableau_de_mon_identifiant_unique =  $simplificateur->stocke_le_resultat_de_la_requete($mon_identifiant_unique,"id_utilisateur") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
  $identifiant_unique =  $tableau_de_mon_identifiant_unique[0] ;//recuperation du mot de passe 

  if( $mot_de_passe_hacher == $mot_de_passe_de_la_BD){//comparaison de si mot de passe que l utilsateur entre est egale au mot de passe qui est dans ma base de donnée
    
    session_start() ; //recuperation de la session en question
    session_unset() ; //suppression des données de la session
    session_destroy() ; //destruction de la session

    session_start() ;//ouverture de la session
    $_SESSION["email"] = $email ; //stockage de mon email
    $_SESSION["identifiant"] =  $identifiant_unique ; //stockage de mon identifiant unique et non modifiable

    header("Location:page_de_l_utilisateur.php"); //redirection vers la meme page
    exit();//fermeture de la redirection
              
  }else{//cas contraire
    
    session_start() ;//ouverture de la session
    $_SESSION["formulaire_email"] = $email ; //stockage de mon email
    $_SESSION["formulaire_mot_de_passe"] =  $mot_de_passe ; //je stocke le mot de passe que j ai utilisé

    $_SESSION["avertissement"] = "email ou mot de passe erronée" ;
    header("Location:formulaire_de_connexion.php"); //redirection vers la meme page
    exit();//fermeture de la redirection

  }//fin du if 


}

//fermeture de la balise php





?>