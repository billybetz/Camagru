<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (isset($_SESSION['log_status']) && $_SESSION['log_status'] != 0)
	  header("Location: index.php");
?>

<?php
  require_once("includes/header.php");
  //fonctions d'éxécution des requetes sql
  require_once("libft_php/sql_rqt.php");
?>

<?php
	//Si l'utilisateur a cliquer sur se connecter, vérifie les infos et connecte si valide.
	// rempli la variable errors sinon.
	if (isset($_POST['submit']) && $_POST["submit"] == "OK")
	{
		$login = $_POST["id"];
		$mdp = $_POST["mdp"];
		$error;
		if ($login == "")
			$error = "no_id";
		else if ($mdp == "")
			$error = "no_mdp";
		else
		{
			$sql = 'SELECT * FROM camagru.users WHERE pseudo = "'.$login.'";';
			$ret = ft_exe_sql_rqt("select user", $bdd, $sql);
			$ret = mysqli_fetch_array($ret);
			if ($ret && $ret['passwd'] == $mdp)
			{
				$_SESSION['log_status'] = $ret['rank'];
				$_SESSION['id'] = $login;
			}
			else
				$error = "incorrect_data";
		}
	}
?>

<div class="main" >
	<div class="log_reg">
		<div class="log-text1">CONNEXION</div>

		<form class="log-formulaire" method="POST" action=""> 
			<label>Identifiant : </label> <br> <input type="text" name="id"/>
			<br>
			<label>mot de passe : </label> <br> <input type="text" name="mdp"/>
			<br>
			<div class="forget_mdp">
				<a href="set_new_pass.php">mot de passe oublié ?</a>
			</div>
			<button class="log-sub" type="submit" name="submit" value="OK" >Se connecter</button>
		</form>
	
  </div>
</div>






<?php require_once("includes/footer.php"); ?>
