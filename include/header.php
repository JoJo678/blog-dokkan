<?php 
	session_start();
?>
<header>
	<!-- Logo du site -->	
	<img id="logo" src="images/logo.png" onmouseover="setInterval(this.src='images/logo4.png', 10000);" onmouseout="setInterval(this.src='images/logo.png', 10000);">
	</div>
	<nav>
		<!-- Menu du site -->
		<ul id="mainMenu">
			<li><a href="index.php">Accueil</a></li>
			<li><a href="articles.php">Articles</a></li>
			<li><a href="propos.php">A propos</a></li>
			<li><a href="contact.php">Contact</a></li>	
		</ul>
	</nav>	
	<nav id="user">
		<ul>
			<?php
				//Affichage du menu inscription-connexion pour un simple visiteur sinon affichage du panel utilisateur 
				if(empty($_SESSION['pseudo'])){
			?>
					<!-- Menu inscription-connexion -->
					<li><a href="index.php?choix=inscription" onclick="test();">Inscription</a></li>
					<li><a href="index.php?choix=connexion" onclick="test();">Connexion</a></li>	
			<?php
				}
				else{
			?>	
					<!-- Panel utilisateur -->
					<div class="dropdown">
						<li class="dropbtn"><a  href="#">Panel utilisateur</a></li>						
						<div class="dropdown-content">
							<a href="panelModification.php">Modifier profil</a>
							<a href="panelArticle.php">Mes articles</a>
							<a href="articleNew.php">Créer un article</a>
						</div>
					</div>	
					<div class="dropdown">
						<li><a href="logout.php">Déconnexion</a></li>					
					</div>				
			<?php
				}
			?>
		</ul>
	</nav>
</header>

