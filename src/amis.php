<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/amis.css">
    <meta charset="utf-8">
    <title>About</title>
  </head>
  <body>
 	<?php
		include("fonctions/structure.php");
		include("fonctions/amis/amis.php");
		head("a");
		if(utilisateur()){
			bar("amis");
		}else{
			header("Location:index.php");
		}
	echo "<div class=\"page\">";
	listeDamis();
	echo "</div>";
	bas();?>
  </body>
</html>