<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>zeduc space</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" />    
	<link href="partie etudiante/css/templatemo-style.css" rel="stylesheet" />
</head>

<body> 

	<div class="container">
	<!-- Top box -->
		<!-- Logo & Site Name -->
		<div class="placeholder">
			<div class="parallax-window" data-parallax="scroll" data-image-src="partie etudiante/img/simple-house-01.jpg">
				<div class="tm-header">
					<div class="row tm-header-inner">
						<div class="col-md-6 col-12">
							<img src="partie etudiante/img/simple-house-logo.png" alt="Logo" class="tm-site-logo" /> 
							<div class="tm-site-text-box">
								<h1 class="tm-site-title">Restaurant</h1>
								<h6 class="tm-site-description">zeduc space</h6>	
							</div>
						</div>
						<nav class="col-md-6 col-12 tm-nav">
							<ul class="tm-nav-ul">
								<li class="tm-nav-li"><a href="index.php" class="tm-nav-link active">Accueil</a></li>
								<li class="tm-nav-li"><a href="formulaire_d_inscription.php" class="tm-nav-link">Inscription</a></li>
								<li class="tm-nav-li"><a href="formulaire_de_connexion.php" class="tm-nav-link">Connexion</a></li>
							</ul>
						</nav>	
					</div>
				</div>
			</div>
		</div>

		<main>
			<header class="row tm-welcome-section">
				<h2 class="col-12 text-center tm-section-title">Bienvenue dans le Zeduc Space</h2>
				<p class="col-12 text-center">Ici dans notre restaurant vous trouverez un bon miam miam qui vous permettra de donner du bonheur à votre ventre qui ne demande que satisfaction</p>
			</header>
			
			<div class="tm-paging-links">
				<!--<nav>
					<ul>
						<li class="tm-paging-item"><a href="#" class="tm-paging-link active">Nourriture</a></li>
						<li class="tm-paging-item"><a href="#" class="tm-paging-link">Boisson</a></li>
					</ul>
				</nav> -->
			</div>

			<!-- Gallery -->
			<div class="row tm-gallery">
				
				<!-- gallery page 1 -->
				<div id="tm-gallery-page-pizza" class="tm-gallery-page">
				<?php 
				  function affiche_le_plat($lien_de_l_image_du_plat,$nom_du_plat,$description_du_plat,$prix){  
				?>
				 <article class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item">
						<figure>
						<img src="<?php echo $lien_de_l_image_du_plat; ?>" alt="Image" class="img-fluid tm-gallery-img" />
							<figcaption>
								<h4 class="tm-gallery-title"><?php echo $nom_du_plat ; ?></h4>
								<p class="tm-gallery-description"><?php echo $description_du_plat ; ?></p>
								<p class="tm-gallery-price"><?php echo $prix." FCFA" ; ?></p>
							</figcaption>
						</figure>
				  </article>
				<?php 
				  }

				  require "interaction_sur_la_base_de_donnee.php" ;//ensuite appel du fichier qui va me permettre de me connecter a ma base de donnée
  
				  $ma_base_de_donnee = new interaction() ; ///creation d un objet
				  $ma_base_de_donnee->connexion_sur_la_BD("localhost","root","","zeduc_space") ; //methode me permettant de me connecter a ma base de donée
			

				  require "simplificateur_de_syntaxe.php" ;  //ceci est la recuperation d un fichier contenant une classe avec des methodes pour simplifier la syntaxe de mes requetes
				  $simplificateur = new Simplificateur_de_syntaxe("index") ; //creation d un objet qui va m aider a creer ma liste de presence
				  
				  $recherche_de_l_id = $ma_base_de_donnee->connexion->prepare("SELECT id_plat FROM plats  ");
				  $simplificateur->execute_la_recherche( $recherche_de_l_id);
				  $tableau_d_identifiant = $simplificateur->stocke_le_resultat_de_la_requete( $recherche_de_l_id, "id_plat");

				  foreach ($tableau_d_identifiant as $id_plat) {

					$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
					$recherche_du_plat->bind_param("i",$id_plat) ;
					$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
					$tableau_nom_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"nom_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
					$nom_du_plat =  $tableau_nom_du_plat[0] ; //recuperation du nom de l ecran
                    
					$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
					$recherche_du_plat->bind_param("i",$id_plat) ;
					$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
					$tableau_photo_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"photo_du_plat") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
					$nom_de_la_photo_du_plat =  $tableau_photo_du_plat[0] ; //recuperation du nom de l ecran
                    
					  
					$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
					$recherche_du_plat->bind_param("i",$id_plat) ;
					$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
					$tableau_prix_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"prix") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
					$prix_du_plat =  $tableau_prix_du_plat[0] ; //recuperation du nom de l ecran
                    
					$recherche_du_plat = $ma_base_de_donnee->connexion->prepare("SELECT * FROM plats WHERE id_plat = ? ; ") ;//prepration de ma requete de ma requete qui va chercher le nom de l utilisateur
					$recherche_du_plat->bind_param("i",$id_plat) ;
					$simplificateur->execute_la_recherche($recherche_du_plat) ; //cette methode me permet d executer ma requete de  recherche
					$tableau_de_description_du_plat =   $simplificateur->stocke_le_resultat_de_la_requete( $recherche_du_plat,"description") ;//ceci est une methode qui me permet de stocker les identifiants de tout ceux qui doivent reçevoir la liste
					$description =  $tableau_de_description_du_plat[0] ; //recuperation du nom de l ecran
                    

					
					affiche_le_plat($nom_de_la_photo_du_plat,$nom_du_plat ,$description,$prix_du_plat) ;  
					
				  }
				  
				?>
				
				
				</div> <!-- gallery page 2 -->
				
				<!-- gallery page 3 -->
			
			</div>
			
		</main>

		<footer class="tm-footer text-center">
			<p>Copyright &copy; 2024 zeduc Space
            
            | Design By: <a rel="nofollow" href="#">GROUPE 7</a></p>
		</footer>
	</div>
	<script src="partie etudiante/js/jquery.min.js"></script>
	<script src="partie etudiante/js/parallax.min.js"></script>
	<script>
		$(document).ready(function(){
			// Handle click on paging links
			$('.tm-paging-link').click(function(e){
				e.preventDefault();
				
				var page = $(this).text().toLowerCase();
				$('.tm-gallery-page').addClass('hidden');
				$('#tm-gallery-page-' + page).removeClass('hidden');
				$('.tm-paging-link').removeClass('active');
				$(this).addClass("active");
			});
		});
	</script>
</body>
</html>




