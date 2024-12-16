<?php
	//Les fonction de ce fichier php sert pour la colonne du milieu 
	//de la page profil
	
	//fonction principale 
	function post($type){
		if($type=="user"){
			nouveauPost();
		}	
		$connexion=connexion();
		$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		if(!empty($_POST['titre']) && !empty($_POST['contenu'])){
			$titre=mysqli_real_escape_string($connexion,$_POST["titre"]);
			$contenu=mysqli_real_escape_string($connexion,$_POST["contenu"]);
			$req = "INSERT INTO posts(Titre,Contenu,User) SELECT '$titre','$contenu',Id FROM user WHERE Utilisateur='$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			$req= "UPDATE amis SET Notifications=Notifications +1 WHERE Ami IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') AND Demande='F'";
			$resultat=mysqli_query($connexion,$req);
			header("Location:profil.php;");
		}
		if(!empty($_GET['action']) && $_GET['action']=="supprimer"){
			supprimerPost($utilisateur);
		}
		if($type!="prive"){
			afficherPost($type);
		}else{ ?>
			<div class="post"><div class="titre">Ce profil est privé</div></div>
		<?php
		}
	}
	//Form pour un nouveau ppost
	function nouveauPost(){
		?>
		<div class="form">
		<form method="post" action="profil.php">
		<input autocomplete="off" type="text" name="titre" placeholder="Titre de votre post..." required>
		<textarea name="contenu" placeholder="Votre post..." required></textarea>
		<input type="submit" value="Poster">
		</form>
		</div>
		<?php
	}
	//Affiche tous les posts de l'utilisateur
	function afficherPost($type){
		$connexion=connexion();
		if($type=="user"){
			$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		}else{
			$utilisateur= mysqli_real_escape_string($connexion,$_GET['user']);
		}
		$req="SELECT * FROM posts WHERE User IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') ORDER BY Date DESC";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		while($donnees){
			echo "<div class=\"post\">";
			echo "<div class=\"titre\">".$donnees['Titre']."</div>";
			echo "<div class=\"contenu\">";
			echo $donnees['Contenu']."</div>";
			echo "<a href=\"profil.php?page=commentaire&post=$donnees[Id]\">Commentaires</a>";
			if($type=="user"){
			echo "<a class=\"droite\" href=\"profil.php?action=supprimer&post=$donnees[Id]\">Supprimer ce post</a>";
			}
			echo "</div>";
			$donnees=mysqli_fetch_assoc($resultat);
		}
	}
	function supprimerPost($utilisateur){
		$connexion=connexion();
		$id= mysqli_real_escape_string($connexion,$_GET['post']);
		$req="DELETE FROM posts WHERE Id='$id' AND User IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur')";
		$resultat=mysqli_query($connexion,$req);
		header("Location:profil.php");
	}
?>