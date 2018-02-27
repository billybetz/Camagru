<?php
  if (session_id() == "")
	  session_start();
  // verifie si l'utilisateur n'est pas deja connecté.
  if ($_session["log_status"] != "")
	  header("Location: index.php");
  //recupere les données du formulaire
  $login = $_POST["id"];
  $mdp = $_POST["mdp"];
  $submit = $_POST["submit"];
  require_once("includes/header.php");
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
