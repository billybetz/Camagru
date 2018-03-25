<?php
	if (session_id() == "")
		session_start();

	if (isset($_SESSION['log_status']) && $_SESSION['log_status'] != 0)
		$user_is_connect = 1;
	else
		$user_is_connect = 0;
?>

<div class="grid-9 has-gutter menu">

	<div style="margin: auto;">
		<a class="menu_button" style="margin-left: 1em;"  href="galerie.php">GALERIE</a>
	</div>

	<?php if ($user_is_connect == 1){ ?>
	<div style="margin: auto;">	
		<a class=" menu_button"  href="montage.php">MONTAGE</a>
	</div>
	<?php } else { echo("<div></div>"); }?>

	<div></div>

	<div></div>

	<div style="margin: auto;">
		<?php if (isset($_SESSION['log_status']) && $_SESSION['log_status'] != 0){ 
		 ?>
		<span class="bonjour">Bonjour <?php echo $_SESSION['id'];?> !</span>
		<?php } 
		?>
	</div>

	<div></div>
	
	<div></div>

	<div style="margin: auto;">
		<?php if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0){
		 ?>
		<a class="menu_button" href="login.php">CONNEXION</a>
		<?php } else {
		 ?>
		<a class="menu_button" href="my_account.php">MON COMPTE</a>
		<?php } 
		?>
	</div>


	<div style="margin: auto;">
		<?php if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0){ 
			?>
		<a class="menu_button" style="margin-right: 1em;"  href="register.php">INSCRIPTION</a>
		<?php } else { 
			?>
		<a class="menu_button" style="margin-right: 1em;" href="disconnect.php">DECONNEXION</a>
		<?php } 
		?>
	</div>

</div>