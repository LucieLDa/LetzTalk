<?php
//Barre de recherche
function formulaireRecherche(){ ?>
	<div class="recherche">
    <form action="recherche.php" method="get">
    <h2>Recherche :</h2> 
	<input type ="text" name = "recherche" placeholder="Entrez votre recherche ici..." required>
    <input type="submit" value = "rechercher">
	</form>
	</div>
	<?php
}
//Fonction qui cherche dans la base de donnée des utilisateur 
//correspondant à élément
function recherche($element){
	$connexion= connexion();
	$element=mysqli_real_escape_string($connexion,$element);
	$tab=explode(" ", $element);
	$t=array();
	for($i=0;$i<count($tab);$i++){
		$req="select * from user where Utilisateur like '%".$tab[$i]."%' or Nom like '%".$tab[$i]."%' or Prenom like '%".$tab[$i]."%';";
		//echo $req;	
		$resultat = mysqli_query($connexion,$req);
		if(!$resultat){
			echo "problèmes de connexion";
		}else{
			$num=mysqli_num_rows($resultat);
			while($ligne = mysqli_fetch_assoc($resultat)){
				$t[]= " <a href=\"profil.php?user=".$ligne["Utilisateur"]."\">Profil</a>"."\n"."<a href=\"messages.php?user=".$ligne["Utilisateur"]."\">Envoyer un message</a>"."<br>Nom: ".$ligne["Nom"]. "\n"."Prenom: ".$ligne["Prenom"] ."\n"."Pseudo: ".$ligne["Utilisateur"];
			}
		}
	}
	$a=array_unique($t);
	if (count($a)==0){
		echo "Aucun élément ne correspond à votre recherche";
	}
	echo"<div class=\"resultat\">";
	foreach($a as $cle=>$val){
		if (isset($val)){
			echo"<div>";
			echo $val;
			echo"</div>";
		}
	}
	echo"</div>";
}
?>