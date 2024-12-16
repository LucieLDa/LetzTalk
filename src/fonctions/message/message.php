<?php
function formulaireMessage(){ ?>
	<form action="messages.php?user=<?php echo $_GET['user'];?>" method="post">
    <input autocomplete="off" type="text" name="message" placeholder="écrivez votre message...">
	<input type="submit" value="envoyer">
	</form>
	<?php
}

function sendToAndShow($expediteur,$recepteur){
    $connexion=connexion();
    $message=mysqli_real_escape_string($connexion,$_POST["message"]);
	$expediteur=mysqli_real_escape_string($connexion,$expediteur);
	$req="SELECT Id FROM user WHERE Utilisateur='$expediteur'";
	$resultat=mysqli_query($connexion,$req);
	$donnees=mysqli_fetch_assoc($resultat);
	$expediteur_id=$donnees["Id"];
	$recepteur=mysqli_real_escape_string($connexion,$recepteur);
	$req="SELECT Id FROM user WHERE Utilisateur='$recepteur'";
	$resultat=mysqli_query($connexion,$req);
	$donnees=mysqli_fetch_assoc($resultat);
	$recepteur_id=$donnees["Id"];
    $req="INSERT INTO messages(Expediteur,Message,Recepteur) VALUES('$expediteur_id','$message','$recepteur_id')";
	$resultat=mysqli_query($connexion,$req);
	if(!$resultat){
		echo"problemes de connexion<br>";
	}else{	
		show($expediteur,$recepteur);
	}
}
function show($expediteur,$recepteur){
	$connexion=connexion();
	//echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"5\">";
	$expediteur=mysqli_real_escape_string($connexion,$expediteur);
	$req="SELECT Id,Image FROM user WHERE Utilisateur='$expediteur'";
	$resultat=mysqli_query($connexion,$req);
	$donnees=mysqli_fetch_assoc($resultat);
	$expediteur_id=$donnees["Id"];
	$user_image=$donnees["Image"];
	$recepteur=mysqli_real_escape_string($connexion,$recepteur);
	$req="SELECT Id,Image FROM user WHERE Utilisateur='$recepteur'";
	$resultat=mysqli_query($connexion,$req);
	$donnees=mysqli_fetch_assoc($resultat);
	$recepteur_id=$donnees["Id"];
	$ami_image=$donnees["Image"];
	$req1="SELECT * FROM messages WHERE (expediteur='".$expediteur_id."'and recepteur='".$recepteur_id."') or (expediteur='".$recepteur_id."'and recepteur='".$expediteur_id."')order by date;";
	$resultat1=mysqli_query($connexion,$req1);
	if(!$resultat1){
		echo "problèmes de connexion avec resultat1<br>";
	}else{
		echo"<div class=\"conversation\">";
		while($ligne1 = mysqli_fetch_assoc($resultat1)){
			if($ligne1["Expediteur"]==$expediteur_id){
				echo "<div class=\"moi\"><div class=\"droiteimg\"><img src=\"".$user_image."\"></div><div>" .$ligne1["Message"]."</div></div>";
			}else{
				echo "<div class=\"autre\"><div class=\"gaucheimg\"><img class=\"gaucheimg\" src=\"".$ami_image."\"></div><div> ".$ligne1["Message"]."</div></div>";
			}
		}
		echo"</div>";
	}
}
function contact(){ ?> 
	<h1>Liste de contact:</h1>
	<?php
	$connexion=connexion();
	$utilisateur=mysqli_real_escape_string($connexion,$_SESSION["utilisateur"]);
	$req="SELECT Id FROM user WHERE Utilisateur='$utilisateur'";
	$resultat=mysqli_query($connexion,$req);
	$donnees=mysqli_fetch_assoc($resultat);
	$id=$donnees['Id'];
	$req="SELECT * FROM messages WHERE expediteur='$id' OR recepteur='$id' ORDER BY Date";
	$resultat=mysqli_query($connexion,$req);
	$t=array();
	while($donnees=mysqli_fetch_assoc($resultat)){
		if($donnees['Recepteur']==$id||$donnees['Expediteur']==$id){
			if($donnees['Recepteur']==$id){
				$req="SELECT Utilisateur,Image FROM user WHERE Id='$donnees[Expediteur]'";
				$resultat2=mysqli_query($connexion,$req);
				$donnees2=mysqli_fetch_assoc($resultat2);
				$user= "<a href=\"profil.php?user=".$donnees2['Utilisateur']."\"> <img src=\"".$donnees2['Image']."\"></a> ".$donnees2['Utilisateur']." ";
				$lien="\"messages.php?user=".$donnees2['Utilisateur']."\""; 
				
			}else{
				$req="SELECT Utilisateur,Image FROM user WHERE Id='$donnees[Recepteur]'";
				$resultat2=mysqli_query($connexion,$req);
				$donnees2=mysqli_fetch_assoc($resultat2);
				$user= "<a href=\"profil.php?user=".$donnees2['Utilisateur']."\"> <img src=\"".$donnees2['Image']."\"></a> ".$donnees2['Utilisateur']." ";
				$lien="\"messages.php?user=".$donnees2['Utilisateur']."\""; 
				
			}
			$lien="<a href=$lien>Envoyer un message</a>";
			$t[]=$user."<br>".$lien;
		}
	}
	$a=array_unique($t);
	if (count($a)==0){
		echo "Aucun contact";
	}		
	foreach($a as $cle=>$val){
		if (isset($val)){
			echo "<div class=\"contact\">";
			echo $val;
			echo"</div>";
		}
	}	
}
?>