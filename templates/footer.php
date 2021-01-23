<footer class="footer-distributed">

			<div class="footer-right">

				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-linkedin"></i></a>
				<a href="#"><i class="fa fa-github"></i></a>

			</div>

			<div class="footer-left">

				<p class="footer-links">
					<ol  itemscope itemtype="http://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="index.php"><span itemprop="name">Accueil</span></a>
				<meta itemprop="position" content="1" />
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				 <?php 
					if(isset($_SESSION['login']))
						echo "<a itemprop=\"item\" href=\"profil.php\"><span itemprop=\"name\">Profil</span></a><meta itemprop=\"position\" content=\"3\" /></li>";
					else 
						echo  "<a itemprop=\"item\" href=\"inscription.php\"><span itemprop=\"name\">Inscription</span></a><meta itemprop=\"position\" content=\"3\" /></li>" ;
            	?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<?php 
					if(isset($_SESSION['login']))
						echo "<a itemprop=\"item\" href=\"deconnexion.php\"><span itemprop=\"name\">Deconnexion</span></a><meta itemprop=\"position\" content=\"3\" /></li>" ;  
					else 
						echo  "<a itemprop=\"item\" href=\"connexion.php\"><span itemprop=\"name\">Connexion</span></a><meta itemprop=\"position\" content=\"3\" /></li>" ;
				?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="planing.php"><span itemprop="name">Planing</span></a>
				<meta itemprop="position" content="1" />
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				 <?php 
					if(isset($_SESSION['login']))
						echo "<a itemprop=\"item\" href=\"reservation.php\"><span itemprop=\"name\">Réservation</span></a><meta itemprop=\"position\" content=\"3\" /></li>";
						
				?>
            
			
			
			
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				 <?php 
					if(isset($_SESSION['login']))
						
						echo "<a itemprop=\"item\" href=\"reservation-form.php\"><span itemprop=\"name\">résa</span></a><meta itemprop=\"position\" content=\"3\" /></li>";
				?>
            
			
			
			
		</ol>
				</p>

				<p>Company Name &copy; 2015</p>
			</div>

		</footer>