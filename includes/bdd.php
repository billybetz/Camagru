<?php
	require_once("config/database.php");

	//mysql server data
	$servername = $DB_SERVERNAME;	
	$user = $DB_USER;
	$passwd = $DB_PASSWORD;
	
	$bdd = mysqli_connect($servername, $user, $passwd);
	if ($bdd == FALSE)
	{
		echo ("fail to connect to database" . mysqli_connect_error ());
	}
?>