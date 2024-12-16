<?php
	//Fontion d'affichage principale de la page amis/liste d'amis
	function listeDamis(){ 
		//La class amis représente la colonne de gauche qui affiche 
		//tous les amis de l'utilisateur
		?>
		<div class="amis">
		<h2>Amis:</h2>
		<?php
		profil("Id_user","Ami",'F'); ?>
		</div>
		<!--
		La class demande représent la colonne de gauche qui affiche 
		toutes les demandes d'amis, en différenciant par des class 
		ceux dont l'utilisateur a envoyé et ceux reçu par l'utilisateur, 
		appellés respectivement envoyer et recue
		-->
		<div class="demande">
		<div class="envoyer">
		<h2>Demande envoyé à:</h2>
		<?php
		profil("Id_user","Ami",'T'); ?>
		</div>
		<div class="recue"><h2>Demande d'ami de:</h2>
		<?php
		profil("Ami","Id_user",'T'); ?>
		</div>
		</div>
		<?php
	}
	//Fonction utilisé par la fonction précédante pour afficher les profils 
	//de ses amis, trier en ordre alphabétiques  
	function profil($condition1,$condition2,$demande){
		//Partie sql 
		$connexion=connexion();
		$utilisateur = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
		$req="SELECT Utilisateur,Image,Visibility FROM amis,user WHERE ".$condition1." IN(SELECT Id FROM user WHERE Utilisateur='$utilisateur') AND user.Id=".$condition2." AND Demande='$demande' ORDER BY Utilisateur";
		$resultat =mysqli_query($connexion,$req);
		//Afficher des infos des amis
		while($donnees=mysqli_fetch_array($resultat)){ 	
			if(acces($donnees['Utilisateur'])=="prive"){
				$image="images/autre/Avatar.png";
			}else{
				$image=$donnees['Image'];
			}
		?>
			<div class="profil">
			<a href=<?php echo"\"profil.php?user=".$donnees['Utilisateur']."\"";?>"><img src=<?php echo"\"".$image."\"";?> ></a><br>
			<div class="pseudo"><?php echo $donnees['Utilisateur'];?>
			</div>
			<a href=<?php echo"\"messages.php?user=".$donnees['Utilisateur']."\"";?>">Message</a>
			</div>
			<?php
		}
	}
	//Fonction qui vérie si l'utilisateur a accés au profil d'un autre utilisateur
	function acces($autre){
		$connexion=connexion();
		$ami= mysqli_real_escape_string($connexion,$autre);
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
?>