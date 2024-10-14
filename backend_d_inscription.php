<?php  //ouverture de ma balise php

 session_start() ;

 if (isset($_POST["nom_utilisateur"]) && isset($_POST["numero_de_telephone"]) && isset($_POST["mail"]) && isset($_POST["code_de_parrainage"]) && isset($_POST["mot_de_passe"]) && isset($_POST["ma_confirmation_mot_de_passe"]) ){/////condition pour verifier si j ai envoyer mon formulaire

    ///ce bloc  me permet de récupérer  les informations sur les assistantes 
    $nom_utilisateur = $_POST["nom_utilisateur"];//recuperation du nom
    $numero_de_telephone = $_POST["numero_de_telephone"];//recuperation du prenom
    $email =  $_POST["mail"];//recuperation de l email
    $code_de_parrainage = $_POST["code_de_parrainage"];//recuperation du mot de passe
    $mot_de_passe = $_POST["mot_de_passe"];//recuperation de la confirmation du mot de passe
    $confirmation_du_mot_de_passe = $_POST["ma_confirmation_mot_de_passe"];//recuperation de la confirmation du mot de passe
    

     //une fois les donnees recuperer et filtrer je les insere dans ma base donnee
     require "interaction_sur_la_base_de_donnee.php";//appel d un fichier contenant une classe qui a des methodes qui vont nous permettre d interagir su sur la BD
     $ma_base_de_donnee = new interaction() ;//recuperation de ma classe qui va me permettre d interagir dans une bd je la stocke dans une variable
     $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
     
     //la ligne precedente me permet d ecrire une requete sql qui ajoute des informations dans ma base de donnée
     //mais avant d inserer une donnee nous allons en verifer l authenticité de chacun avec des filter pour chaque variable
     require "hachage_d_un_mot_de_passe.php";
     $hacheur = new hachage() ;
   
     require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
     $simplificateur = new Simplificateur_de_syntaxe("formulaire_d_inscription") ; //creation d un objet qui va m aider a creer ma liste de presence
     
     $chaine_autoriser = "/[a-zA-Z0-9 ]/" ;//chaine de caractere accepter par le formulaire
     $chaine_autoriser_du_mot_de_passe = "/[a-zA-Z0-9]/" ;//chaine de caractere accepter par le formulaire
     $chaine_autoriser_du_numero_de_telephone = "/[0-9]/" ;//chaine de caractere accepter par le formulaire

     $nbre_de_caractere_du_mot_de_passe = strlen($mot_de_passe);//je stocke le nombre de caractere de mon de passe dans une variable
     $nbre_de_caractere_de_la_confirmation_du_mot_de_passe = strlen($confirmation_du_mot_de_passe);//je stocke le nombre de caractere de mon de passe de verification dans une variable
     $nbre_de_caractere_d_un_mot_de_passe = 7 ;//je stocke le nombre minimum qu un mot de passe doit avoir
          
     $recherche_email_dans_la_BD = $ma_base_de_donnee->connexion->prepare("SELECT email FROM utilisateurs ;");//requete sql recherchant les emails
     $simplificateur->execute_la_recherche($recherche_email_dans_la_BD) ; //cette methode me permet d executer ma requete de  recherche
     $tableau_d_email =  $simplificateur->stocke_le_resultat_de_la_requete($recherche_email_dans_la_BD,"email") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste

     require "verification_d_un_formulaire.php" ;//je recupere le fichier qui contient ma classe de verification d email
          
     $verificateur = new verification_de_ce_formulaire("formulaire_d_inscription") ;//creation de l objet de cette classe en question
     $verificateur->case_vide( $nom_utilisateur,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case nom vide
     $verificateur->case_vide( $numero_de_telephone ,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case prenom vide
     $verificateur->case_vide($email,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case email vide
     $verificateur->case_vide( $code_de_parrainage,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case mot de passe vide
     $verificateur->case_vide($mot_de_passe,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case mot de passe vide
     $verificateur->case_vide($confirmation_du_mot_de_passe,"remplit toutes les cases avant de les envoyer") ; //cette methode me permet de vérifier si je ne soumets pas mon formulaire en laissant la case confirmation mot de passe vide
     
     //si les cases ne sont pas vide j enregistre préalablement les valeurs qu il saisit dans une session au cas ou il les rate
     $_SESSION["formulaire_nom_utilisateur"] = $nom_utilisateur ; //stockage de mon nom
     $_SESSION["formulaire_numero_de_telephone"] =  $numero_de_telephone ; //stockage de mon prenom
     $_SESSION["formulaire_email"] = $email ; //stockage de mon email
     $_SESSION["formulaire_code_de_parrainage"] = $code_de_parrainage ; //stockage de mon email
     $_SESSION["formulaire_mot_de_passe"] =  $mot_de_passe ; //je stocke le mot de passe que j ai utilisé
     $_SESSION["formulaire_confirmation_du_mot_de_passe"] =   $confirmation_du_mot_de_passe ; //je stocke la confirmation de mot de passe que j ai utilisé

     $verificateur->verification_d_un_mail($email) ;//cette methode me permet de verifier la validité de mon email
     $verificateur->verification_d_un_nom($chaine_autoriser,  $nom_utilisateur,"tu ne dois qu avoir des lettres et des chiffres dans ton nom d utilisateur") ;//cette methode me permet de verifier l orthographe de mon nom utilisateur
     $verificateur->verification_d_un_nom($chaine_autoriser_du_numero_de_telephone,$numero_de_telephone ,"ton numéro de téléphone ne doit que contenir que des chiffres ou le signe + si tu n ais pas du pays") ;//cette methode me permet de verifier l orthographe de mon mot de passe 

     $verificateur->verification_d_un_nom($chaine_autoriser_du_mot_de_passe,$mot_de_passe,"ton mot de passe ne peut qu avoir des lettres et des chiffres") ;//cette methode me permet de verifier l orthographe de mon mot de passe 
     $verificateur->comparateur($mot_de_passe,$confirmation_du_mot_de_passe,"ton mot de passe ne correspond pas avec la confirmation du mot de passe") ;//cette methode me permet de comparer ton mot de passe avec sa confirmation
     $verificateur->comparateur($nbre_de_caractere_du_mot_de_passe,$nbre_de_caractere_de_la_confirmation_du_mot_de_passe,"mot de passe erroné") ;//cette methode permet de controler le nombre de caractere des mots de passe en les comparant en egalite
     $verificateur->maximum_d_un_mot_de_passe($nbre_de_caractere_du_mot_de_passe,$nbre_de_caractere_d_un_mot_de_passe,"ton mot de passe ne doit que contenir ".($nbre_de_caractere_d_un_mot_de_passe+1)." caracteres") ;
    
                //la methode ci dessus permet  de controler que le mot de passe est un minimum de caractere 
                
     foreach($tableau_d_email as $different_email ){ // boucle foreach qui parcourt mon tableau email de ma base de donnée $different_email represente $tableau_d_email[i]
                             
         $verificateur->egalite($different_email,$email,"ce mail existe deja choisit en un autre") ;//cette methode permet de verifier si le mail entrer par l utilisateur existe deja dans la base de donnée
                              
     }//fin de la boucle

     $mot_de_passe_hacher = $hacheur->cryptage($mot_de_passe) ; //je creais le hache de mon mot de passe
     $statut = "deconnecte" ; //cette ligne me permet de savoir si quelqu un est connecté ou pas
    //enregistrement des données dans la base de donnée  
    $insertion_d_information = $ma_base_de_donnee->connexion->prepare("INSERT INTO utilisateurs(nom_d_utilisateur,numero_de_telephone,email,id_parrain,mot_de_passe,statut) VALUES (?,?,?,?,?,?) ;") ;
    $insertion_d_information->bind_param("sisiss",  $nom_utilisateur ,
    $numero_de_telephone ,
    $email ,
    $code_de_parrainage ,
    $mot_de_passe_hacher ,
    $statut
    ) ;  //remplissage de parametre
    $simplificateur->execute_la_recherche($insertion_d_information) ; //cette methode me permet d executer ma requete de  recherche
    //creation d une session qui va me permettre de sauvegarder les variables
    $_SESSION["avertissement"] = "inscription de ".$_SESSION["formulaire_nom_utilisateur"]." réussite" ;
    header("Location:formulaire_de_connexion.php");//redirection de ma page vers la page de connexion
    exit();//fermeture de la redirection
              
}

?><!--fermutre de ma balise php-->

