<!-- Une page d’accueil qui présente votre site (index.php) -->
<!DOCTYPE html>
<html>
<?php 

	session_start();
	
	require_once('pdo.php');
		$title = "accueil";
require_once('templates/head.php');

 ?>
<body>
	<?php require_once('templates/header.php');?>

</body>
</html>