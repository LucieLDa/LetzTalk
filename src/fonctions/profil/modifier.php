<?php  
	function modifierDonnees(){
		$connexion=connexion();
		if(!empty($_POST['utilisateur']) & !empty($_POST['prenom']) & !empty($_POST['nom']) & !empty($_POST['email']) & !empty($_POST['date']) & !empty($_POST['sexe'])){
			$utilisateur= mysqli_real_escape_string($connexion,$_POST['utilisateur']);
			$nom= mysqli_real_escape_string($connexion,$_POST['nom']);
			$prenom= mysqli_real_escape_string($connexion,$_POST['prenom']);
			$email= mysqli_real_escape_string($connexion,$_POST['email']);
			$date= mysqli_real_escape_string($connexion,$_POST['date']);
			$sexe= mysqli_real_escape_string($connexion,$_POST['sexe']);
			$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			$donnees=mysqli_fetch_assoc($resultat);		
			if($donnees & $donnees['Utilisateur']!=$_SESSION['utilisateur']){
				modifierD("pris",$connexion);
			}else{
				$utilisateur2= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
				$req="SELECT * FROM user WHERE Utilisateur ='$utilisateur2'";
				$resultat=mysqli_query($connexion,$req);
				$donnees=mysqli_fetch_assoc($resultat);	
				$req2 = "SELECT * FROM user WHERE Email ='$email'";
				$resultat2=mysqli_query($connexion,$req2);
				$donnees2=mysqli_fetch_assoc($resultat2);	
					
				if($donnees2 & $donnees2['Email']!=$donnees['Email']){
					modifierD("email",$connexion);
				}else{
					$id = mysqli_real_escape_string($connexion,$donnees['Id']);
					$_SESSION['utilisateur']=htmlspecialchars($_POST['utilisateur']);
					$_COOKIE['utilisateur']=htmlspecialchars($_POST['utilisateur']);
					$req2 = "UPDATE user SET Utilisateur='$utilisateur',Prenom='$prenom', Nom='$nom', Email='$email',Date='$date',Sexe='$sexe' WHERE Id='$id'";
					$resultat2=mysqli_query($connexion,$req2);
					modifierD("modifie",$connexion);
					mysqli_close($connexion);
				}
			}
		}else{
			modifierD("a",$connexion);
		}
	}
	//Formulaire pour modifier les données de l'utilisateur 
	//(hors mot de passe)
	function modifierD($message,$connexion){ 
		if($message=="modifie"){ ?>
			<div class="modifier">Modification effectuée!</div>
			<?php
		}
		$utilisateur = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		$req = "SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		$resultat =mysqli_query($connexion,$req);
		$donnees =mysqli_fetch_assoc($resultat);	
		?>
		<div class="modifier">
		<form class="modifierDonnees" method="post" action="profil.php?page=donnees">
			Nom d'utilisateur :
			<input title="Au maximun 15 characters" type="text"  pattern=".{1,15}" name="utilisateur" placeholder= <?php if($message=="pris"){echo "\"Ce nom d'utilisateur est déjà pris...\"";}else{echo "\"Nom d'utilisateur...\"";} ?> value=<?php echo "\"$donnees[Utilisateur]\""; ?> required>
			<br>Prenom :
			<input type="text" name="prenom" placeholder="Votre prénom" value=<?php echo "\"$donnees[Prenom]\""; ?> required>
			<br>Nom :
			<input type="text" name="nom" placeholder="Votre nom..." value=<?php echo "\"$donnees[Nom]\""; ?> required>
			<br>Votre e-mail :
			<input type="email" name="email" placeholder=<?php if($message=="email"){echo "\"Cet adresse mail est déjà pris...\"";}else{echo "\"Votre email...\"";} ?> value=<?php echo "\"$donnees[Email]\""; ?> required>				
			<br>Date de naissance :
			<input type="date" name="date" value=<?php echo "\"$donnees[Date]\""; ?> required>
			Sexe :<br>
			<label class="container"><input type="radio" name="sexe" value="H" <?php if($donnees['Sexe']=="H"){echo "checked";} ?> required>Homme<span class="checkmark"></span></label>
			<label class="container"><input type="radio" name="sexe" value="F" <?php if($donnees['Sexe']=="F"){echo "checked";} ?> required>Femme<span class="checkmark"></span></label>
			<label class="container"><input type="radio" name="sexe" value="A" <?php if($donnees['Sexe']=="A"){echo "checked";} ?> required>Autre<span class="checkmark"></span></label>
			<br>
			<input type="submit" value="Modifier"><input type="reset" value="Reset">
		</form>
		</div>
		<?php
		mysqli_close($connexion);
	}
?>