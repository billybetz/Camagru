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
		<video id="video" onclick="change_filter_pos(event);">Browser blocked video</video><br>
		<div style="margin-top: 1em;">
			<a src="#" class="button_photo" onclick="take_photo();">Prendre la photos</a>
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

<img id="filter_img" onclick="change_filter_pos(event);"></div>
<script> 
	var photo_cam = document.getElementById("photo_cam");
	var photo_imported = document.getElementById("photo_imported");
	var video = document.getElementById("video");
	var context = photo_cam.getContext("2d");
	var monfichier = document.getElementById("monfichier");
	var button_download = document.getElementById("button_download");
	var filter_img = document.getElementById("filter_img");	

	var filter_width = 150;
	var filter_height = 150;

	var left_position_cam = video.offsetLeft;
	var top_position_cam = video.offsetTop;

	var width_cam = video.offsetWidth;
	var height_cam = video.offsetHeight;
	


	// fonction pour ajouter un filtre sur la partie video.
	// n'est pas disponible avec l'importation de la photo.
	function add_filter(filter)
	{
		filter_img.style.height = filter_height;
		filter_img.style.width = filter_width;
		filter_img.src = filter;
		filter_img.style.position = "absolute";
		filter_img.style.top = top_position_cam + height_cam / 6;
		filter_img.style.left = left_position_cam + width_cam / 3;
	}
	
	function change_filter_pos(event)
	{
		var mouse_pos_x = event.clientX;
		var mouse_pos_y = event.clientY;

		if (mouse_pos_y > top_position_cam && mouse_pos_y < top_position_cam + height_cam && mouse_pos_x > left_position_cam && mouse_pos_x < left_position_cam + width_cam)
		{
			// placement du millieu du filtre sur la souris
			filter_img.style.top = mouse_pos_y - filter_height / 2 ;
			filter_img.style.left = mouse_pos_x - filter_width / 2;
		}
	}

	function take_photo()
	{
		var relative_filter_pos_x = filter_img.offsetLeft - left_position_cam;
		var relative_filter_pos_y = filter_img.offsetTop - top_position_cam;
		// replace la div canvas en premier plan et remet la partie
		// importation a null.
		photo_imported.style.visibility = "hidden";
		photo_cam.style.visibility = "visible";
		monfichier.value = "";

		// dessine la video dans le canvas
		video.videoWidth = video.offsetWidth
		photo_cam.width = video.videoWidth;
		photo_cam.height = video.videoHeight;
		alert("cam width : " + photo_cam.offsetWidth + " video offsetWidth : " + video.offsetWidth + " test : " + video.videoWidth);
		context.drawImage(video, 0, 0);
		context.drawImage(filter_img , relative_filter_pos_x, relative_filter_pos_y);

		//dessine le filtre sélectionné.	 
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
