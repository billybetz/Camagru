<?php
  echo ("test\n");
  echo ("test3");
  $connexion = mysql_connect("localhost", "root,", "rootroot");
  echo ("test2");
  $title = "Accueil";
  // require_once("config/setup.php");
  require_once("includes/header.php");
?>

<div class="main" >
	<div class="photo_creation">

	</div>
	<div class="photo_apercu">

	</div>
</div>

<?php require_once("includes/footer.php"); ?>
