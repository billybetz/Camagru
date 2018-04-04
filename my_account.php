<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 1)
	  header("Location: index.php");
?>

<?php
  $title = "my account";
  require_once("includes/header.php");
  //fonctions d'éxécution des requetes sql
  require_once("php_functions/sql_rqt.php");
  // contient les variables global utilisés comme les paths relatif.
  require_once("includes/globals.php");
?>

<?php
	// on récupère les données de l'utilisateur a afficher dans sa page gestion de compte

	$sql = 'SELECT * FROM camagru.users WHERE pseudo = "'.$_SESSION["id"].'";';
	$ret = ft_exe_sql_rqt("select datas of user", $bdd, $sql);
	$ret = mysqli_fetch_array($ret);
	// print_r($ret);

	// variable de gestion des infos utilisateur
	$pseudo = $ret['pseudo'];
	$email = $ret['email'];
	$passwd = $ret['passwd'];

	//variables de formulaire de gestion des filtres [admin]
	$error_filter = "";
	$filters_available = array();
	$dir = opendir($filter_dir);
	// creation du tableau contenant tous les fichier du dossier filtre.
	while ($file_name = readdir($dir))
	{
		$pos = strrpos($file_name, ".");
		// verifie que le fichier et différent de . et .. et qu'il a la bonne extension.
		if ($file_name != "." && $file_name != ".." && !strcmp(substr($file_name, $pos), $filter_ext))
		array_push($filters_available, $file_name);
	}
	if (isset($_POST['filter_name']))
		$filter_name = $_POST['filter_name'];

	// variables de formulaire de gestion des utilisateurs [admin]
	$error_user = "";
	if (isset($_POST['user_name']))
		$user_name = $_POST['user_name'];
	// $up_u = $_POST['upgrade_user'];
	// $del_u = $POST['del_user'];

	// Block d'ajout de filtre en bdd.

	if (isset($_POST['add_all_filters']) && $_POST['add_all_filters'] == "ok")
	{
		foreach ($filters_available as $file_name) 
		{
			$sql = 'SELECT COUNT(*) 
			AS quantite
			FROM camagru.filters
			WHERE name = "'.$file_name.'";';

			$ret = ft_exe_sql_rqt("count filter with name", $bdd, $sql);
			$data = mysqli_fetch_array($ret);
			if ($data['quantite'] == 0)
			{
				$sql = ' INSERT INTO camagru.filters (name)
					VALUES ("'.$file_name.'");';

				$ret = ft_exe_sql_rqt("add filter", $bdd, $sql);
				if (!$ret)
					$error_filter = "erreur avec une des requetes sql";
			}
		}
		if ($error_filter == "")
		{
			?>
				<script>
					alert("Tous les filtres disponibles ont été ajoutés.");
				</script>
			<?php
		}
	}

	if (isset($_POST['add_filter']) && $_POST['add_filter'] == "ok")
	{
		if ($filter_name == "")
			$error_filter = "Nom de filtre invalide.";
		else if (!file_exists($filter_dir.$filter_name))
			$error_filter = "le filtre \"".$filter_name."\" est introuvable.";
		else
		{
			// verification si le filtre n'existe pas deja en bdd
			$sql = 'SELECT COUNT(*) 
				AS quantite
				FROM camagru.filters
				WHERE name = "'.$filter_name.'";';

			$ret = ft_exe_sql_rqt("count filter with name", $bdd, $sql);
			$data = mysqli_fetch_array($ret);
			if ($data['quantite'] != 0)
				$error_filter = "un filtre avec ce nom est déjà existant en bdd.";
			else
			{
				// On ajoute le nom du filtre en bdd
				$sql = ' INSERT INTO camagru.filters (name)
					VALUES ("'.$filter_name.'");';

				$ret = ft_exe_sql_rqt("add filter", $bdd, $sql);
				if (!$ret)
					$error_filter = "erreur avec la requete sql";
				else
				{ ?>
					<script>
						alert("Le filtre a bien été ajouté dans la bdd !");
					</script>
				<?php
				}
			}
		}
	}

	// Block de suppression de filtre en bdd. 
	if (isset($_POST['del_filter']) && $_POST['del_filter'] == "ok")
	{
		if ($filter_name == "")
			$error_filter = "Nom de filtre invalide.";
		else
		{
			$sql = 'SELECT COUNT(*)
				AS quantite
				FROM camagru.filters
				WHERE name = "'.$filter_name.'";';

			$ret = ft_exe_sql_rqt("count filter with name", $bdd, $sql);
			if ($ret)
			{
				$data = mysqli_fetch_array($ret);
				if ($data['quantite'] == 0)
					$error_filter = "pas de filtre avec ce nom a supprimer dans la bdd.";
				else
				{
					$sql = ' DELETE FROM camagru.filters 
						WHERE name = "'.$filter_name.'";';

					$ret = ft_exe_sql_rqt("delete filter", $bdd, $sql);
					if (!$ret)
						$error_filter = "erreur avec la requete sql.";
					else
					{ ?>
						<script>
							alert("Le filtre a bien été supprimé de la bdd !");
						</script>
					<?php
					}
				}
			}
			else
				$error_filter = "Probleme de bdd.";
		}
	}

	// block d'upgrade de d'utilisateur au rang d'admin
	if (isset($_POST['upgrade_user']) && $_POST['upgrade_user'] == "ok")
	{
		if ($user_name == "")
			$error_user = "Nom d'utilisateur invalide.";
		else
		{
			$sql = 'SELECT *
				FROM camagru.users
				WHERE pseudo = "'.$user_name.'";';

			$ret = ft_exe_sql_rqt("select user with name", $bdd, $sql);
			if ($ret)
			{
				$data = mysqli_fetch_array($ret);
				if (!$data)
					$error_user = "L'utilisateur n'existe pas.";
				else if ($data['rank'] == 3)
					$error_user = "Cet utilisateur est déjà au rang d'administrateur.";
				else
				{
					$sql = ' UPDATE camagru.users 
						SET rank = "3"	
						WHERE pseudo = "'.$user_name.'";';

					$ret = ft_exe_sql_rqt("upgrade user", $bdd, $sql);
					if (!$ret)
						$error_user = "erreur avec la requete sql.";
					else
					{ ?>
						<script>
							alert("L\'utilisateur a bien été promu admin !");
						</script>
					<?php
					}
				}
			}
			else
				$error_user = "Probleme de bdd.";
		}
	}
	

	//block de suppression de user en bdd.
	if (isset($_POST['del_user']) && $_POST['del_user'] == "ok")
	{
		if ($user_name == "")
			$error_user = "Nom d'utilisateur invalide.";
		else
		{
			$sql = 'SELECT *
			FROM camagru.users
			WHERE pseudo = "'.$user_name.'";';
			$ret = ft_exe_sql_rqt("count user with name", $bdd, $sql);
			if ($ret)
			{
				$data = mysqli_fetch_array($ret);
				if (!$data)
					$error_user = "l'utilisateur n'existe pas.";
				else if ($data['rank'] == 3)
					$error_user = "impossible de supprimer un compte admin";
				else
				{
					$sql = ' DELETE FROM camagru.users 
					WHERE pseudo = "'.$user_name.'";';
					$ret = ft_exe_sql_rqt("delete user", $bdd, $sql);
					if (!$ret)
						$error_user = "erreur avec la requete sql.";
					else
					{ ?>
						<script>
							alert("L\'utilisateur a bien été supprimé de la bdd !");
						</script>
					<?php
					}
				}
			}
			else
				$error_user = "Probleme de bdd.";
		}
	}
