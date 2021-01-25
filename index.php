<!-- Une page d’accueil qui présente votre site (index.php) -->
<!DOCTYPE html>
<html>
<?php 

	session_start();
	


    require_once('pdo.php');
    $title = 'accueil';
   require_once('templates/head.php');
    
?>
<body>
	<?php require_once('templates/header.php');?>
	<main>
		<article class="article_1">
			<h2>Venez réserver votre salle</h2>
			<div class="accueil_middle">
				<img class="img_accueil" width="500px" src="ressources/pexels-photo-260689.jpeg" alt="img_salle">
				<p>
					Réservez cette salle de réunion située à Marseille, pour votre prochaine réunion d'équipe ! Cet espace est lumineux et équipé.<br>
					La salle est équipée d'une connexion wifi, d'un vidéo-projecteur et d'un paper board.<br>
					Le café est inclus dans la prestation.<br>
					<button><a href="reservation-form.php">Réserver ici</a></button>
				
				</p>
			</div>				
			
			
			
		</article>
		
	</main>
<?php require_once('templates/footer.php');?>
</body>
</html>