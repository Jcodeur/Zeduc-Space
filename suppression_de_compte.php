<?php

if (isset($_POST["employer_supprimer"])){

    $valeur_a_supprimer= $_POST["employer_supprimer"] ;

    require "interaction_sur_la_base_de_donnee.php";//appel d un fichier contenant une classe qui a des methodes qui vont nous permettre d interagir su sur la BD
    $ma_base_de_donnee = new interaction() ;//recuperation de ma classe qui va me permettre d interagir dans une bd je la stocke dans une variable
    $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
  
    require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
    $simplificateur = new Simplificateur_de_syntaxe("formulaire_d_administrateur_de_gestion_d_employe") ; //creation d un objet qui va m aider a creer ma liste de presence
    
    $supprime_le_nom = $ma_base_de_donnee->connexion->prepare("DELETE FROM employes  WHERE email = ? ; ") ; //cette requete me permet de modifier mon email
    $supprime_le_nom->bind_param("s",$valeur_a_supprimer) ;//remplissage des parametres en question
    $simplificateur->execute_la_recherche( $supprime_le_nom) ; //cette methode me permet d executer ma requete de  recherche

    $_SESSION["avertissement"] = "vous avez supprimer le compte de  ".$_POST["employer_supprimer"] ;

    
    echo '<script type="text/javascript">
        window.location.href = "formulaire_d_administrateur_de_gestion_d_employe.php";
      </script>';

}



?>