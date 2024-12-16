<?php
	//Fonction principale d'affichage
	function modifierPhoto(){
		if(!empty($_POST['submit'])){
			uploadPhoto();			
		}else{
			formPhoto("rien");
		}
	}
	//Fonction affichant le formulaire pour choisir nouvellle photo
	function formPhoto($message){ 
		if($message!="rien"){
			echo"<div class=\"modifier\">".$message."</div>";
		}
		?>
		<div class="modifier">
		<form action="profil.php?page=photo" method="post" enctype="multipart/form-data">
			Choisissez votre nouvelle photo de profil :
			<input type="file" name="photo" required>
			<input type="submit" value="Upload Image" name="submit">
		</form>
		</div>
		<?php
	}
	//Fonction qui upload image
	function uploadPhoto(){
		$connexion=connexion();
		//récupérer id de l'utilisateur
		$utilisateur = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		$req = "SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		$resultat =mysqli_query($connexion,$req);
		$donnees =mysqli_fetch_assoc($resultat);
		//Change le nom du fichier et prépare son emplacement
		$fichier ="images/profil/". $donnees['Id'].".".strtolower(pathinfo(basename($_FILES["photo"]["name"]),PATHINFO_EXTENSION));
		$format = strtolower(pathinfo($fichier,PATHINFO_EXTENSION));
		//vérifier le format du fichier
		if($format != "jpg" && $format != "png" && $format != "jpeg"&& $format != "gif" ) {
			formPhoto("Seulement les formats JPG, JPEG, PNG et GIF sont autorisés");
		}else{
			//upload de l'image
			move_uploaded_file($_FILES["photo"]["tmp_name"], $fichier);
			$image=mysqli_real_escape_string($connexion,$fichier);
			$req = "UPDATE user SET Image='$image' WHERE Utilisateur = '$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			if(!$resultat){
				formPhoto("Problème de connexion");
			}else{
				formPhoto("Modification effectuée!");
			}
		}	
	}
?>