<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/forum.css">
    <meta charset="utf-8">
    <title>About</title>
  </head>
  <body>
 	<?php
		include("fonctions/structure.php");
		include("fonctions/forum/forum.php");
		include("fonctions/forum/liste.php");
		head("a");
		if(utilisateur()){
			bar("forum");
		}else{
			header("Location:index.php");
		}
	if(isset($_GET["discussion"])){
		if(exist($_GET["discussion"])){
			afficherDiscussion();
		}else{
			header("Location:forum.php");
		}
	}else{
		discussion();
	}
	bas();?>
  </body>
</html>