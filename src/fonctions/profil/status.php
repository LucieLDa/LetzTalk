<?php
	//Fonction principale pour modifier le status de l'utilisateur
	function modifierProfil(){
		$connexion=connexion();
		$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		if(!empty($_POST['humeur']) & !empty($_POST['ville']) & !empty($_POST['metier']) & !empty($_POST['visibility'])){
			$humeur=mysqli_real_escape_string($connexion,$_POST['humeur']);
			$ville=mysqli_real_escape_string($connexion,$_POST['ville']);
			$metier=mysqli_real_escape_string($connexion,$_POST['metier']);
			$visibility=mysqli_real_escape_string($connexion,$_POST['visibility']);
			$req = "UPDATE user SET Humeur='$humeur',Visibility='$visibility',Ville='$ville',Metier='$metier' WHERE Utilisateur='$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			?> <p>Modification effectuée!</p> <?php
		}else{
			formProfil($connexion);
		}
		mysqli_close($connexion);
	}
	function formProfil($connexion){
		$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		?>
		<div class="modifier">
		<form class="modifierProfil" method="post" action="profil.php?page=status">
			Humeur: <input type="text" name="humeur" placeholder="Votre humeur..." value="<?php echo$donnees['Humeur']; ?>" required>
			<br>Ville: <input type="text" name="ville" placeholder="Votre ville..." value="<?php echo$donnees['Ville']; ?>" required>
			<br>Metier: <input type="text" name="metier" placeholder="Votre metier..." value="<?php echo$donnees['Metier']; ?>" required>
			<br>Visibilité:
			<select name="visibility">
				<option value="public">public</option>
				<option <?php if($donnees['Visibility']=="amis"){echo"selected";} ?> value="amis">amis seulement</option>
				<option <?php if($donnees['Visibility']=="prive"){echo"selected";} ?> value="prive">privé</option>
			</select>
			<br><input type="submit" value="Envoyer"><input type="reset" value="Effacer">			
		</form>
		</div>
		<?php
	}
?>