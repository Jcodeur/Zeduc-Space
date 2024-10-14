<?php
// Commencer la mise en mémoire tampon de sortie


// Définir la fonction pour afficher le popup
function appelle_pop_pup($texte_a_afficher,$lien_de_la_page_de_traitement) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Styles de base pour le popup */
        .popup-bg {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000; /* S'assurer que le popup est au-dessus de tout */
        }
        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .popup-content h2 {
            margin-top: 0;
        }
        .popup-content button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="popup-bg" id="popup-bg">
        <div class="popup-content">
            <h2>Salut!</h2>
            <p><?php echo htmlspecialchars($texte_a_afficher); ?></p>
            <button onclick="closePopup()">Fermer</button>
        </div>
    </div>

    <script>
        function openPopup() {

            document.getElementById('popup-bg').style.display = 'flex';
            // Bloque l'interaction avec le reste de la page
            document.body.style.overflow = 'hidden';
           
        }

        function closePopup() {
            // Réactive l'interaction avec le reste de la page
            document.body.style.overflow = 'auto';
            // Redirige vers une autre page après la fermeture du popup
            <?php unset($_SESSION["avertissement"]) ; ?> ;
            window.location.href = "<?php echo $lien_de_la_page_de_traitement; ?>";
        }

        // Ouvrir le popup automatiquement au chargement de la page
        window.onload = openPopup;
    </script>
</body>
</html>
<?php
}
// Envoyer le tampon de sortie et l'arrêter

?>
