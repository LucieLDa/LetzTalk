<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link rel="stylesheet" href="styles/message.css">
    <meta charset="utf-8">
    <title>Messages</title>
  </head>
  <body>
 	<?php
		include("fonctions/structure.php");
		include("fonctions/message/message.php");
		head("a");
		if(utilisateur()){
			bar("messages");
			if(isset($_GET['user'])){
				if (isset($_POST['message'])){
					sendToAndShow($_SESSION['utilisateur'],$_GET['user']);	
				}else{
					show($_SESSION['utilisateur'],$_GET['user']);
				}
				formulaireMessage();
			}else{
				echo "<div class=\"page\">";
				contact();
				echo "</div>";
			}
		}else{
			header("Locaton:index.php");
		}
	bas();?>
  </body>
</html>
