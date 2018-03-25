<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (isset($_SESSION['log_status']) && $_SESSION['log_status'] != 0)
	  header("Location: index.php");
?>

<?php
  $title = "Login";
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
		$error = "";
		if ($login == "" || $mdp == "")
			$error = "* : Champs obligatoires";
		else
		{
			$sql = 'SELECT * FROM camagru.users WHERE pseudo = "'.$login.'";';
			$ret = ft_exe_sql_rqt("select user", $bdd, $sql);
			$ret = mysqli_fetch_array($ret);
			if ($ret && $ret['passwd'] == hash('whirlpool', $mdp))
			{
				if ($ret['rank'] == 1)
					$error = "Veuillez valider votre compte.";
				else
				{
					$_SESSION['log_status'] = $ret['rank'];
					$_SESSION['id'] = $login;
		?>
					<script>
						window.location.replace("galerie.php");
					</script>
				
		<?php
				}
			}
			else
				$error = "Nom de compte ou mot de passe incorrect";
		}
	}
?>


<div class="main" >
	<div class="log_reg">
		<div class="log-text1">CONNEXION</div>

		<form class="log-formulaire" method="POST" action="">
			
				<?php 
					if (isset($_SESSION['reg_success']))
					{
						if ($_SESSION['reg_success'] == 1)
						{		
				?> 
							<label style="color: #a15143;">Un email de confirmation de compte vous a été envoyé.</label><br><br>
				<?php
						}
						if ($_SESSION['reg_success'] == -1)
						{
						
				?>
							<label>Erreur lors de votre inscription, contactez un administrateur.</label>
				<?php
						}
					}
					$_SESSION['reg_success'] = 0;
				?>
			<label>*Identifiant : </label> <br> <input type="text" name="id" value="<?php if (isset($login)){echo$login;}?>" />
			
			<br>
			<label>*mot de passe : </label> <br> <input type="password" name="mdp"/>
			<br>
			<div class="forget_mdp">
				<a href="forget_pass.php">mot de passe oublié ?</a>
			</div>
			<button class="log-sub" type="submit" name="submit" value="OK" >Se connecter</button>
			<br>
				<?php if (isset($error) && $error != "") {?>
			<span class="err_log"><?php echo $error ?></span>
				<?php } ?>

		</form>
	
  </div>
</div>






<?php require_once("includes/footer.php"); ?>


