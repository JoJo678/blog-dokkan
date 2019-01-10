<?php include("include/template.php"); ?>
<script>
	$( document ).ready(function() {
		var biggestHeight = 0;
		var p = $( "article:last" );
		var position = p.position();
		// If this elements height is bigger than the biggestHeight
		if ($("article:last").height() > biggestHeight ) {
			// Set the biggestHeight to this Height
			biggestHeight = position.top + 220;
		}
		// Set the container height
		$("#container").height(biggestHeight);
	});	
</script>
<div id="intro">
	<?php
		$utilisateur = "visiteur";
		// On vérifie si une session existe
		if (isset($_SESSION['pseudo'])){
			// On récupère son pseudo 
			$utilisateur = $_SESSION['pseudo'];
		}
	?>
	<h1>Bienvenue <?php echo $utilisateur;?> sur le blog consacré à dokkan battle</h1>
	<p>Dokkan battle est un jeu dans l'univers de Dragon Ball, il est disponible sur smartphone et tablette</p>
	<p>Ce blog contient des informations sur les différents évenements présents dans le jeu ainsi que divers tutoriels afin de bien réussir son compte.</p>
</div>	
<div id="content">
	<!-- Slideshow sur les événements en cours  -->
	<div id="eventOn">	
		<div id="slide" class="slideshow-container">
		<?php
			//Recherche des articles contenus dans la catégorie event pour les afficher dans le slideshow
			$reponse = $bdd->query("SELECT * FROM articles WHERE category = 'actualite'");
			while ($donnees = $reponse->fetch()){
				?>
				<div class="mySlides fade">
				<a href="articleShow.php?show=<?php echo $donnees['ID'] ?>">
					<img id="imgSlide" src="<?php echo $donnees['content_media'] ?>">
					<h1 class="topSlide">L'actu Dokkan</h1>
					<p class="bottomSlide"><?php echo $donnees['title'] ?></p>
				</a>
				</div>
			<?php
			}
			$reponse->closeCursor();           
		?>
		</div>
	</div>
	<!-- Sidebar qui contient diverse informations -->
	<div id="sidebarRight">	
		<h1>Les tuto articles: </h1>
		<div id="slide2" class="slideshow-container">
			<?php
				//Recherche des articles contenus dans la catégorie tuto pour les afficher dans le slideshow
				$reponse = $bdd->query("SELECT * FROM articles WHERE category = 'tutoriel'");
				while ($donnees = $reponse->fetch()){
					?>
					<div class="mySlides2 fade">
					<a href="articleShow.php?show=<?php echo $donnees['ID'] ?>">
						<img id="imgSlide2" src="<?php echo $donnees['content_media'] ?>">
						<p class="bottomSlide2"><?php echo $donnees['title'] ?></p>
					</a>
					</div>	
				<?php
				}
				$reponse->closeCursor();           
			?>
		</div>
		<h1>Dernier commentaire: </h1>
		<?php
			// Requête des commentaires où l'id de l'article correspond à l'article en cours
			$reponse3 = $bdd->query('SELECT * FROM commentary ORDER BY date_create DESC LIMIT 1');	
			// Jointure pour avoir le pseudo de celui qui a écrit le commentaire
			$reponse4 = $bdd->query('SELECT u.pseudo pseudo_commentary FROM users u INNER JOIN commentary c ON u.ID = c.user_id ORDER BY date_create DESC LIMIT 1');
			// Jointure pour avoir le titre de l'articlee
			$reponse5 = $bdd->query('SELECT a.title article_title FROM articles a INNER JOIN commentary c ON a.ID = c.article_id');
			if($donnees3 = $reponse3->fetch()){
				// Si on trouve l'auteur du commentaire
				if($donnees4 = $reponse4->fetch())
				{
					if($donnees5 = $reponse5->fetch()){
						$reponse6 = $bdd->query('SELECT * FROM articles WHERE title = "'.$donnees5['article_title'].'"');	
						if($donnees6 = $reponse6->fetch()){
						?>
							<!-- On affiche le pseudo de l'auteur du commentaire -->
							<p> Par <?php echo $donnees4['pseudo_commentary']; ?></p>		
							<!-- On affiche le commentaire de l'auteur -->
							<p><?php echo '"'. substr($donnees3['content'], 0, 40). '... "'; ?> </p>	
							<!-- On affiche le titre de l'article -->
							<a href="articleShow.php?show=<?php echo $donnees6['ID'] ?>" id="com"> <img id="imgSidebar" title="<?php echo $donnees5['article_title'] ?>" src="<?php echo $donnees6['content_media'] ?>"></a>	
						<?php
						}
					}
				}
			}
		?>				
		<h1>Dernier membre inscrit : </h1>
		<?php 
			//On recherche le dernier utilisateur inscrit
			$reponse = $bdd->query("SELECT pseudo FROM users ORDER BY ID DESC
			LIMIT 1 ");
			$donnees = $reponse->fetch();
		?>
		<!-- On affiche le dernier utilisateur inscrit -->
		<p><?php echo $donnees['pseudo']; ?></p>
	</div>
	<!-- Affichage des 3 derniers articles créer -->
	<div id="articlesRow">
		<h2>Les derniers articles</h2>
		<section>
		<?php
			$reponse = $bdd->query('SELECT * FROM articles  ORDER BY date_create DESC limit 3');
			//Requête pour récupérer le pseudo d'un article
			$reponse2 = $bdd->query('SELECT u.pseudo pseudo_auteur FROM users u INNER JOIN articles  a ON a.user_ID = u.ID ORDER BY date_create DESC limit  3' );
			//On affiche les articles qui répondent à la requête 
			while ($donnees = $reponse->fetch()){
				?>
				<article>
					<img id="imgArticle" src="<?php echo $donnees['content_media'] ?>">
					<h1><?php echo $donnees['title'] ?></h1>
					<div class="contentArticle"><p><?php echo substr($donnees['content'], 0, 175). "..."; ?></p></div>
					<div id="bottomArt">
						<a href="articleShow.php?show=<?php echo $donnees['ID'] ?>">En savoir plus</a>
						<?php
						// Si on trouve l'auteur de l'article on l'affiche
						if($donnees2 = $reponse2->fetch())
						{
						?>
							<p id="author"> Par <?php echo $donnees2['pseudo_auteur']; ?></p>
						<?php
							}
						?>
					</div>
				</article>
			<?php    
			}
			$reponse->closeCursor();           
		?>
		</section>
	</div>				
</div>
<?php include("include/template2.php"); ?>