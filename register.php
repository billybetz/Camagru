<?php
  require_once("includes/header.php");
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
