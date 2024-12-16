<?php
	function modifierMdp(){
		$connexion=connexion();
		if(!empty($_POST['mdp']) & !empty($_POST['mdp2'])){
			if($_POST['mdp']==$_POST['mdp2']){
				$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
				$mdp=mysqli_real_escape_string($connexion,$mdp);
				$utilisateur=mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
				$req="UPDATE user SET Mdp='$mdp' WHERE Utilisateur='$utilisateur'";
				$resultat=mysqli_query($connexion,$req);
				mysqli_close($connexion); ?>
				mdp("modifie");
				<?php
			}else{
				mdp("mdp");
			}
		}else{
			mdp("a");
		}
	}
	function mdp($message){ 
		if($message=="modifie"){
			echo"<div class=\"modifier\">Modification effectuée!</div>";
		}
		?>
		<div class="modifier">
		<form class="modifierMdp" method="post" action="profil.php?page=mdp">
			Nouveau mot de passe :
			<input type="password" name="mdp" placeholder="Nouveau mot de passe..." required>
			<br>Vérification du mot de passe :
			<input type="password" name="mdp2" placeholder=<?php if($message=="mdp"){ echo"\"Pas le même mot de passe\"";}else{echo"\"Répéter le mot de passe\"";} ?> required>
			<br>
			<input type="submit" value="Modifier">
		</form>
		</div>
		<?php
	}
	
?>