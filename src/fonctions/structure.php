<link rel="stylesheet" href="styles/structure.css"> 
<?php
	function connexion(){
		$servername = "localhost";
		$username = "username";
		$password = "password";
		$database = "letztalk";
		$connexion = mysqli_connect($servername, $username, $password, $database);
		if (! $connexion) {
			header("Location:erreur.html"); 
		}
		return $connexion;
	}
	function head($active){?>
		<header>
			<a href="/IO2/nomdusite" class="logo">LetzTalk</a>
			<div class="droite">
				<a <?php if($active=="contact"){ echo " class=\"active\" ";}  ?> href="contact.php">Contact</a>
				<a <?php if($active=="about"){ echo " class=\"active\" ";}  ?>href="about.php">A propos</a>
			</div>
		</header>
		<?php
	}
	function bar($active){?>
		<div class="bar">
			<span class="bouttonmenu">Menu</span>
			<a class="exit" href="index.php?page=deconnexion"><img src="images/autre/exit.png"></a>
			<div class="menu">
			<a <?php if($active=="profil"){ echo " class=\"active\" ";}  ?> href="profil.php">Profil</a>
			<a <?php if($active=="amis"){ echo " class=\"active\" ";}  ?> href="amis.php">Amis</a>
			<a <?php if($active=="forum"){ echo " class=\"active\" ";}  ?> href="forum.php">Forum</a>
			<a <?php if($active=="recherche"){ echo " class=\"active\" ";}  ?> href="recherche.php">Recherche</a>
			<a <?php if($active=="messages"){ echo " class=\"active\" ";}  ?> href="messages.php">Messages</a>
			<span class="invisible">
			<a <?php if($active=="contact"){ echo " class=\"active\" ";}  ?> href="contact.php">Contact</a>
			<a <?php if($active=="about"){ echo " class=\"active\" ";}  ?>href="about.php">A propos</a>
			</span>
			</div>
			
		</div>
		<?php
	}
	function barvide($active){?>
		<div class="bar">
			<div class="menu">
			<a <?php if($active=="inscription"){ echo " class=\"active\" ";}  ?> href="inscription.php">Inscription</a>
			<a <?php if($active=="login"){ echo " class=\"active\" ";}  ?> href="login.php">Login</a>
			</div>
		</div>
		<?php
	}
	function bas(){?>
		<footer>Site de Lucie Danis et Jack Nyawa</footer>
	<?php
	}
	function deconnexion(){
		barvide("a");
		if(isset($_SESSION['utilisateur'])){
			session_unset($_SESSION['utilisateur']);
		}
		if(isset($_COOKIE['utilisateur'])){
			setcookie("utilisateur", "", time() - 3600);
			unset($_COOKIE['utilisateur']);
		}
		?>
		<p>Au revoir!</p>
		<a href ="index.php">Retour vers l'accueil</a>
	<?php
	}
	function utilisateur(){
		$connexion=connexion();
		if(!empty($_SESSION['utilisateur'])){
			$utilisateur= mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
			$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			if($donnees=mysqli_fetch_assoc($resultat)){
				return true;
			}
		}
		if(!empty($_COOKIE['utilisateur'])){			
			$utilisateur= mysqli_real_escape_string($connexion,$_COOKIE['utilisateur']);
			$req="SELECT * FROM user WHERE Utilisateur = '$utilisateur'";
			$resultat=mysqli_query($connexion,$req);
			if($donnees=mysqli_fetch_assoc($resultat)){
				$_SESSION['utilisateur']=$_COOKIE['utilisateur'];
				return true;
			}	
		}
		return false;
	}
?>