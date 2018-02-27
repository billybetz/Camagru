<?php
  if(session_id() == "")
	  session_start;
  // verifie si l'utilisateur n'est pas deja connecté.
  if ($_session["log_status"] != "")
	  header("Location: index.php");
  
  //recupere les données du formulaire
  $login = $_POST["id"];
  $mdp = $_POST["mdp"];
  $mdp2 = $_POST["mdp2"];
  $mail = $_POST["mail"];
  $errors[];
  $submit = $_POST["submit"];
?>

<?php  
  require_once("includes/header.php");
?>

<?php
	if ($submit == "OK")
	{
		errors['login'] = check_login();
		errors['mail'] = check_email();
		errors['mdp'] = check_mdp();
		if ((errors['login'] = check_login()) != )
			
		if ($mdp != $mdp2)
		{
			echo "vos mots de passe ne correspondent pas.";
		}
	}
?>

	<div class="log_reg" >
		<div class="log-text1">INSCRIPTION</div>
		
		<form class="log-formulaire" method="POST" action=""> 
			<label>Identifiant : </label> <br><input type="text" name="id"/>
			<br>
			<label>Adresse email : </label> <br><input type="text" name="mail"/>
			<br>
			<label>mot de passe : </label><br> <input type="text" name="mdp"/>
			<br>
			<label>répétez le mot de passe : </label> <br><input type="text" name="mdp2"/>
			<br>
			<button class="log-sub" type="submit" name="submit" value="OK" >S'enregistrer</button>
		</form>

		
	</div>

<?php require_once("includes/footer.php"); ?>
