<?php

function visibilite_du_plat($chaine_d_id_plat){

    if(isset($chaine_d_id_plat)){
      return "true" ; //je retourne vrai si mon plat doit etre affiché
    }else{
      return "false" ; //je retourne faux si mon plat doit etre affiché
    }

}

require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée

$ma_base_de_donnee = new interaction() ; ///creation d un objet
$ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée


require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
$simplificateur = new Simplificateur_de_syntaxe("formulaire_de_mise_a_jour_du_menu") ; //creation d un objet qui va m aider a creer ma liste de presence

                        
$recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats  ");
$simplificateur->execute_la_recherche( $recherche_de_l_id);
$tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");

foreach ($tableau_d_identifiant as $id_plat) {

    $chaine_d_id_plat = strval($id_plat) ; //je convertis l identifiant de chacun de mes plats qui sont des entiers en chaine de caractère

    //je dois changer la visibilité des plats afin de savoir lesquelles sont au menu ou pas
    $visibilite = visibilite_du_plat($_POST["plat_".$chaine_d_id_plat] ) ; //ceci est une variable representant l etat de visiblite de mon plat en fonction de son identifiant
    $changement_de_visibilite = $ma_base_de_donnee->connexion->prepare("UPDATE plats SET visible = ? WHERE id_plat = ? ; ") ; //cette requete me permet de modifier mon email
    $changement_de_visibilite->bind_param("si", $visibilite , $id_plat) ;//remplissage des parametres en question
    $simplificateur->execute_la_recherche($changement_de_visibilite) ; //cette methode me permet d executer ma requete de  recherche



}


header("Location:formulaire_de_mise_a_jour_du_menu.php?error=carte du menu mis a jour");//redirection de ma page vers la page de connexion
exit();//fermeture de la redirection
       











?>