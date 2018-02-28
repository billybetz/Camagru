<?php
	if (session_id() == "")
		session_start();
?>

<div class="menu">
	<!--<a class=" index_button pos_left" href=".">CAMAGRU</a>-->
	<a href="." class ="index_button pos_left">
		<img src="img/acceuil.png" alt="acceuil" width="49" height="49"/>
	</a>
	<a class="menu_button pos_left" href="galerie.php">GALERIE</a>

	
		<?php if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0){ ?>
	<a class="menu_button pos_right" href="login.php">CONNEXION</a>
	<a class="menu_button pos_right" href="register.php">INSCRIPTION</a>
	
		<?php } else { ?>
	<span class="bonjour">Bonjour <?php echo $_SESSION['id'];?> !</span>
	
	<a class="menu_button pos_right" href="disconnect.php">DECONNEXION</a>
	<a class="menu_button pos_right" href="my_account.php">MON COMPTE</a>
		<?php } ?>

</div>