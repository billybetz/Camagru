<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (isset($_SESSION['log_status']) && $_SESSION['log_status'] != 0)
	  header("Location: index.php");
?>

<?php
  $title = "Forget password";
  require_once("includes/header.php");
?>
<div class="main" >

	<div class="log_reg">
		<div class="log-text1">REINITIALISATION</div>

		<form class="log-formulaire" method="POST" action=""> 
			<label>Adresse email : </label> <br> <input type="text" name="mail"/>
			<br>
			<button class="log-sub" type="submit" name="submit" value="OK" >Demander un nouveau mot de passe</button>
		</form>
	
  </div>
</div>