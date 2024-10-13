<?php
//ouverture de ma balise php pour y inserer mon code php
  class  interaction{//cette classe va me permettre d interagir avec ma base de donnee

       private    $nom_de_mon_serveur  ; //ceci est une variable privé qui va  contenir le nom de mon serveur
       private    $nom_d_utlisateur   ;  //ceci est une variable privé qui va contenir le nom d utilisateur  de ma base de donnée
       private    $mot_de_passe_de_la_base_donnee  ; //ceci est une variable privé qui va contenir le mot de passe de ma base de donnée
       private   $nom_de_la_base_de_donnee  ; //ceci est une variable privé quiva contenir le nom de ma base de donnée

       public $connexion ;// ceci est une variable public qui va representer ma base de donnée

       public function __construct(){///ceci est ma methode constructor qui va permettre  d initialiser certaine variable


       }//fin de mon constructor



       public function connexion_sur_la_BD($name_serveur,$utilisateur_name,$password_name,$BD_name){
       //ceci est une methode qui va me permettre de me connecter a n importe quelle base de donnée
       //initialisation des variables privés dans une methode quand on veut le faire on met $this-> derriere le nom de cette variable privé
            $this->nom_de_mon_serveur = $name_serveur ;//ceci est le nom de serveur
            $this->nom_d_utlisateur = $utilisateur_name ;//ceci est mon nom d utilisateur
            $this->mot_de_passe_de_la_base_donnee = $password_name ;//ceci est le mot de passe de ma base de donnee
            $this->nom_de_la_base_de_donnee = $BD_name ;//ceci est le nom de ma base de donnee
        
            //connexion avec ma base de donnee
            $this->connexion = mysqli_connect($this->nom_de_mon_serveur,$this->nom_d_utlisateur,$this->mot_de_passe_de_la_base_donnee,$this->nom_de_la_base_de_donnee);
            //la ligne ci dessus me permet de me connecter a ma base donnée
            if (!$this->connexion){//cette condition me permet de faire la verification de ma connexion
                die("je n ai pas pu me connecter à la bd".mysqli_connect_error());
                //si ma connexion n a pas marcher alors couper la connexion 
            }else{//cas contraire
              //ecrire connexion reussite
              
            }//fin du if

       }//fin de notre methode 






  }//fin de notre classe 








?><!--fermeture de ma balise php car le script php est terminé-->