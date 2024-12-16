<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/accueil.css"> 
    <meta charset="utf-8">
    <title>Vérification</title>
  </head>
  <body>
	<?php
		include("fonctions/structure.php");
		include("fonctions/accueil/accueil.php");
		include("fonctions/accueil/inscrilogin.php");
		head("accueil");
		barvide("a");
		if(utilisateur()){
			header("Location:index.php");
		}else{
			if(!empty($_GET['id']) && !empty($_GET['code'])){
				verificationMail();
			}else{
				header("Location:index.php");
			}
		}
		bas();
	?>
  </body>
</html>