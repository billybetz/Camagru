<?php
	$servername = "localhost";
	$user = "root";
	$passwd = "";
	$bdd;
	$bdd = mysqli_connect($servername, $user, $passwd);
	if ($bdd == FALSE)
	{
		echo ("fail to connect to database" . mysqli_connect_error ());
	}
?>