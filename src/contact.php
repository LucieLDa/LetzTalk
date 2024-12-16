<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="test.css"> 
    <meta charset="utf-8">
    <title>Contact</title>
  </head>
  <body> 
	<?php
		include("fonctions/structure.php");
		head("contact");
		if(utilisateur()){
			bar("contact");
		}else{
			barvide("contact");
		}
	?>
	<p>Adresse Mail: nomdusite@mail.com</p>
	<?php bas();?>
  </body>
 </html>