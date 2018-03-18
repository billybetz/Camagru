<?php

function ft_str_have_digit($chaine)
{
	for ($i=0; $i < strlen($chaine); $i++)
	{
		if (is_numeric($chaine[$i]) == TRUE)
			return (TRUE);
	}
	return (FALSE);
}

function check_login($login, $bdd)
{
	if ($login == "")
		return ("Champ obligatoire");
	if (strlen($login) < 5 || strlen($login) > 12)
		return ("L'identifiant doit faire entre 5 et 12 caractères");
	if (ctype_alnum($login) == FALSE)
		return ("L'identifiant ne peux contenir que des caractères alphanumérique");
	if (ft_str_have_digit($login) == FALSE)
		return("l'identifiant doit contenir au moins 1 chiffre et 1 lettre");

	$sql = 'SELECT pseudo FROM camagru.users WHERE pseudo = "'.$login.'";';
	$ret = ft_exe_sql_rqt("select all pseudo", $bdd, $sql);
	$ret = mysqli_fetch_array($ret);

	if ($ret[0] != "")
		return ("login déjà utilisé");
	return("");
}

function check_email($email, $bdd)
{
	

	if (mb_substr_count($email, '@') != 1)
		return ("adresse mail invalide");

	$sql = 'SELECT email FROM camagru.users WHERE email = "'.$email.'";';
	$ret = ft_exe_sql_rqt("select user", $bdd, $sql);
	$ret = mysqli_fetch_array($ret);
	if ($ret[0] != "")
		return ("email déjà utilisée");
	return("");
}

function check_mdp($mdp)
{
	if (strlen($mdp) < 5)
		return ("mot de passe trop court");
	return("");
}

function check_mdp2($mdp, $mdp2)
{
	if ($mdp != $mdp2)
		return ("vos mots de passe ne correspondent pas");
	return("");
}

?>
