<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>zeduc space connexion</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" />
    <link href="partie etudiante/css/all.min.css" rel="stylesheet" />
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
								<h6 class="tm-site-description">Zeduc Space</h6>	
							</div>
						</div>
						<nav class="col-md-6 col-12 tm-nav">
							<ul class="tm-nav-ul">
								<li class="tm-nav-li"><a href="index.php" class="tm-nav-link">Accueil</a></li>
								<li class="tm-nav-li"><a href="formulaire_d_inscription.php" class="tm-nav-link">Inscription</a></li>
								<li class="tm-nav-li"><a href="formulaire_de_connexion.php" class="tm-nav-link active">Connexion</a></li>
							</ul>
						</nav>	
					</div>
				</div>
			</div>
		</div>

		<main>
			<header class="row tm-welcome-section">
				<h2 class="col-12 text-center tm-section-title">Inscris Toi Ici</h2>
				<p class="col-12 text-center">remplit tes informations personnelles dans notre formulaire d' inscription afin de faire partir de l' aventure zeduc space et de ne plus jamais pleurer à cause de la famine .</p>
			</header>

			<div class="tm-container-inner-2 tm-contact-section">
				<div class="row">
					<div class="col-md-6">
						<form action="" method="POST" class="tm-contact-form">
					        <div class="form-group">
					          <input type="text" name="name" class="form-control" placeholder="Name" required="" />
					        </div>
					        
					        <div class="form-group">
					          <input type="email" name="email" class="form-control" placeholder="Email" required="" />
					        </div>

							<div class="form-group">
					          <input type="text" name="email" class="form-control" placeholder="Numéro de Téléphone" required="" />
					        </div>
				
							<div class="form-group">
					          <input type="password" name="email" class="form-control" placeholder="Mot de Passe" required="" />
					        </div>
				
							<div class="form-group">
					          <input type="password" name="email" class="form-control" placeholder="Confirmation du mot de passe" required="" />
					        </div>
				
					    
					
					        <div class="form-group tm-d-flex">
					          <button type="submit" class="tm-btn tm-btn-success tm-btn-right">
					            Je m' inscris
					          </button>
					        </div>
						</form>
					</div>
					<div class="col-md-6">
						<div class="tm-address-box">
							<h4 class="tm-info-title tm-text-success">Notre Adresse</h4>
							<address>
								nous sommes situé à la cité la terasse à yansoki après yassa depuis chez nous vous pourrez admirer en hauteur l ' Institut Ucac-Icam
							</address>
							<a href="#" class="tm-contact-link">
								<i class="fas fa-phone tm-contact-icon"></i>6 90 14 36 49
							</a>
							<a href="#" class="tm-contact-link">
								<i class="fas fa-envelope tm-contact-icon"></i>direction@zeduc-space.com
							</a>
							<div class="tm-contact-social">
								<a href="#" class="tm-social-link"><i class="fab fa-facebook tm-social-icon"></i></a>
								<a href="#" class="tm-social-link"><i class="fab fa-twitter tm-social-icon"></i></a>
								<a href="#" class="tm-social-link"><i class="fab fa-instagram tm-social-icon"></i></a>
							</div>
						</div>
					</div>
				</div>
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
			var acc = document.getElementsByClassName("accordion");
			var i;
			
			for (i = 0; i < acc.length; i++) {
			  acc[i].addEventListener("click", function() {
			    this.classList.toggle("active");
			    var panel = this.nextElementSibling;
			    if (panel.style.maxHeight) {
			      panel.style.maxHeight = null;
			    } else {
			      panel.style.maxHeight = panel.scrollHeight + "px";
			    }
			  });
			}	
		});
	</script>
</body>
</html>