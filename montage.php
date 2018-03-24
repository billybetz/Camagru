<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0)
	  header("Location: galerie.php");
?>

<?php
  $title = "Accueil";
  // lance la requete de creation de la bdd si elle n'existe pas.
  require_once("config/setup.php");
  require_once("includes/header.php");

  // contient les variables global utilisés comme les paths relatif.
  require_once("includes/globals.php");
?>

<?php
	$ext_accepted = array('jpg', 'jpeg', 'png', 'gif');
	$picture_dir = "./img/client_photos/";
	$filter_dir = "./img/filters/";

	if (isset($_POST['photo_upload']) && $_POST['photo_upload'] != NULL)
	{
		// TODO : fonction qui importe la photo et la place dans le cadre si le lien est valide. Et mets la variable $_SESSION['pic_is_valid'] a 1 sinon met la variable a 0 et vide le cadre
		echo "upload\n";
	}

	if (isset($_POST['publish']) && $_POST['publish'] == "Publier")
	{
		// TODO : inserer ici ce qu'il faut pour ajouter la photo dans le dossier d'image users.
		echo "publish";
	}
?>

<!-- CORP DE LA PAGE -->

<!-- Partie des filtres -->
<div class="filter_container">
<!-- 	<img class="filter_image" id="test1" onclick="add_filter(this.src);">  </img>
	<img class="filter_image">  </img>
	<img class="filter_image">  </img>
	<img class="filter_image">  </img>
	<img class="filter_image">  </img> -->

	<?php 

			if (isset($_SESSION['id']))
			{
				$sql = 'SELECT *
				FROM camagru.filters;';
				// requete de récupération des image a afficher sur l'index
				$ret = ft_exe_sql_rqt("select pictures of current user", $bdd, $sql);
				while ($filter = mysqli_fetch_array($ret))
				{

					echo'<img  src="'.$filter_dir.$filter['name'].'" class="filter_image" onclick="add_filter(this.src);" alt="filtre" />';
				}
					
			}
		?>


</div>
<!-- <div style="text-align: center;">
	<button class="button_filter" onclick="add_filter();" alt="Ajouter un filtre">Ajouter</button>
</div> -->

<!-- p -->

<div class="grid-3 has-gutter main" >

	<div class="video_interface">
		<video id="video">Browser blocked video</video><br>
		<div style="margin-top: 1em;">
			<a class="button_photo" onclick="take_photo();">Prendre la photos</a>
		</div>
	</div>



	<div class="photos_interface">
		<!-- Cadre pour une photo prise de la webcam -->
		<canvas id="photo_cam">
			Your browser does not accept canvas
		</canvas>

		<!-- Cadre pour une photo qui a été importé -->
		<img id="photo_imported" >
		</img>

		<div style="text-align: center;">
			<form method="post" action="">
				<!-- A rajouter dans la balise input type file pour n'autoriser qu'un certain type de fichier -->
				<!-- accept=".jpg, .jpeg, .png, .gif" -->
			 	<input type="file" onchange="preview_image();" name="photo_upload" id="monfichier" /> 
			 	<br/>

			<!-- TODO : assigner la variable $sessions['pic_is_valid'] pour faire apparaitre le bouton publier -->
			 	<?php if (isset($_SESSION['pic_is_valid']) && $_SESSION['pic_is_valid'] == 1){ ?>
			 	<input style="margin-left: 11em;" type="submit" name="publish" value="Publier" />
			 	<?php } ?>

			</form>

			<!-- <a href="" id="button_download" onclick="dl_photo();">Publier !</a>	 -->
		</div>
	</div>


	<div style="margin-top: -33px;">
		<label class="vos_photo">Vos photos</label>
		<div class="grid-2-small-1 has-gutter preview_container">
		<!-- AFFICHAGE DES PHOTOS DU USER -->
		<div class="mini_galerie">Photo1</div>
		<div class="mini_galerie">Photo2</div>
		<div class="mini_galerie">Photo3</div>
		<div class="mini_galerie">Photo4</div>
		<div class="mini_galerie">Photo5</div>
		<div class="mini_galerie">Photo6</div>
		<?php 

			if (isset($_SESSION['id']))
			{
				$sql = 'SELECT *
				FROM camagru.pictures;';
		?>

		<?php
				// requete de récupération des image a afficher sur l'index
				

				$ret = ft_exe_sql_rqt("select pictures of current user", $bdd, $sql);


				while ($picture = mysqli_fetch_array($ret))
				{
					echo '<div class="mini_galerie">';
					echo'<img  src="'.$picture_dir.$picture['name'].'" alt="" />';
					echo '</div>'; 
				 }
			}
		?>
			</div>
	</div>

	
</div>

<script> 
	var photo_cam = document.getElementById("photo_cam");
	var photo_imported = document.getElementById("photo_imported");
	var video = document.getElementById("video");
	var context = photo_cam.getContext("2d");
	var monfichier = document.getElementById("monfichier");

	var button_download = document.getElementById("button_download");

	function take_photo()
	{
		// replace la div canvas en premier plan et remet la partie
		// importation a null.
		photo_imported.style.visibility = "hidden";
		photo_cam.style.visibility = "visible";
		monfichier.value = "";

		// dessine la video dans le canvas
		photo_cam.width = video.videoWidth;
		photo_cam.height = video.videoHeight;
		context.drawImage(video, 0, 0);

		//dessine le filtre sélectionné.
		
		 
	}

	// fonction pour ajouter un filtre sur la partie video.
	// n'est pas disponible avec l'importation de la photo.
	function add_filter(filter)
	{
		alert('vous avez cliqué sur ' + filter);
	}



	// fonction appellé a l'ajout d'une photo de l'utilisateur
	function preview_image() 
	{
		context.clearRect(0, 0, 32, 32);
		photo_imported.style.visibility = "visible";
		photo_cam.style.visibility = "hidden";

		if (monfichier.files && monfichier.files[0]) 
		{
			
    		var reader = new FileReader();

    		reader.onload = function() 
    		{
    			photo_imported.src = reader.result;
    		}
			reader.readAsDataURL(monfichier.files[0]);
  		}
	}

	
</script>

<!-- INCLUSION JS-->
		<script src="js/media_video.js" type="text/javascript"></script>
<?php require_once("includes/footer.php"); ?>
