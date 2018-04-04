<?php
	if (session_id() == "")
		session_start();

	require_once("php_functions/sql_rqt.php");
	require_once("includes/bdd.php");

	// système qui permet d'organiser nos parties ajax en plusieurs fonction dans le même fichier : ajax.php
	$fonction = $_POST['fonction'];
	unset($_POST['fonction']);
	$fonction($bdd);
	

	function get_photo($bdd)
	{
		// recupération des variables pour ne pas les laisser dans POST
		$photo = $_POST['photo'];
		$user_name = $_POST['user'];

		// Suppression des variables POST
		unset( $_POST['photo']);
		unset($_POST['user']);
		
		// requete de récupération de l'id du user
		$sql = 'SELECT id 
				FROM camagru.users
				WHERE pseudo = "'.$user_name.'";
				';
		$ret = ft_exe_sql_rqt("get id du user", $bdd, $sql);
		$ret = mysqli_fetch_array($ret);
		$id = $ret[0];
		$_SESSION['test'] = "id : ".$id;
		// création d'un nom de photo unique
		$name = uniqid();
		$name = $id."_".$name;
		// sécurité: on vérifie qu'une photo n'a pas déjà ce nom
		$sql = "SELECT name 
				FROM camagru.pictures 
				WHERE name = '".$name."';";
		$ret = ft_exe_sql_rqt("check if picture name exist", $bdd, $sql);
		$ret = mysqli_fetch_array($ret);

		// si c'est ok on insère le nom de la photo dans la bdd et on l'insère la crée sur le serveur
		if (!$ret[0])
		{

			$time = time();
			//TODO: gérer les timestamp, peut etre utiliser time()
			$sql = ' INSERT INTO camagru.pictures (user_id, name)
				VALUES ("'.$id.'", "'.$name.'");';
			$ret = ft_exe_sql_rqt("add filter", $bdd, $sql);
		}
	}


?>