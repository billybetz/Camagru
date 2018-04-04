<?php
  $title = "Galerie";
  require_once("includes/header.php");
?>

<?php
	//TODO: comptage des images a afficher pour anticiper la pagination.
	$last_page = 10;

	if (isset($_GET['page']))
	{
		if ($_GET['page'] < 1 || $_GET['page'] > $last_page)
		{
		?>
			<script>
				window.location.replace("galerie.php?page=1");
			</script>
		<?php
		}
		$page = $_GET['page'];
	}
	else
		$page = 1;
	
	$page_suiv = $page + 1;
	$page_prec = $page - 1;
	$prec = '<a style="float: left;" href="galerie.php?page='.$page_prec.'"><img src="img/utile/left_arrow.png"></a>';

	$suiv = '<a style="float: right;" href="galerie.php?page='.$page_suiv.'"><img src="img/utile/right_arrow.png"></a>';
?>

<div class="galerie_container grid-3 has-gutter" >
	
	<div class="image_galerie">
		<img src="img/filters/masque1_filtre.png">
	</div>
	<div class="image_galerie" onclick="focus_photo(this.src);"></div>
	<div class="image_galerie"></div>
	<div class="image_galerie"></div>
	<div class="image_galerie"></div>
	<div class="image_galerie"></div>
</div>
<div class="galerie_pagination">
	<?php 
		if ($page > 1)
			echo ($prec);
		if ($page < $last_page)
			echo ($suiv);
	?>
	<!-- <a style="float: left;" href="galerie.php"><img src="img/utile/left_arrow.png"></a> -->
	<!-- <a style="float: right;" href="galerie.php"><img src="img/utile/right_arrow.png"></a> -->
</div>

<!-- div de premier plan lors du click sur une image -->
<?php

?>
<div id="image_focused">

</div>

<script type="text/javascript">
	var image_focused = getElementById("image_focused");

	function focus_photo(image)
	{
		if (window.XMLHttpRequest) 
		{
   	 		// code for modern browsers
   			xhr = new XMLHttpRequest();
 		} 
 		else 
 		{
    		// code for old IE browsers
    		xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}

		var value1 = encodeURIComponent(value1),
   		value2 = encodeURIComponent(value2);

		xhr.open('GET', 'http://http://localhost/camagru/montage.php?param1=' + value1 + '&param2=' + value2);

		// Lorsqu'un réponse est émise par le serveur
		xhr.onreadystatechange = function() 
		{
  			if (xhr.status == 200 && xhr.readyState == 4) 
  			{
       			document.getElementById('content').innerHTML = xhr.responseText;
        	 
        	// xhr.responseText contient exactement ce que la page PHP renvoi
 	   		}
		};
 
	xhr.open('GET', 'profile.php?id=1');
	xhr.send('');


	image_focused.src = image;
	}
</script>

<?php require_once("includes/footer.php"); ?>
