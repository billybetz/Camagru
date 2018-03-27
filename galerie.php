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
	<div class="image_galerie"></div>
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

<?php require_once("includes/footer.php"); ?>
