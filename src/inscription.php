<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/accueil.css"> 
    <meta charset="utf-8">
    <title>Accueil</title>
  </head>
  <body>
	<?php
		include("fonctions/structure.php");
		include("fonctions/accueil/inscrilogin.php");
		head("accueil");
		if(!empty($_POST['utilisateur'])){
			sauvegarder();
		}else{
			if(utilisateur()){
				header("Location:index.php");
			}else{
				barvide("inscription");			
				inscription("paspris");
			}
		}
		bas();
	?>
  </body>
</html>