?>


<div class="main" >


<?php
// on affiche la partie admin seulement si le rang de l'utilisateur est égal à 3.
	if ($_SESSION['log_status'] == 3)
	{
?>
	<div class="feuille_gestion_compte">

		<div class="grid-5" style="padding-bottom: 25px;">
			<div class="col-5 log-text1">Administration</div>
		</div>
		<hr/>
		<form method="POST">
			<div class="grid-5">
				<div class="setting_name">Nom du filtre</div>
					<select name="filter_name" class="col-2 setting_data" size="1">
						<?php foreach ($filters_available as &$file)
						{
							echo('<option>'.$file.'</option>');
						} ?>
					</select>
					<!-- <input name="filter_name" class="col-2 setting_data"></input> -->
					<button type="submit" name="add_filter" value="ok" class="add_button" >Ajouter</button>
					<button type="submit" name="del_filter" value="ok" class="delete_button">Supprimer</button>
					<div col-4></div>
					<button type="submit" name="add_all_filters" value="ok" class="button3" >Ajouter tous les filtres disponibles.</button>
			</div>
		</form>
			<?php 
				if ($error_filter != "") { ?>
					<div class="col-5 err_mess"><?php echo("Erreur : ".$error_filter);?></div>
					<?php
				}
			?>
		<hr/>


		<form method="POST">
			<div class="grid-5">
				<div class=" setting_name">Nom de l'utilisateur</div>
					<input name="user_name" class="col-2"></input>
					<button type="submit" name="upgrade_user" value="ok" class="add_button" >Admin</button>
					<button type="submit" name="del_user" value="ok" class="delete_button">Supprimer</button>
			</div>
		</form>
		<?php 
				if ($error_user != "") { ?>
					<div class="col-5 err_mess"><?php echo("Erreur : ".$error_user);?></div>
					<?php
				}
			?>
		<hr/>
		
	</div>
<?php
	}
?>

	<div class="feuille_gestion_compte">
		<div class="grid-5" style="padding-bottom: 25px;">
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


</div>


<?php require_once("includes/footer.php"); ?>