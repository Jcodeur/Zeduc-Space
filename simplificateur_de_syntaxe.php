
<?php
//ouverture de ma balise php

  class Simplificateur_de_syntaxe{//ouverture de ma classe qui va contenir toutes les methodes qui vont me permettre de creer une liste

    private $redirection ; //declaration d une variable privée qui va contenir un lien de redirection

    public function __construct($nom_du_fichier_sur_lequel_rediger){//ceci est mon constructeur 
    //ceci est mon constructeur
      $this->redirection = $nom_du_fichier_sur_lequel_rediger ;//initialisation de la variable privé qui va contenir un lien de redirection a travers le constructor

    }//fin de mon constructor


    public function execute_la_recherche($pRecherche_la_notification){ //ouverture de methode qui va me permettre d executer ma recherche de notification

        if(!$pRecherche_la_notification->execute()){ //si ma requete de recherche de notification ne s execute pas 

            header("Location:".$this->redirection.".php") ; //redirection sur une page 
            exit() ; //fin de la redirection

        }//fin de si ma requete de recherche de notification ne s execute pas 


    } //fin de ceci est une ouverture de methode qui va me permettre d executer ma recherche de notification


    public function  stocke_le_resultat_de_la_requete($pRecherche_la_notification,$pNom_colonne_BD){  //cette methode va me permettre de stocker mes notifications dans un tableau

        $resultat_pRecherche_la_notification= $pRecherche_la_notification->get_result() ; //ceci me permet de recuperer la ligne du resultat en question
        $pStockage_des_notifications = array() ; //declaration de mon tableau qui va  contenir mes notifications 

        while($tableau_pRecherche_la_notification =  $resultat_pRecherche_la_notification->fetch_assoc() ){  //ceci est une boucle qui va me permettre de stocker les notifications 

            $pStockage_des_notifications[] = $tableau_pRecherche_la_notification[$pNom_colonne_BD] ; //ceci est le stockage de mes notifications dans ma base de donnees

        }//fin de  ceci est une boucle qui va me permettre de stocker les notifications 

      return  $pStockage_des_notifications ; //je retourne le tableau en question a fin de pouvoir recperer les donnees inserer

    }//cette methode va me permettre de stocker mes notifications dans un tableau


   
    


  
  } //fermeture de ma classe 

















//fermeture de ma balise php
?>