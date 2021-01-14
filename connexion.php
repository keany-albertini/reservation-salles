<!-- Le formulaire doit avoir deux inputs : “login” et “password”. Lorsque le
formulaire est validé, s’il existe un utilisateur en bdd correspondant à ces
informations, alors l’utilisateur devient connecté et une (ou plusieurs)
variables de session sont créées. -->
<?php
	session_start();

	require_once('pdo.php');

	$title = 'connexion';

	// CANCEL -> GOTO DECONNEXION.PHP
	if (isset($_POST['cancel'])) {
		header("Location: deconnexion.php");
		return;
	}

	// POST-FORM SEND
	if (isset($_POST['submit'])) {
		// NO LOGIN
		if (empty($_POST['login'])) {
			$_SESSION['error'] = 'Vous devez rentrer votre login pour vous connecter.';
			header('Location: connexion.php');
			return;
		}
		// NO PASSWORD
		elseif (empty($_POST['password'])) {
			$_SESSION['error'] = 'Vous devez rentrer votre mot de passe pour vous connecter.';
			header('Location: connexion.php');
			return;
		}
		// OK, CONTINUE
		else {
			$sql = "SELECT * FROM utilisateurs WHERE login = :login";

			$stmt = $pdo->prepare($sql);
			$stmt->execute([':login' => htmlentities($_POST['login'])]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// NO RETURN => NO USER IN DB
			if (empty($row)) {
				$_SESSION['error'] = 'Ce Login n\'existe pas dans notre base de donnée.';
				header('Location: connexion.php');
				return;
			} 
			// OK, CONTINUE
			else {
				// NOT THE SAME PASSWORD
				if (!password_verify(htmlentities($_POST['password']), $row['password'])) {
					$_SESSION['error'] = 'Votre mot de passe ne correspond pas à celui enregistré lors de votre inscription.';
					header('Location: connexion.php');
					return;
				}
				// OK, CONTINUE
				// COPY FROM DB TO $_SESSION
				foreach ($row as $k => $v) {
					$_SESSION[$k] = $v;
				}
				// CREATE BOOL LOGGED
				$_SESSION['logged'] = TRUE;
				// CHARGING PASSWORD, NOT THE HASH
				$_SESSION['password'] = htmlentities($_POST['password']);

				// GOTO
				header('location: profil.php');
				return;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<?php require_once("templates/head.php"); ?>
	<body>
		<?php require_once('templates/header.php'); ?>
		<main class="container">
			
			<form class="formulaire" action="connexion.php" method="POST">
				<h3>Connectez-vous !</h3>
				<label for="login">Login:</label>
				<input type="text" name="login" id="login"> <br />

				<label for="pass">password:</label>
				<input type="password" name="password" id="pass"> <br />

				<input class="input_submit" type="submit" name='submit' value="connexion">
				<input class="input_annuler" type="submit" name='cancel' value="annuler">
				<?php
				if (isset($_SESSION['error'])) {
					echo '<p class="error">' . $_SESSION['error'] . '</p>';
					unset($_SESSION['error']);
				} elseif (isset($_SESSION['success'])) {
					echo '<p class="success" >' .  $_SESSION['success'] . "</p>";
					unset($_SESSION['success']);
				}
				?>
			</form>
		</main>
		<?php require_once('templates/footer.php'); ?>
	</body>
</html>