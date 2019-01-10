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
<!-- Menu qui permet de filtrer les articles selon des catégories -->
<div id="seek">
	<?php 
		//Si une session existe on affiche le lien de création d'un nouvel article
		if (isset($_SESSION['pseudo'])){
			?>
			<div>
				<a id="btnArt" href="articleNew.php">Créer un article</a>
			</div>
			<?php
		}
	?>
	<nav>
		<ul id="filtreMenu">	
			<li><a href="articles.php">Tous</a></li>
			<?php
				// On affiche toutes les catégories qui existe
				$reponse = $bdd->query("SELECT * FROM category");	
				while ($donnees = $reponse->fetch()){
					?>
					<li><a href="articles.php?filtre=<?php echo $donnees['name'] ?>"><?php echo $donnees['name'] ?></a></li>
				<?php    
				}
				$reponse->closeCursor();           
			?>
		</ul>
	</nav>
</div>

<div id="content">
	<div id="articlesRow">
		<h2>Articles disponibles :</h2>
		<section>
		<?php	
			//On initialise le get p si il n'existe pas pour pouvoir être sur la 1ére page
			if (empty($_GET['p']))
			$p = 1;
			else
			$p = (int) $_GET['p'];
			// On accepte 12 articles maximum
			$nbDisplay = 12;
			//Si on va sur un filtre
			if(isset($_GET["filtre"])){
				//On va compter le nombre d'articles présent dans la catégorie choisi
				$reponse = $bdd->query('SELECT COUNT(id) FROM articles WHERE category =  "'.$_GET["filtre"].'" ');
				$nbRows = $reponse->fetch(PDO::FETCH_COLUMN);
				//On calcule pour savoir qd on commence à les récupérer
				$start = $p * $nbDisplay - $nbDisplay;
				//Le nombre de page qu'il y aura pour les article d'une catégorie, nombre récupérer en divisant le nombre de lignes par le nombre d'article par page
				$pagination = (int) ceil($nbRows / $nbDisplay);
				//Requête pour récupérer tous les articles d'une catégorie classé par date de création avec une limite de 12 articles par page
				$reponse = $bdd->query('SELECT * FROM articles  WHERE category = "'.$_GET["filtre"].'" ORDER BY date_create DESC limit '.$start.',  '.$nbDisplay.' ');
				//Requête pour récupérer le pseudo d'un article
				$reponse2 = $bdd->query('SELECT u.pseudo pseudo_auteur FROM users u INNER JOIN articles  a ON a.user_ID = u.ID  WHERE category = "'.$_GET["filtre"].'" ORDER BY date_create DESC limit '.$start.',  '.$nbDisplay.'' );
			}
			else{
				//On va compter tous les articles 
				$reponse = $bdd->query('SELECT COUNT(id) FROM articles');
				$nbRows = $reponse->fetch(PDO::FETCH_COLUMN);
				//On calcule pour savoir qd on commence à les récupérer
				$start = $p * $nbDisplay - $nbDisplay;
				//Le nombre de page qu'il y aura pour les article d'une catégorie, nombre récupérer en divisant le nombre de lignes par le nombre d'article par page
				$pagination = (int) ceil($nbRows / $nbDisplay);
				//Requête pour récupérer tous les articles classé par date de création avec une limite de 12 articles par page
				$reponse = $bdd->query('SELECT * FROM articles  ORDER BY date_create DESC limit '.$start.',  '.$nbDisplay.'');
				//Requête pour récupérer le pseudo d'un article
				$reponse2 = $bdd->query('SELECT u.pseudo pseudo_auteur FROM users u INNER JOIN articles  a ON a.user_ID = u.ID ORDER BY date_create DESC limit '.$start.',  '.$nbDisplay.'' );
			}
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
	<?php include("include/pagination.php"); ?>		
</div>
<?php include("include/template2.php"); ?>