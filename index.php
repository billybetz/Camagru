<?php
  $title = "Accueil";
  require_once("config/setup.php");
  require_once("includes/header.php");
?>

<div class="main" >
	<div class="photo_creation">
		<video id="video"></video>
		<canvas id="canvas"></canvas><br>
		<button onclick="take_photo()">Prendre une photo</button>
		<script>
			var video = document.getElementById('video');
			var canvas = document.getElementById('canvas');
			var context = canvas.getContext('2d');
			
			navigator.getUserMedia = navigator.getUserMedia || 
				navigator.webKitGetUserMedia || navigator.mozGetUserMedia || navigator.oGetUserMedia ||
				navigator.msGetUserMedia;
				
			if (navigator.getUserMedia)
			{
				nagigator.getUserMedia({video:true}, streamWebCam, throwError);
			}
			
			function streaWebCam (stream)
			{
				video.src = window.url.createObjectURL(stream);
				video.play();
			}
			
			function throwError(e)
			{
				alert(e.name);
			}
			
			function take_photo()
			{
				canvas.width = video.clientWidth;
				canvas.height = video.clientHeight;
				context.drawImage(video, 0, 0);
			}
				
		</script>
	</div>
	<div class="photo_apercu">

	</div>
</div>

<?php require_once("includes/footer.php"); ?>
