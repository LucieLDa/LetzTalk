<?php
	//Fonction principale d'affichage
	function discussion(){
		echo"<div class=\"recherche\">";
		rechercheDiscussion();
		echo"</div>";
		if(!empty($_GET['recherche'])){
			echo "<h2>Résultat</h2><div class=\"lesDiscussions\">";
			rechercheResultat($_GET['recherche']);
			echo "</div>";
		}
		
		echo"<hr><div class=\"creer\">";
		if(!empty($_POST['discussion']) && !empty($_POST['message'])){
			if(exist($_POST['discussion'])){
				echo "<p>Cete discussion existe déjà</p>";
				creerDiscussion();
			}else{
				$connexion=connexion();
				$discussion= mysqli_real_escape_string($connexion,$_POST['discussion']);
				$message= mysqli_real_escape_string($connexion,$_POST['message']);
				$utilisateur=mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
				$req = "INSERT INTO forum(Message,Discussion,User) SELECT '$message','$discussion',Id FROM user WHERE Utilisateur='$utilisateur'";
				$resultat=mysqli_query($connexion,$req);
				echo "Discussion crée!";
				echo "<a href=\"forum.php?discussion=".$_POST['discussion']."\">Accés à votre discussion</a><br>";
			}
		}else{
			creerDiscussion();
		}
		echo"</div><hr>";
		listeDiscussion();
	}
	function creerDiscussion(){ ?>
		<h2>Nouvelle discussion</h2>
		<form action="forum.php" method="post">
		<input type="text" name="discussion" placeholder="Titre de la discussion..."><br>
		<textarea name="message" placeholder="Premier message..." required></textarea>
		<input type="submit" value="Ok">
		</form>
	<?php	
	}
	function listeDiscussion(){
		$connexion=connexion();
		$req="SELECT COUNT(DISTINCT User),COUNT(Message),Discussion FROM forum GROUP BY Discussion ORDER BY COUNT(Message) DESC";
		$resultat=mysqli_query($connexion,$req);
		echo "<h2>Listes de discussion</h2><div class=\"lesDiscussions\">";
		while($donnees=mysqli_fetch_assoc($resultat)){
			echo "<span class=\"uneDiscussion\">";
			echo "<a href=\"forum.php?discussion=".$donnees["Discussion"]."\">".$donnees["Discussion"]."</a> ";
			echo "<span>".$donnees["COUNT(Message)"]." messages ".$donnees["COUNT(DISTINCT User)"]." Utilisateurs</span>";
			echo "</span>";
		}
		echo "</div>";
	}
	function rechercheDiscussion(){ ?>
		<h2>Recherche</h2>
		<form action="forum.php" method="get">
		<input type ="text" name = "recherche" placeholder="Entrez votre recherche ici..." required>
		<input type="submit" value="rechercher"><br>
		</form>
	<?php
	}
	function rechercheResultat($element){
		$connexion= connexion();
		$element=mysqli_real_escape_string($connexion,$element);
		$tab=explode(" ", $element);
		$t=array();
		for($i=0;$i<count($tab);$i++){
			$req="select count(distinct User),count(Message),Discussion from forum where Discussion like '%".$tab[$i]."%' group by Discussion order by Discussion;";
			//echo $req;	
			$resultat = mysqli_query($connexion,$req);
			if(!$resultat){
				echo "problèmes de connexion";
			}else{
				$num=mysqli_num_rows($resultat);
				while($ligne = mysqli_fetch_assoc($resultat)){
					$t[]= "<span class=\"uneDiscussion\"><a href=\"forum.php?discussion=".$ligne["Discussion"]."\">".$ligne["Discussion"]."</a><span>".$ligne["count(Message)"]." messages ".$ligne["count(distinct User)"]." Utilisateurs</span></span>";
				}
			}
		}
		$a=array_unique($t);
		if (count($a)==0){
			echo "Aucun élément ne correspond à votre recherche";
		}		
		foreach($a as $cle=>$val){
			if (isset($val)){
				echo $val;
			}
		}
	}
	function exist($discussion){
		$connexion=connexion();
		$discussion= mysqli_real_escape_string($connexion,$discussion);
		$req="SELECT * FROM forum WHERE Discussion='$discussion'";
		$resultat=mysqli_query($connexion,$req);
		$donnees=mysqli_fetch_assoc($resultat);
		if($donnees){
			return true;
		}else{
			return false;
		}
	}
?>