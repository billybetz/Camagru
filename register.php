<?php
  if(session_id() == "")
	  session_start();
  // verifie si l'utilisateur n'est pas deja connecté.
  if (isset($_SESSION['log_status']) && $_SESSION['log_status'] != 0)
	  header("Location: index.php");
?>

<?php 
  $title = "Registration";
  require_once("includes/header.php");
  //fontions de verification des donnees de formulaire
  require_once("libft_php/data_validity.php");
  //fonctions d'éxécution des requetes sql
  require_once("libft_php/sql_rqt.php");
?>


<?php
	$errors = array();
	//Si l'utilisateur a cliquer sur s'enregistrer, vérifie les infos et push en db si valide.
	// rempli la variable errors sinon.
	if (isset($_POST['submit']) && $_POST["submit"] == "OK")
	{
		$login = $_POST["id"];
		$mdp = $_POST["mdp"];
		$mdp2 = $_POST["mdp2"];
		$email = $_POST["email"];
		$errors = array();
		
		$errors['login'] = check_login($login);
		$errors['email'] = check_email($email);
		$errors['mdp'] = check_mdp($mdp);
		$errors['mdp2'] = check_mdp2($mdp, $mdp2);
		if ($errors['login'] == "" && $errors['email'] == "" && $errors['mdp'] == "")
		{
			$sql = 	'
			INSERT INTO camagru.Users (pseudo, email, passwd, rank) 
			VALUES ("'.$login.'", "'.$email.'", "'.$mdp.'", 1);
					';
			
			$ret = ft_exe_sql_rqt("add user", $bdd, $sql);
			if (!$ret)
				echo ("Erreur lors de l'ajout de l'utilisateur\n");
			
		}
	}
?>

	<div class="log_reg" >
		<div class="log-text1">INSCRIPTION</div>
		
		<form class="log-formulaire" method="POST" action=""> 
			<label>*Identifiant : </label> <br><input type="text" name="id"/>
			<br>
			
				<?php if (isset($errors['login']) && $errors['login'] != "") { ?>
			<span class="err_log"><?php echo $errors['login'];?></span> <br>
				<?php }	?>	
			<label>*Adresse email : </label> <br><input type="text" name="email"/>
			<br>
				<?php if (isset($errors['email']) && $errors['email'] != "") { ?>
			<span class="err_log"><?php echo $errors['email'];?></span> <br>
				<?php }	?>
			<label>*mot de passe : </label><br> <input type="password" name="mdp"/>
			<br>
				<?php if (isset($errors['mdp']) && $errors['mdp'] != "") { ?>
			<span class="err_log"><?php echo $errors['mdp'];?></span> <br>
				<?php }	?>
			<label>*répétez le mot de passe : </label> <br><input type="password" name="mdp2"/>
			<br>
				<?php if (isset($errors['mdp2']) && $errors['mdp2'] != "") { ?>
			<span class="err_log"><?php echo $errors['mdp2'];?></span> <br>
				<?php }	?>
			<div class="already_reg">
				deja un compte ? <a href="login.php">s'identifier</a>
			</div>
			<button class="log-sub" type="submit" name="submit" value="OK" >S'enregistrer</button>
		</form>

		
	</div>

<?php require_once("includes/footer.php"); ?>
