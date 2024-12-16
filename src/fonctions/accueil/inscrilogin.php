<?php
	function descriInscritLogin(){ ?>
		<div class="description">
			<p>Inscrivez-vous pour pouvoir chatter en ligne avec vos amis, échanger et partager des photos de moments passés ensembles! <br> Pratique, efficace et gratuit, ce réseau vous permettra de garder le contact de manière simple et agréable avec les pokémons qui vous entourent! Enjoy!!</p>
		</div>
	<?php
	}
	function inscription($message){				
		?>
		<div class="inscription">		
		<form method="post" action="inscription.php">
			Nom d'utilisateur :
			<input title="Au maximun 15 characters" type="text" name="utilisateur" placeholder=<?php if($message=="pris"){echo "\"Ce nom d'utilisateur est déjà pris...\"";}else{echo "\"Nom d'utilisateur...\"";} ?> <?php if(!empty($_POST['utilisateur'])& $message!="pris"){echo "value=\"$_POST[utilisateur]\"";} ?> pattern=".{1,15}" required>
			Mot de passe :
			<input type="password" name="mdp" placeholder="Mot de passe..." pattern=".{6,}" title="Doit au moins contenir 6 characters" required>
			Retaper mot de passe :
			<input type="password" name="mdp2" placeholder=<?php if($message=="mdp"){echo "\"Vous avez mal recopié votre mot de passe...\"";}else{echo "\"Mot de passe...\"";} ?> required>
			Prenom :
			<input type="text" name="prenom" <?php if(!empty($_POST['prenom'])){echo "value=\"$_POST[prenom]\"";} ?> placeholder="Votre prénom" required>
			Nom :
			<input type="text" name="nom" <?php if(!empty($_POST['nom'])){echo "value=\"$_POST[nom]\"";} ?> placeholder="Votre nom..." required>
			Votre e-mail :
			<input type="email" name="email" placeholder=<?php if($message=="email"){echo "\"Cet adresse mail est déjà pris...\"";}else{echo "\"Votre adressed mail...\"";} ?> <?php if(!empty($_POST['email'])& $message!="email"){echo "value=\"$_POST[email]\"";} ?> required>
			Date de naissance :
			<input type="date" name="date" <?php if(!empty($_POST['date'])){echo "value=\"$_POST[date]\"";} ?>required>
			Sexe :<br>
			<label class="container"><input type="radio" name="sexe" value="H" <?php if(!empty($_POST['sexe'])){if($_POST['sexe']=="H"){echo "checked";}} ?> required>Homme<span class="checkmark"></span></label>
			<label class="container"><input type="radio" name="sexe" value="F" <?php if(!empty($_POST['sexe'])){if($_POST['sexe']=="F"){echo "checked";}} ?> required>Femme<span class="checkmark"></span></label>
			<label class="container"><input type="radio" name="sexe" value="A" <?php if(!empty($_POST['sexe'])){if($_POST['sexe']=="F"){echo "checked";}} ?> required>Autre<span class="checkmark"></span></label>
			<br>
			<input type="submit" value="Envoyer"><input type="reset" value="Effacer">
		</form>
		<?php descriInscritLogin(); ?>
		</div>
	<?php
	}
	function sauvegarder(){
		if(!empty($_POST['utilisateur']) & !empty($_POST['mdp']) & !empty($_POST['mdp2']) & !empty($_POST['nom']) & !empty($_POST['prenom']) & !empty($_POST['date']) & !empty($_POST['sexe']) & !empty($_POST['email'])){
			if($_POST['mdp']!=$_POST['mdp2']){
				barvide("inscription");
				inscription("mdp");
			}else{
				$connexion=connexion();
				$utilisateur= mysqli_real_escape_string($connexion,$_POST['utilisateur']);
				$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
				$resultat=mysqli_query($connexion,$req);
				$donnees=mysqli_fetch_assoc($resultat);
				if($donnees){
					barvide("inscription");
					inscription("pris");
				}else{
					$email=mysqli_real_escape_string($connexion,$_POST['email']);
					$req = "SELECT * FROM user WHERE Email = '$email'";
					$resultat=mysqli_query($connexion,$req);
					$donnees=mysqli_fetch_assoc($resultat);
					if($donnees){
						barvide("inscription");
						inscription("email");
					}else{
						$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
						$mdp=mysqli_real_escape_string($connexion,$mdp);
						$nom= mysqli_real_escape_string($connexion,$_POST['nom']);
						$prenom= mysqli_real_escape_string($connexion,$_POST['prenom']);
						$date= mysqli_real_escape_string($connexion,$_POST['date']);
						$sexe= mysqli_real_escape_string($connexion,$_POST['sexe']);
						$code=crypt(rand(1,1000),'st');
						$req = "INSERT INTO user(Utilisateur, Mdp, Nom, Prenom, Date, Sexe, Email,Code) VALUES('$utilisateur', '$mdp', '$nom', '$prenom', '$date', '$sexe', '$email','$code')";
						$resultat=mysqli_query($connexion,$req);						
						if($resultat){
							$req="SELECT Id FROM user WHERE Utilisateur='$utilisateur'";
							$resultat=mysqli_query($connexion,$req);
							$donnees=mysqli_fetch_assoc($resultat);
							$id=$donnees['Id'];
							barvide("i"); ?>
							<p>Inscription réussie!</p>
							<p>Vous allez reçevoir un mail de confirmation.</p>
							<?php
							//sendmail();
							//email($id,$code,$email);
							//
						}else{
							echo"Erreur lors de l'inscription";
						}
						
					}
				}
				mysqli_close($connexion);
			}
		}else{
			header("Location:inscription.php");
		}
	}
	function email($id,$code,$email){
		$lien="http://localhost/IO2/nomdusite/verification.php?id=".$id."&code=".$code;
		$message="Bonjour, vous vous êtes inscrit à nomdusite.\nPour pouvoir vous connecté, veuillez cliquer ce lien: ".$lien;
		$headers = "From: webmaster@example.com";
		mail($email,"nomdusite",$message,$headers);
	}
	function login($message){?>	
		<div class="login">		
		<form method="post" action="login.php">
			<img src="images/autre/Avatar.png" alt="Avatar"><br>
			Nom d'utilisateur :<input type="text" name="utilisateur" <?php if($message=="mauvais"){echo"value=\"$_POST[utilisateur]\"";} ?> placeholder=<?php if($message=="existe"){echo "\"Ce nom d'utilisateur n'existe pas...\"";}else{ echo "\"Nom d'utilisateur...\"";} ?> required>
			Mot de passe :<input type="password" name="mdp" placeholder=<?php if($message=="mauvais"){echo "\"Mauvais mot de passe...\"";}else{echo "\"Mot de passe...\"";} ?> required>
			<input type="checkbox" name="souvenir" value="OK"><label> se souvenir de moi</label><br>
			<input type="submit" value="Envoyer">
		</form>	
		<?php descriInscritLogin(); ?>
		</div>
	<?php
	}
	function verification(){
		$connexion=connexion();
		$utilisateur= mysqli_real_escape_string($connexion,$_POST['utilisateur']);
		$mdp= mysqli_real_escape_string($connexion,$_POST['mdp']);
		$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);		
		if($donnees){
			if(password_verify(htmlspecialchars($_POST['mdp']), $donnees['Mdp'])){
				if($donnees['Confirme']=='F'){  //modifier T en F pour eviter sendmail
					$_SESSION['utilisateur']=htmlspecialchars($_POST['utilisateur']);
					bar("a"); ?>
					<p>Vous êtes connectés!
					<br><br><a href ="index.php">Retour vers l'accueil</a></p>
					<?php
					if(!empty($_POST['souvenir']) && $_POST['souvenir']=="OK"){
						//2 jours
						setcookie("utilisateur",$_SESSION['utilisateur'],time()+172800);
					}
				}else{
					barvide("login"); ?>
					Vous n'avez pas validé votre e-mail.
					Voulez vous le renvoyer?
					<form method="post" action="index.php?page=email">
					  <input type="hidden" name="id" value="<?php echo$donnees['Id']; ?>">
					  <input type="hidden" name="code" value="<?php echo$donnees['Code']; ?>">
					  <input type="hidden" name="email" value="<?php echo$donnees['Email']; ?>">
					  <input type="submit" value="oui">
					</form>					
					<?php
				}
			}else{
				barvide("login");
				login("mauvais");
			}
		}else{
			barvide("login");
			login("existe");
		}
		mysqli_close($connexion);
	}
	function verificationMail(){
		$connexion=connexion();
		$id= mysqli_real_escape_string($connexion,$_GET['id']);
		$code= mysqli_real_escape_string($connexion,$_GET['code']);
		$req="SELECT * FROM user WHERE Code='$code' AND Id='$id'";
		$resultat=mysqli_query($connexion,$req);
		if($donnees=mysqli_fetch_assoc($resultat)){
			echo "Verification effectue, vous pouvez maintenant vous connecté!";
			$confirme="T";
			$req="UPDATE user SET Confirme='$confirme' WHERE Id='$id'";
			$resultat=mysqli_query($connexion,$req);
		}else{
			header("Location:index.php");
		}
	}
?>