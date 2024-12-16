<?php
	function accueil(){
		if(utilisateur()){
			bar("a");
			echo "<p>Bienvenue ";
			echo htmlspecialchars($_SESSION['utilisateur']);
			echo "!</p>";
			echo "<a href =\"index.php?page=deconnexion\">Déconnexion</a>";
		}else{
			barvide("a");
			?><p>Bienvenue, inscrivez-vous si ce n'est pas déjà fait!<p><?php
		}
	}	
?>