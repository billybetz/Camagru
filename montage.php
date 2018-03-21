<?php
  if(session_id() == "")
	  session_start();
  
  // verifie si l'utilisateur n'est pas deja connecté.
  if (!isset($_SESSION['log_status']) || $_SESSION['log_status'] == 0)
	  header("Location: galerie.php");
?>

<?php
  $title = "Accueil";
  require_once("config/setup.php");
  require_once("includes/header.php");
  require_once("libft_php/save_image.php");
?>

<?php
	$ext_accepted = array('jpg', 'jpeg', 'png', 'gif');
	$picture_dir = "./img/client_photos/";

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

<div class="filter_container">
	<a class="filter_image"> TEST1 </a>
</div>

<div class="grid-3 has-gutter main" >

	<div class="video_interface">
		<video id="video">Browser blocked video</video><br>
		<div style="margin-top: 1em;">
			<a class="button_photo" onclick="take_photo();">Prendre la photos</a>
		</div>
	</div>



	<div class="photos_interface">
		<canvas id="photo"></canvas>
		<div style="margin-top: 1em;">
			<form method="post" action="">
				<!-- A rajouter dans la balise input type file pour n'autoriser qu'un certain type de fichier -->
				<!-- accept=".jpg, .jpeg, .png, .gif" -->
			 	<input type="file" name="photo_upload" id="monfichier" onchange="insert_imported_image();" /> 
			 	<br/>

			 <!-- TODO : assigner la variable $sessions['pic_is_valid'] pour faire apparaitre le bouton publier -->
			 	<?php if (isset($_SESSION['pic_is_valid']) && $_SESSION['pic_is_valid'] == 1){ ?>
			 	<input style="margin-left: 11em;" type="submit" name="publish" value="Publier" />
			 	<?php } ?>

			</form>

			<!-- <a href="" id="button_download" onclick="dl_photo();">Publier !</a>	 -->
		</div>
	</div>



	<div class="">

		<!-- AFFICHAGE DES PHOTOS DU USER -->
		<?php 

			if (isset($_SESSION['id']))
			{
				$sql = 'SELECT *
				FROM camagru.pictures;';
		?>


				<div class="grid-3-small-2 has-gutter" style="overflow: scroll; max-height: 500px;">
		<?php
				// requete de récupération des image a afficher sur l'index
				

				$ret = ft_exe_sql_rqt("select pictures of current user", $bdd, $sql);


				while ($pic_name = mysqli_fetch_array($ret))
				{
		?>
					<div class="mini_galerie">
		<?php 
					echo'<img  src="'.$picture_dir.$pic_name.'" alt="" />'
		?>
					</div>
		<?php 
				 	}
					
				}
		?>
				

		</div>
	</div>
	
</div>

<script> 
		var photo = document.getElementById("photo");
		var video = document.getElementById("video");
		var context = photo.getContext("2d");
		var test = 1;

		var button_download = document.getElementById("button_download");

		function take_photo()
		{
			test = 2;
			photo.width = video.videoWidth;
			photo.height = video.videoHeight;
			context.drawImage(video, 0, 0);
		}

		function insert_imported_image()
		{
			alert("ok");
			var file    = document.querySelector('input[type=file]').files[0]	;
			alert(file);
			var reader  = new FileReader();

			reader.addEventListener("load", function () {
    			photo.src = reader.result;
    		}, false);

  			if (file) {
    		reader.readAsDataURL(file);
  		}

			// alert("ok");
			// image = new Image();
			// image.src = image_imported;

			// photo.width = video.videoWidth;
			// photo.height = video.videoHeight;
			// photo.drawImage(image, 0, 0);
		}


// Fonction permettant a l'utilisateur de download sa photo
		// function dl_photo()
		// {
			// var photo_url = photo.toDataURL();
				// alert(test);
			// button_download.href = photo_url;
			//Permet de telecharger l'url contenu dans href de l'id photo
			// button_download.download = "test.png";
		// }

</script>

<!-- INCLUSION JS-->
		<script src="js/media_video.js" type="text/javascript"></script>
<?php require_once("includes/footer.php"); ?>
