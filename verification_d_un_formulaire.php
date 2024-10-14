<?php
 //la ligne si dessus me permet  d ouvrir ma balise php pour y mettre mon code
 //cette classe va me permettre de controler la validité de mes formulaires

  
  class verification_de_ce_formulaire{//cette classe a des methodes qui vont me permettre de verifier  la validité de mes  entrées dans le formulaire 

        private $redirection ; //declaration d une variable privée qui va contenir un lien de redirection

        public function __construct($nom_du_fichier_sur_lequel_rediger){//ceci est mon constructeur 
        //ceci est mon constructeur
          $this->redirection = $nom_du_fichier_sur_lequel_rediger ;//initialisation de la variable privé qui va contenir un lien de redirection a travers le constructor

        }//fin de mon constructor

        public function verification_d_un_nom($chaine_autoriser,$nom_a_verifier,$message){//cette methode va verifier la validite d un nom qu on va entrer

            $nbre_de_caractere_du_nom_a_verifier= strlen($nom_a_verifier);//je stocke le nombre de caractere de la chaine à vérifier
            $chaine_du_mot = strval($nom_a_verifier) ; //ceci me permet de convertir le mot réçu en chaine de caractere

            for( $i=0 ; $i<=($nbre_de_caractere_du_nom_a_verifier-1) ; $i++){ //ceci est ma boucle qui me permet de verifier chaque caractere

             $caractere_du_mot =  $chaine_du_mot[$i] ; // recuperation de chaque caractere du mot en question

              if(!preg_match($chaine_autoriser,$caractere_du_mot)){//si le caractere que j entre ne valide pas la chaine entrée alors

                $_SESSION["avertissement"] = $message ;
                
                header("Location:".$this->redirection.".php?error=".$message);//redirection avec affichage d un message
                exit();//ces deux lignes sont utilises pour rediriger mon utilisateur vers le meme formulaire 
        
                
              }//fin du if
  


            }


            

        }//fin de la methode


        public function verification_d_un_mail($email){//ouverture de ma methode verification d un mail

            if( !filter_var($email,FILTER_VALIDATE_EMAIL)){// si ça ne remplit pas la validation

                header("Location:".$this->redirection.".php?error= tu ne respectes pas la syntaxe d un mail ");//redirection vers la meme page avec un message d erreur
                exit();//fermeture de la redirection
        
            }//fin du if

        }//fin de la methode


        public function comparateur($donnee1,$donnee2,$message){//cette methode permet de verifier si deux nombres sont différents

            if($donnee1!=$donnee2){//si les nombressont différents

                $_SESSION["avertissement"] = $message ;
                header("Location:".$this->redirection.".php?error=".$message);//redirection avec affichage d un message
                exit();//ces deux lignes sont utilises pour rediriger mon utilisateur vers le meme formulaire 
        

            }//fin du if

        }//fin de la methode


        public function egalite($donnee1,$donnee2,$message){//si les deux nombres que je prends sont égaux

            if( $donnee1==$donnee2 ){//voici la comparaison d egalité

                $_SESSION["avertissement"] = $message ;
                header("Location:".$this->redirection.".php?error=".$message);//redirection de la page
                exit();//ces deux lignes sont utilises pour rediriger mon utilisateur vers le meme formulaire 
        

            }

        }//fin de la methode

        public function maximum_d_un_mot_de_passe($mot_de_passe,$norme,$message){//cette methode sert à controler le nombre de caractere de mon mot de passe
              
            if ($mot_de_passe<$norme){//voici la comparaison d inférioté

                $_SESSION["avertissement"] = $message ;
                header("Location:".$this->redirection.".php?error=".$message);//redirection de la page
                exit();//ces deux lignes sont utilises pour rediriger mon utilisateur vers le meme formulaire 
        
            }


        }//fin de la methode

        public function case_vide($case,$message){//cette methode va  me permettre de savoir si une case est a une valeur null donc ne connaitre si les cases du formulairesont vides

            if($case==null){//si la valeur de cette case est nul

                $_SESSION["avertissement"] = $message ;
                header("Location:".$this->redirection.".php?error=".$message);//redirection de la page
                exit();//ces deux lignes sont utilises pour rediriger mon utilisateur vers le meme formulaire 
        

            }// fin du if


        }//fin de la methode

       
         // Méthode pour vérifier si les quatre caractères après @ sont des chiffres
      

  }//fin de la classe



?><!--fermeture de la balise php-->