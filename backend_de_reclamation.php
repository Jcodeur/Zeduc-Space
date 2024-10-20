<?php

    session_start() ; //je démarre ma session pour pouvoir récupérer des données

   
    if (isset($_POST["reclame"]) ){
         
        //recuperation de l identifiant de l utilisateur 
        $identifiant_unique = $_SESSION["identifiant"]   ;

        //recuperation des valeurs
        $type_de_la_reclamation = $_POST["type"] ; //recuperation du type de la réclamation
        $titre_de_la_reclamation = $_POST["titre"] ; //recuperation du titre de la réclamation
        $commentaire_de_la_reclamation = $_POST["commentaire"] ; //recuperation du commentaire lors de la réclamation
                
        //une fois les donnees recuperer et filtrer je les insere dans ma base donnee
        require "interaction_sur_la_base_de_donnee.php";//appel d un fichier contenant une classe qui a des methodes qui vont nous permettre d interagir su sur la BD
        $ma_base_de_donnee = new interaction() ;//recuperation de ma classe qui va me permettre d interagir dans une bd je la stocke dans une variable
        $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
        
        require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
        $simplificateur = new Simplificateur_de_syntaxe("formulaire_de_reclamation") ; //creation d un objet qui va m aider a creer ma liste de presence
        
        
        require "verification_d_un_formulaire.php" ;//je recupere le fichier qui contient ma classe de verification d email
            
        $verificateur = new verification_de_ce_formulaire("formulaire_de_reclamation") ;//creation de l objet de cette classe en question
        $verificateur->case_vide( $type_de_la_reclamation,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case nom vide
        $verificateur->case_vide(  $titre_de_la_reclamation ,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case prenom vide
        $verificateur->case_vide($commentaire_de_la_reclamation,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case email vide
        
        $insertion_de_reclamation = $ma_base_de_donnee->connexion->prepare("INSERT INTO reclamation(id_utilisateur,type,titre,commentaire) VALUES (?,?,?,?) ;") ;
        $insertion_de_reclamation->bind_param("isss",   $identifiant_unique,
        $type_de_la_reclamation,
        $titre_de_la_reclamation ,
        $commentaire_de_la_reclamation

        ) ;  //remplissage de parametre
        $simplificateur->execute_la_recherche($insertion_de_reclamation) ; //cette methode me permet d executer ma requete de  recherche
        //creation d une session qui va me permettre de sauvegarder les variables

        $_SESSION["avertissement"] = "votre réclamation a été pris en compte" ;

        header("Location:page_de_l_utilisateur.php");//redirection de ma page vers la page de connexion
        exit();//fermeture de la redirection


    }





?>