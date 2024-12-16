<?php
	//Fonction principale
	function commentaire(){
		echo"<div class=\"commentaire\">";
		$connexion=connexion();
		$id_post=mysqli_real_escape_string($connexion,$_GET['post']);
		$req="SELECT * FROM posts WHERE Id = '$id_post'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		echo"<div class=\"post\">";
		echo "<div class=\"titre\">".$donnees['Titre']."</div>";
		echo "<div class=\"contenu\">".$donnees['Contenu']."</div><br>";
		echo"</div>";
		echo"<div class=\"afficherCommentaire\">";
		affichageCommentaire($connexion,$id_post);
		ajouterCommentaire($connexion,$id_post);
		echo"</div>";
		echo"</div>";
	}
	// Form pour rajouter un commentaire
	function ajouterCommentaire($connexion,$id_post){
		if(!empty($_POST['contenu'])){
			//$date=date("Y-m-d H:i:s");
			$contenu=mysqli_real_escape_string($connexion,$_POST["contenu"]);
			$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
			$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			$donnees=mysqli_fetch_assoc($resultat);
			$id_user=mysqli_real_escape_string($connexion,$donnees['Id']);
			$req = "INSERT INTO commentaire(Id_user,Id_post,Contenu) VALUES('$id_user','$id_post','$contenu')";
			$resultat=mysqli_query($connexion,$req);
			$location="Location: profil.php?page=commentaire&post=".$_GET['post'];
			header($location);
		} ?>
		<form method="post" action="<?php echo "profil.php?page=commentaire&post=".$_GET['post']; ?>">
			<textarea name="contenu" placeholder="Votre commentaire..." required></textarea>
			<input type="submit" value="Poster">
		</form>
		<?php
	}
	//Affiche tous les commentaire d'un post
	function affichageCommentaire($connexion,$id_post){
		$req="SELECT Contenu,Id_user,Utilisateur,commentaire.Date FROM commentaire,user WHERE Id_post = '$id_post' AND user.Id=Id_user ORDER BY commentaire.Date DESC";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		echo"<div class=\"desCommentaire\">";
		while($donnees){
			echo"<div class=\"unCommentaire\">";
			echo "<div class=\"utilisateur\"><a href=\"profil.php?user=".$donnees['Utilisateur']."\">".$donnees['Utilisateur']."</a></div>";
			echo "<div class=\"message\">".$donnees['Contenu']."</div>";
			echo "<div class=\"date\">".$donnees['Date']."</div>";
			$donnees=mysqli_fetch_assoc($resultat);
			echo"</div>";
		}
		echo"</div>";
	}
?>