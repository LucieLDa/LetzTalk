<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/recherche.css">
    <meta charset="utf-8">
    <title>About</title>
  </head>
  <body>
 	<?php
		include("fonctions/structure.php");
		include("fonctions/recherche/recherche.php");
		head("a");
		if(utilisateur()){
			bar("recherche");		
		}else{
			header("Location:index.php");
		}
		formulaireRecherche();
		if(isset($_GET['recherche'])){
			recherche($_GET["recherche"]);
		}
	bas();?>
  </body>
</html>