<?php
	//Toutes les fonctions pour la colonne gauche de la page 
	//profil, plus precisement le profil de l'utilisateur
	
	//Fonction principale d'affichage
	function profil(){ 
		if(!empty($_GET['user'])){
			if(exist()){
				$type=acces();
			}else{
				header("Location:profil.php");
			}
		}else{
			$type="user";
		}
		?>
		<div class="profil">
			<div class="user">
				<?php user($type); ?>
			</div>
			<div class="events">
				<?php events($type); ?>
			</div>
			<div class="milieu">
				<?php post($type); ?>
			</div>
		</div>
	<?php
	}
	//Fonctions pour la colonne de droite
	function events($type){
		echo "<div>";
		if($type=="user"){
			demandeAmi();
			echo"</div><div>";
			notifications();
		}else{
			demande();
		}
		echo "</div>";
	}
	function demande(){
		$connexion=connexion();
		$ami=mysqli_real_escape_string($connexion,$_GET['user']);
		$utilisateur=mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		if(!empty($_POST["demande"])){
			$req="SELECT Id FROM user WHERE Utilisateur='$ami'";
			$resultat=mysqli_query($connexion,$req);
			$donnees=mysqli_fetch_assoc($resultat);
			$id=$donnees["Id"];
			$req="INSERT INTO amis(Id_user,Ami) SELECT Id,'$id' FROM user WHERE Utilisateur='$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			$lien="profil.php?user=".$ami;
			header("Location:$lien");
		}
		$req="SELECT * FROM amis WHERE Id_user IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') AND Ami IN(SELECT Id FROM user WHERE Utilisateur='$ami')";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		if($donnees){
			if($donnees["Demande"]=="T"){
				echo "Demande envoye!";
			}else{
				echo "Vous etes amis (Pour le moment)";
			}
		}else{
			$req="SELECT * FROM amis WHERE Id_user IN(SELECT Id FROM user WHERE Utilisateur='$ami') AND Ami IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur')";
			$resultat=mysqli_query($connexion,$req);
			$donnees=mysqli_fetch_assoc($resultat);
			if($donnees){
				echo "L'utilisateur vous a déjà envoyé une demande d'ami";
			}else{
				$lien="\"profil.php?user=".$_GET['user']."\"";
				?>
				Demande d'ami<br>
				<form action=<?php echo$lien; ?> method="post">
					<input type="hidden" name="demande" value="ok">
					<input type="submit" value="Envoyer">
				</form>
				<?php
			}
		}
	}
	function demandeAmi(){
		$connexion=connexion();
		$utilisateur=mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		if(!empty($_POST["id"])){
			$id=mysqli_real_escape_string($connexion,$_POST['id']);
			if($_POST["demande"]=="Accepter"){
				$req="INSERT INTO amis(Id_user,Ami,Demande) SELECT Ami,Id_user,'F' FROM amis WHERE Id='$id'";
				$resultat=mysqli_query($connexion,$req);
				$req="UPDATE amis SET Demande='F' WHERE Id='$id'";
				$resultat=mysqli_query($connexion,$req);
			}else{			
				$req="DELETE FROM amis WHERE Id='$id'";
				$resultat=mysqli_query($connexion,$req);
			}
			header("Location:profil.php");
		}
		$req="SELECT * FROM amis WHERE Ami IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') AND Demande='T'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		if(!$donnees){
			echo "Aucune demande";
		}else{
			while($donnees){
				$id=mysqli_real_escape_string($connexion,$donnees['Id_user']);
				$req2="SELECT * FROM user WHERE Id='$id'";
				$resultat2=mysqli_query($connexion,$req2);
				$demande=mysqli_fetch_assoc($resultat2);
				echo $demande['Utilisateur'];
				echo "<br>";
				?>
				<form action="profil.php" method="post">
					<input type="hidden" name="id" value=<?php echo"\"".$donnees['Id']."\""; ?> >
					<input type="submit" value="Accepter" name="demande">
				</form>
				<form action="profil.php" method="post">
					<input type="hidden" name="id" value=<?php echo"\"".$donnees['Id']."\""; ?> >
					<input type="submit" value="Refuser" name="demande">
				</form>
				<?php
				$donnees=mysqli_fetch_assoc($resultat);
			}
		}
	}
	function notifications(){
		$connexion=connexion();
		$utilisateur=mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		$req="SELECT * FROM amis WHERE Id_user IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') AND Demande='F' ORDER BY Notifications DESC";
		$resultat=mysqli_query($connexion,$req);
		while($donnees=mysqli_fetch_assoc($resultat)){
			$id=mysqli_real_escape_string($connexion,$donnees['Ami']);
			$req2="SELECT * FROM user WHERE Id='$id'";
			$resultat2=mysqli_query($connexion,$req2);
			$donnees2=mysqli_fetch_assoc($resultat2);
			echo "<a href=\"profil.php?user=".$donnees2['Utilisateur']."\">".$donnees2['Utilisateur']."</a> ";
			echo $donnees['Notifications'];
			echo "<br>";
		}
	}
	//Fonctions pour la colonne gauche
	function user($type){
		$connexion=connexion();
		if($type=="user"){	
			$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
			$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		}else{
			$utilisateur= mysqli_real_escape_string($connexion,$_GET['user']);
			$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		}
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		if($type=="prive"){
			$image="images/autre/Avatar.png";
		}else{
			$image=$donnees['Image'];
		}
		?>
		<div class="photoprofil">
		<img src="<?php echo $image; ?>">
		<?php 
		if($type=="user"){ ?>
			<a class="crayon" href="profil.php?page=photo"><img src="images/autre/crayon.png"></a>
		<?php
		} ?>
		</div>
		<?php echo $donnees['Utilisateur']; ?>
		<?php
		if($type!="prive"){ ?>
		<div class="icon">
			<img src="images/autre/humeur.png"> <?php echo$donnees['Humeur']; ?>
			<br><img src="images/autre/ville.jpg"> <?php echo$donnees['Ville']; ?>
			<br><img src="images/autre/metier.png"> <?php echo$donnees['Metier']; ?>
		</div>
		<?php
		}
		if($type=="user"){ ?>
		<a href="profil.php?page=donnees">Modifier données</a>
		<br><a href="profil.php?page=mdp">Mot de passe</a>
		<br><a href="profil.php?page=status">Modifier profil</a>
		<?php
		}
	}
	function acces(){
		$connexion=connexion();
		$ami= mysqli_real_escape_string($connexion,$_GET['user']);
		$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		$req="SELECT Visibility FROM user WHERE Utilisateur='$ami'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		if($donnees['Visibility']=='prive'){
			return "prive";
		}else{
			$req="SELECT * FROM amis WHERE Id_user IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') AND Ami IN(SELECT Id FROM user WHERE Utilisateur='$ami') AND Demande='F' ";
			$resultat2=mysqli_query($connexion,$req);
			$donnees2=mysqli_fetch_assoc($resultat2);
			if($donnees['Visibility']=='public' || ($donnees['Visibility']=='amis' && $donnees2)){
				return "acces";
			}else{
				return "prive";
			}
		}
	}
	function exist(){
		$connexion=connexion();
		$utilisateur= mysqli_real_escape_string($connexion,$_GET['user']);
		$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		if($donnees && $donnees['Utilisateur']!=$_SESSION['utilisateur']){
			return true;
		}else{
			return false;
		}
	}
?>