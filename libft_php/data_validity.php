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

function check_login($login)
{
	if ($login == "")
		return ("Champ obligatoire");
	if (strlen($login) < 5)
		return ("L'identifiant doit faire minimum 5 caracteres");
	if (ctype_alnum($login) == FALSE)
		return ("L'identifiant ne peux contenir que des caractères alphanumérique");
	if (ft_str_have_digit($login) == FALSE)
		return("l'identifiant doit contenir au moins 1 chiffre et 1 lettre");
	return("");
}

function check_email($email)
{
	return("");
}

function check_mdp($mdp)
{
	return("");
}

function check_mdp2($mdp, $mdp2)
{
	return("");
}

?>
