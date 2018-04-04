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
  require_once("includes/header.php");
  require_once("php_functions/sql_rqt.php");

  // contient les variables global utilisés comme les paths relatif.
  require_once("includes/globals.php");
  if (isset($_SESSION['test']))
  {
  	echo (" ok : " . $_SESSION['test']);
  }
  else
  {
  	echo ("KO");
  }
?>

<!-- CORP DE LA PAGE -->

<!-- Partie des filtres -->
<div class="filter_container">

	<?php 
		$sql = 'SELECT *
		FROM camagru.filters;';
		// requete de récupération des image a afficher sur l'index
		$ret = ft_exe_sql_rqt("select pictures of current user", $bdd, $sql);
		while ($filter = mysqli_fetch_array($ret))
		{
			echo'<img  src="'.$filter_dir.$filter['name'].'" class="filter_image" onclick="add_filter(this.src);" alt="filtre" />';
		}
	?>


</div>

<div class="grid-3 has-gutter main" >

	<div class="video_interface">
		<video id="video" onclick="change_filter_pos(event);">Browser blocked video</video><br>
		<div style="margin-top: 1em;">
			<a src="#" id="button_photo" onclick="take_photo();">Prendre la photos</a>
		</div>
		
	</div>



	<div class="photos_interface">
		<!-- Cadre pour une photo prise de la webcam -->
		<canvas id="photo_cam">
			Your browser does not accept canvas
		</canvas>

		<!-- Cadre pour une photo qui a été importé -->
		<img id="photo_imported">
		</img>

		<div style="text-align: center;">
			<!-- A rajouter dans la balise input type file pour n'autoriser qu'un certain type de fichier -->
			<!-- accept=".jpg, .jpeg, .png, .gif" -->
		 	<input type="file" onchange="preview_image_imported();" name="photo_upload" id="monfichier" /> 
		 	<br/>

			<!-- Bouton pour publier -->
			<a src="" id="button_publish" onclick="publish();">Publier !</a>


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
<canvas id='blank_canvas' style='display:none'></canvas>
<script> 
	var photo_cam = document.getElementById("photo_cam");
	var photo_imported = document.getElementById("photo_imported");
	var video = document.getElementById("video");
	var context = photo_cam.getContext("2d");
	var monfichier = document.getElementById("monfichier");
	var button_download = document.getElementById("button_download");
	var filter_img = document.getElementById("filter_img");	
	var button_photo = document.getElementById("button_photo");
	var button_publish = document.getElementById("button_publish");

	var left_position_cam = video.offsetLeft;
	var top_position_cam = video.offsetTop;

	var width_cam = video.offsetWidth;
	var height_cam = video.offsetHeight;

	var width_photo_cam = photo_cam.offsetWidth;
	var height_photo_cam = photo_cam.offsetHeight;

	var filter_width =  width_cam * 37 / 100;
	var filter_height = height_cam * 37 / 100;
	


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

		// Degrisement du bouton et le rend cliquable
		button_photo.style.cursor = "pointer";
		button_photo.bgColor =  "#e8e3e3";
		button_photo.style.color = "black";
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
		if (filter_img.src)
		{
			var left_pos_purcent_filter = 100 * (filter_img.offsetLeft -		left_position_cam) / (width_cam);
			var top_pos_purcent_filter = relative_filter_pos_y = 100 * (filter_img.offsetTop - top_position_cam) / (height_cam);

			var relative_filter_pos_x = left_pos_purcent_filter * video.videoWidth / 100;
			var relative_filter_pos_y = top_pos_purcent_filter * video.videoHeight / 100;

			var filter_photo_width = filter_width * video.videoWidth / width_cam;
			var filter_photo_height = filter_height * video.videoHeight / height_cam;


			// ---- replace la div canvas en premier plan et remet la partie  
			// importation a null. ----
			photo_imported.style.visibility = "hidden";
			photo_cam.style.visibility = "visible";
			button_publish.style.display = "block";
			monfichier.value = "";
			// ---- ******************************* ----

			//  ---- dessine la video dans le canvas ----
			video.videoWidth = video.offsetWidth
			photo_cam.width = video.videoWidth;
			photo_cam.height = video.videoHeight;
			// ---- ******************************* ----


			context.drawImage(video, 0, 0);
			//dessine le filtre sélectionné.
			context.drawImage(filter_img , relative_filter_pos_x, relative_filter_pos_y, filter_photo_width,filter_photo_height);	
		}
		else
		{
			alert("Vous devez choisir un filtre.");
		}
	}

	// fonction appellé a l'ajout d'une photo de l'utilisateur
	function preview_image_imported() 
	{
		if (monfichier.files && monfichier.files[0]) 
		{
    		var reader = new FileReader();

    		//affichage du bouton publier.
    		button_publish.style.display = "block";
    		//effacage du canvas de la photo prise sur la video
    		context.clearRect(0, 0, 32, 32);
    		//on cache la balise cancas et affiche la balise img.
			photo_imported.style.visibility = "visible";
			photo_cam.style.visibility = "hidden";

    		reader.onload = function() 
    		{
    			photo_imported.src = reader.result;
    		}
			reader.readAsDataURL(monfichier.files[0]);
  		}
	}

	function publish()
	{
		var photo;
		var blank_canvas = document.getElementById('blank_canvas');
		
		if (photo_cam.toDataURL("image/png") == blank_canvas.toDataURL() && !photo_imported.src)
		{
			// si rien a été dessiner dans le canvas et aucune image d'importée, on empeche la publication
			alert("vous devez prendre ou importer une photo avant de publier.");
		}
		else
		{
			if (photo_imported.src)
				photo = photo_imported.src;
			else
				photo = photo_cam.toDataURL();
			
			// Requete Ajax
			var http = new XMLHttpRequest();
			var url = "ajax.php";

			// récupération du pseudo de l'utilisateur courant 
			var id = <?php echo ("\"".$_SESSION['id']."\"")?>;

			// création des paramètres a envoyer  a la fonction ajax
			var params = "fonction=get_photo&photo="+ photo + "&user=" + id;

			// on ouvre les ports serveur pour pouvoir faire la requete ajax
			http.open("POST", url, true);

			//application du header de http
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			// dès que le serveur change la valeur de readyState de la requete http on rentre dans cette fonction.
			http.onreadystatechange = function() 
			{//Call a function when the state changes.
    			if(http.readyState == 4 && http.status == 200) 
    			{
        			alert(http.responseText);
    			}
			}
			http.send(params);
		}
	}

	
</script>
<!-- INCLUSION JS-->
	<!-- fonction de récupération de caméra -->
	<script src="js/media_video.js" type="text/javascript"></script>

<?php require_once("includes/footer.php"); ?>
