<?php 
  //ceci est l ouverture de ma balise php
class hachage{//creation de la classe hachage qui va permettre d inserer un mot de passe crypter dans ma base de donnée

   private $tableau_d_indice_de_caractere = [//ouverture d un tableau qui contient de chaque caractere ayant une correspondance en chiffre
   "a"=>1 ,
   "b"=>2 ,
   "c"=>3 ,
   "d"=>4 ,
   "e"=>5 ,
   "f"=>6 ,
   "g"=>7 ,
   "h"=>8 ,
   "i"=>9 ,
   "j"=>10 ,
   "k"=>11 ,
   "l"=>12 ,
   "m"=>13 ,
   "n"=>14 ,
   "o"=>15 ,
   "p"=>16 ,
   "q"=>17 ,
   "r"=>18 ,
   "s"=>19 ,
   "t"=>20 ,
   "u"=>21 ,
   "v"=>22 ,
   "w"=>23 ,
   "x"=>24 ,
   "y"=>25 ,
   "z"=>26 ,
   "A"=>27 ,
   "B"=>28 ,
   "C"=>29 ,
   "D"=>30 ,
   "E"=>31 ,
   "F"=>32 ,
   "G"=>33 ,
   "H"=>34 ,
   "I"=>35 ,
   "J"=>36 ,
   "K"=>37 ,
   "L"=>38 ,
   "M"=>39 ,
   "N"=>40 ,
   "O"=>41 ,
   "P"=>42 ,
   "Q"=>43 ,
   "R"=>44 ,
   "S"=>45 ,
   "T"=>46 ,
   "U"=>47 ,
   "V"=>48 ,
   "W"=>49 ,
   "X"=>50 ,
   "Y"=>51 ,
   "Z"=>52 ,
   "0"=>53 ,
   "1"=>54 ,
   "2"=>55 ,
   "3"=>56 ,
   "4"=>57 ,
   "5"=>58 ,
   "6"=>59 ,
   "7"=>60 ,
   "8"=>61 ,
   "9"=>62 



   ] ;//fin de ce tableau


   private $tableau_des_caracteres_des_indices = [//tableau qui contient la nouvelle correspondance de mes lettres que j ai entrer dans le formulaire

      "ghjihyv" ,
      "tgfdftd" ,
      "(-è_y" ,
      "yguh:" ,
      "bgfyf" ,
      "hgf" ,
      "0876" ,
      "ghjh-è_" ,
      "à" ,
      "]" ,
      "[" ,
      "f" ,
      "&" ,
      "|" ,
      "$" ,
      "," ,
      ";" ,
      "." ,
      "s" ,
      "t" ,
      "xuc" ,
      "xfv" ,
      "jwf" ,
      "dgx" ,
      "fyk" ,
      "dzt" ,
      "sAiond" ,
      "rBqq" ,
      "shgf" ,
      "egj" ,
      "rfghmpo" ,
      "rrdftgz" ,
      "mtfgf" ,
      "fghvv" ,
      "bdn" ,
      "dnns" ,
      "hfn" ,
      "ncfn" ,
      "hdcn" ,
      "kfn" ,
      "fnxh" ,
      "+09" ,
      "j,fh" ,
      "poi" ,
      "fjnc" ,
      "azerez" ,
      "kjgbd" ,
      "ZEDF" ,
      "8-è_à)" ,
      "3DCGT7" ,
      "jb,;" ,
      "345@_è-" ,
      "qu123" ,
      "jure" ,
      "open" ,
      "gh" ,
      "fgh" ,
      "$$" ,
      "¨M" ,
      "ANC" ,
      "09" ,
      "ghut"





   ] ; //fin du tableau

  
  private $decalage = 2 ; //ceci est une variable qui me permet de definir le decalage de mes differentes
   public function __construct(){//ceci est mon constructor
     //la methode est vide 
   }

   public function cryptage($mot_a_cryter){//ceci est une methode qui va me permettre de creer ma clé de chiffrement
      $chaine_du_mot = strval($mot_a_cryter) ; //ceci me permet de convertir le mot réçu en chaine de caractere
      $longueur_du_mot = strlen($chaine_du_mot) ;//ceci me permet de compter le nombre de caractere du mot de passe
      $nouveau_mot = "" ;//creation de la variable contenant le mot de passe
      for($i=0 ; $i<=($longueur_du_mot-1) ; $i++){//ceci est une boucle parcourant toutte la longueur de mon mot
            $caractere_de_la_chaine =  $chaine_du_mot[$i] ; // pour selectionner le caractere
            $indice_actuel = $this->tableau_d_indice_de_caractere[$caractere_de_la_chaine] ; //je recupere l indice de ce caractere
            $nouvel_indice = ( $indice_actuel + $this->decalage ) % count($this->tableau_des_caracteres_des_indices) ; //je calcule un nouvel indice
            $nouveau_mot = $nouveau_mot.$this->tableau_des_caracteres_des_indices[$nouvel_indice] ;// et je cherche les nouveau caracteres à mettre dans mon mot de passe
            
      }//fin du for
      
     return  $nouveau_mot ; //je retourne le mot de passe
      
   }//fin de la methode
   



    public function decryptage($mot_crypte) {
          $inverse_tableau_des_caracteres = array_flip($this->tableau_des_caracteres_des_indices);
          $longueur_du_mot = strlen($mot_crypte);
          $mot_decrypte = "";

          $i = 0;
          while ($i < $longueur_du_mot) {
              foreach ($inverse_tableau_des_caracteres as $cle => $valeur) {
                  if (substr($mot_crypte, $i, strlen($cle)) === $cle) {
                      $nouvel_indice = $valeur - $this->decalage;
                      if ($nouvel_indice < 1) {
                          $nouvel_indice += count($this->tableau_d_indice_de_caractere);
                      }
                      $caractere_original = array_search($nouvel_indice, $this->tableau_d_indice_de_caractere);
                      $mot_decrypte .= $caractere_original;
                      $i += strlen($cle);
                      break;
                  }
              }
          }
          return $mot_decrypte;
    }


   }//fermeture de la  classe


//fermeture de la balise php
?>