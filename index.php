<?php
  $title = "Accueil";
  require_once("config/setup.php");
  require_once("includes/header.php");
  require_once("libft_php/save_image.php");
?>

<?php
	$ext_accepted = array('jpg', 'jpeg', 'png', 'gif');
	$picture_dir = "./img/client_photos/";

	if (isset($_POST['upload_photo']) && $_POST['upload_photo'] == "Importer")
	{
		// on insère la photo dans le cadre
		echo "test";
	}

	if (isset($_POST['publish']) && $_POST['publish'] == "Publier")
	{

	}
?>

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
			 	<input type="file" name="photo_upload" id="monfichier" accept=".jpg, .jpeg, .png, .gif" /><br/>	
			 	<input type="submit" name="upload_photo" value="Importer" />
			</form>

			<!-- <a href="" id="button_download" onclick="dl_photo();">Publier !</a>	 -->
		</div>
	</div>



	<div class="col-1 ">
		<?php 

			if (isset($_SESSION['id']))
			{
				$sql = 'SELECT name
				FROM camagru.pictures
				INNER JOIN users ON pictures.user_id = users.id;
				WHERE users.pseudo = "'.$_SESSION['id'].'"';
		?>


				<div class="grid-3-small-2 has-gutter" style="overflow: scroll; max-height: 500px;">
		<?php
				// requete de récupération des image a afficher sur l'index
				

				$ret = ft_exe_sql_rqt("select pictures of current user", $bdd, $sql);


				foreach ($ret as $pic_name)
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


// Fonction permettant a l'utilisateur de download sa photo
		// function dl_photo()
		// {
		// 	var photo_url = photo.toDataURL();
		// 		alert(test);
		// 	button_download.href = photo_url;
		// 	//Permet de telecharger l'url contenu dans href de l'id photo
		// 	// button_download.download = "test.png";
		// }

</script>

<!-- INCLUSION JS-->
		<script src="js/media_video.js" type="text/javascript"></script>
<?php require_once("includes/footer.php"); ?>
