<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/profil.css">
    <meta charset="utf-8">
    <title>Profil</title>
  </head>
  <body>
 	<?php
		include("fonctions/structure.php");
		include("fonctions/profil/modifier.php");
		include("fonctions/profil/profil.php");
		include("fonctions/profil/mdp.php");
		include("fonctions/profil/status.php");
		include("fonctions/profil/post.php");
		include("fonctions/profil/photo.php");
		include("fonctions/profil/commentaire.php");
		if(utilisateur()){
			head("a");
			bar("profil");
		}else{
			header("Location:index.php");
		}
		if(isset($_GET['page'])){
			if($_GET['page']=="donnees"){
				modifierDonnees();
			}
			if($_GET['page']=="mdp"){
				modifierMdp();
			}
			if($_GET['page']=="status"){
				modifierProfil();
			}
			if($_GET['page']=="photo"){
				modifierPhoto();
			}
			if($_GET['page']=="commentaire"){			
				commentaire();
			}
			if($_GET['page']!="donnees" & $_GET['page']!="commentaire" & $_GET['page']!="mdp" & $_GET['page']!="status" & $_GET['page']!="photo"){
				header("Location:profil.php");
			}
		}else{
			profil();
		}
	bas();?>
  </body>
</html>