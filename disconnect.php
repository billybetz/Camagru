<?php
	if (session_id() == "")
		session_start();
	
	 // verifie si l'utilisateur est connect�, le redirige dans le cas contraire.
	if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0)
	  header("Location: index.php");
	else
	{
		$_SESSION['log_status'] = 0;
		header("Location: index.php");
	}
?>