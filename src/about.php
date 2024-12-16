<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="test.css">
    <meta charset="utf-8">
    <title>About</title>
  </head>
  <body>
 	<?php
		include("fonctions/structure.php");
		head("about");
		if(utilisateur()){
			bar("about");
		}else{
			barvide("about");
		}
	?>
	<p>Ce site est blablabla...</p>
	<?php bas();?>
  </body>
</html>
