<?php
	if (session_id() == "")
		session_start();

	require_once("php_functions/sql_rqt.php"); // pour les fonction de requetes sql
	require_once("includes/bdd.php"); // pour le $bdd
	require_once("includes/globals.php"); // pour le picture_dir

	// système qui permet d'organiser nos parties ajax en plusieurs fonction dans le même fichier : ajax.php
	$fonction = $_POST['fonction'];
	unset($_POST['fonction']);
	$fonction($bdd, $picture_dir);
	

	function get_photo($bdd, $picture_dir)
	{
		// recupération des variables pour ne pas les laisser dans POST
		$photo = $_POST['photo'];
		str_replace("data:image/png;base64", "", $photo);
		str_replace(" ", "+", $photo);
		echo (base64_decode($photo));
		$photo = base64_decode($photo);
		$user_name = $_POST['user'];
		$ext = $_POST['ext'];

		// Suppression des variables POST
		unset( $_POST['photo']);
		unset($_POST['user']);
		unset($_POST['ext']);
		
		// requete de récupération de l'id du user
		$sql = 'SELECT id 
				FROM camagru.users
				WHERE pseudo = "'.$user_name.'";
				';
		$ret = ft_exe_sql_rqt("get id du user", $bdd, $sql);
		$ret = mysqli_fetch_array($ret);
		$id = $ret[0];
		$_SESSION['test'] = "id : ".$id;

		// création d'un nom de photo unique contenant l'id du user
		$name = uniqid();
		$name = $id."_".$name.$ext;

// 		"data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAAUA
// AAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO
//     9TXL0Y4OHwAAAABJRU5ErkJggg=="

		// sécurité: on vérifie qu'une photo n'a pas déjà ce nom
		$sql = "SELECT name 
				FROM camagru.pictures 
				WHERE name = '".$name."';";
		$ret = ft_exe_sql_rqt("check if picture name exist", $bdd, $sql);
		$ret = mysqli_fetch_array($ret);

		// si c'est ok on insère le nom de la photo dans la bdd et on insère la photo sur le serveur
		if (!$ret[0])
		{
			file_put_contents($picture_dir.$name, $photo);

			$time = time();
			//TODO: gérer les timestamp, peut etre utiliser time()
			$sql = ' INSERT INTO camagru.pictures (user_id, name)
				VALUES ("'.$id.'", "'.$name.'");';
			$ret = ft_exe_sql_rqt("add filter", $bdd, $sql);
		}
	}


?>