<?php
	if (session_id() == "")
		session_start();
	
	 // verifie si l'utilisateur n'est pas deja connecté.
	if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0)
	  header("Location: index.php");
	else
	{
		$_SESSION['log_status'] = 0;
		header("Location: index.php");
	}
?>