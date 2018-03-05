<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (!isset($_SESSION['log_status']) && $_SESSION['log_status'] == 0)
	  header("Location: index.php");
?>

<?php
  $title = "my account";
  require_once("includes/header.php");
  //fonctions d'éxécution des requetes sql
  require_once("libft_php/sql_rqt.php");
?>

<?php
	// on récupère les données de l'utilisateur a afficher dans sa page gestion de compte

	$sql = 'SELECT * FROM camagru.users WHERE pseudo = "'.$_SESSION["id"].'";';
	$ret = ft_exe_sql_rqt("select datas of user", $bdd, $sql);
	$ret = mysqli_fetch_array($ret);
	// print_r($ret);

	$pseudo = $ret['pseudo'];
	$email = $ret['email'];
	$passwd = $ret['passwd'];
?>


<div class="main" >
	<div class="log_reg">
		<div class="grid-5" style="padding-bottom: 50px;">
			<div class="col-5 log-text1">Gestion de compte</div>
		</div>
		<hr/>
		<div class="grid-5">		
			<div class="setting_name">nom de compte</div>
			<div class="col-3 setting_data"><?php echo $pseudo; ?></div>
			<a href="" style="display: block;">Modifier</a>
		</div>
		<hr/>
		
		
		<div class="grid-5">
			<div class="setting_name">adresse email</div>
			<div class="col-3 setting_data"><?php echo $email; ?></div>
			<a href="" style="display: block;">Modifier</a>
		</div>
		<hr/>

		<div class="grid-5">
			<div class="setting_name">mot de passe</div>
			<div class="col-3 setting_data">********</div>
			<a href="" style="display: block;">Modifier</a>
		</div>
		<hr/>
	
</div>


<?php require_once("includes/footer.php"); ?>