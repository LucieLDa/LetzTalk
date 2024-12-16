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
		include("fonctions/accueil/accueil.php");
		include("fonctions/accueil/inscrilogin.php");
		head("accueil");
		if(!empty($_GET['page']) && $_GET['page']=="deconnexion"){
			deconnexion();
		}else{
			if(!empty($_GET['page']) && $_GET['page']=="email" && !empty($_POST['code'])){
				barvide("a");
				echo "Votre email a été envoyer!";
				email($_POST['id'],$_POST['code'],$_POST['email']);
			}else{
				accueil();
			}
		}
		bas();
	?>
  </body>
</html>
