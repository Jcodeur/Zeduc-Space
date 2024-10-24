<?php

function detruireTousLesCookies() {

    session_start() ; //recuperation de la session en question
    session_unset() ; //suppression des données de la session
    session_destroy() ; //destruction de la session

    // Parcourir tous les cookies enregistrés
    foreach ($_COOKIE as $nomCookie => $valeur) {
        // Définir une expiration passée pour chaque cookie
        setcookie($nomCookie, '', time() - 3600, '/');
    }
    // Vider le tableau des cookies côté serveur
    $_COOKIE = array();

    session_start() ; //je redemarre une session pour enregistrer mon message
     //creation d une session qui va me permettre de sauvegarder les variables
    $_SESSION["avertissement"] = " vous vous etes déconnecté " ;

    echo '<script type="text/javascript">
         window.location.href = "index.php";
       </script>';
 
}

// Appel de la fonction
detruireTousLesCookies();




?>