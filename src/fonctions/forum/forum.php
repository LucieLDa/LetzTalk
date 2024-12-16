<?php
	function afficherDiscussion(){
		formulaireForum();
		if(!empty($_POST['message'])){
			$connexion=connexion();
			$discussion= mysqli_real_escape_string($connexion,$_GET['discussion']);
			$message= mysqli_real_escape_string($connexion,$_POST['message']);
			$utilisateur=mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
			$req = "INSERT INTO forum(Message,Discussion,User) SELECT '$message','$discussion',Id FROM user WHERE Utilisateur='$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
		}
		afficheMessages();
	}
	function formulaireForum(){ ?>
		<div class="nouveau">
		<form action=<?php echo "\"forum.php?discussion=".$_GET['discussion']."\""; ?> method="post">
		<textarea name="message" placeholder="Ecrivez quelque chose..."></textarea>
		<input type="submit" value="ok">
		</form>
		</div>
	<?php
	}
	function afficheMessages(){
		$connexion=connexion();
		$discussion= mysqli_real_escape_string($connexion,$_GET['discussion']);
		$req="SELECT Message,Utilisateur FROM forum,user WHERE Discussion='$discussion' AND user.Id=User ORDER BY forum.Date";
		$resultat=mysqli_query($connexion,$req);
		if (!$resultat){
			echo "problèmes de connexion pour affiche";exit;
		}
		while($ligne=mysqli_fetch_assoc($resultat)){
			echo"<div class=\"message\">";
			echo "<a href=profil.php?user=".$ligne["Utilisateur"].">".$ligne["Utilisateur"].": </a> ".$ligne["Message"]."<br>";
			echo"</div>";
		}
	}

?>