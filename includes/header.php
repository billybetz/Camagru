<?php
	if (session_id() == "")
		session_start();
	
	require_once("includes/bdd.php");
?>

<!DOCTYPE hmtl>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet "href="css/style.css">
		<title></title>
	</head>
	<body>
		<?php require_once("menu.php") ?>
