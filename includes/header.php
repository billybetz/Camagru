<?php
	if (session_id() == "")
		session_start();
	
	require_once("includes/bdd.php");
?>

<!DOCTYPE hmtl>
<html>
	<head>
		<meta charset="utf-8">
		<!-- feuille de style perso -->
		<link rel="stylesheet " href="css/style.css">
		<!-- feuille de style de knacss pour leur syteme de grille  -->
		<link rel="stylesheet " href="css/grillade_knacss.css">
		<title><?php echo $title?></title>
		<link rel="icon" href="img/favicon.ico" />
		<script src="js/functions.js" type="text/javascript"></script>
	</head>
	<body>
		<?php require_once("menu.php") ?>
