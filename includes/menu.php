<?php
	if (session_id() == "")
		session_start();
?>

<div class="menu">
	<a href=".">
		<img src="img/acceuil.png" alt="acceuil" width="49" height="49"/>
	</a>
	<a class="menu_button" href="galerie.php">Galerie</a>
		<?php if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0){ ?>
	<a class="menu_button" href="login.php">Connexion</a>
	<a class="menu_button" href="register.php">Inscription</a>
		<?php } else { ?>
	<div>
		Bonjour <?php echo $_SESSION['id'];?>
	</div>
	<a class="menu_bouton" href="disconnect.php">deconnexion</a>
		<?php } ?>

</div>