<?php
  $title = "Accueil";
  require_once("config/setup.php");
  require_once("includes/header.php");
?>

<div class="grid-4 has-gutter main" >
	<div class="video_interface">
		<video id="video">Browser blocked video</video><br>
	</div>

	<div class="photos_interface">
		<canvas id="photo"></canvas>
	</div>
	<div class="row-2 col-2-small-1">
		
	</div>
	<div >
		<a class="button_photo" onclick="take_photo();">Prendre la photo</a>
	</div>
	<div >
		<a href="" id="button_download" onclick="dl_photo();">Télecharger</a>
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

		function dl_photo()
		{
			var photo_url = photo.toDataURL();
				alert(test);
			button_download.href = photo_url;
			//Permet de telecharger l'url contenu dans href de l'id photo
			// button_download.download = "test.png";

		}

	 </script>

<!-- INCLUSION JS-->
		<script src="js/media_video.js" type="text/javascript"></script>
<?php require_once("includes/footer.php"); ?>
