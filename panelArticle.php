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
<div id="content">
	<div id="articlesRow">
	<h2>Articles disponibles :</h2>	
		<section>
		<?php                      
			if (empty($_GET['p']))
			$p = 1;
			else
			$p = (int) $_GET['p'];
			$nbDisplay = 12;	
			$reponse2 = $bdd->query('SELECT a.user_ID pseudo_ID FROM articles a INNER JOIN users u ON u.ID = a.user_ID WHERE pseudo = "'.$_SESSION["pseudo"].'" ');
			if($donnees2 = $reponse2->fetch()){
				?>
				<?php
				/* Requête pour compter les articles crée par un utilisateur */
				$reponse3 = $bdd->query('SELECT COUNT(id) FROM articles WHERE user_ID = "'.$donnees2['pseudo_ID'].'" ');
				$nbRows = $reponse3->fetch(PDO::FETCH_COLUMN);
				//On calcule pour savoir qd on commence à les récupérer
				$start = $p * $nbDisplay - $nbDisplay;
				//Le nombre de page qu'il y aura pour les article d'une catégorie, nombre récupérer en divisant le nombre de lignes par le nombre d'article par page
				$pagination = (int) ceil($nbRows / $nbDisplay);		
				while ($donnees2 = $reponse2->fetch()){
					$reponse = $bdd->query('SELECT * FROM articles WHERE user_ID = "'.$donnees2['pseudo_ID'].'"  limit '.$start.',  '.$nbDisplay.'  ');		
				}	
				/* Affiche les article de l'utilisateur connecter */
				while ($donnees = $reponse->fetch()){
					?>
					<article>
						<img id="imgArticle" src="<?php echo $donnees['content_media'] ?>">
						<h1><?php echo $donnees['title'] ?></h1>
						<div class="contentArticle"><p><?php echo substr($donnees['content'], 0, 175). "..."; ?></p></div>
						<p><?php echo $donnees2['pseudo_ID'] ?></p>
						<div id="bottomArt">
							<a href="articleShow.php?show=<?php echo $donnees['ID'] ?>">En savoir plus</a>
						</div>
					</article>
				<?php 			  
				}		
				$reponse->closeCursor();  
			}
			else{
				?>
				<h2>Vous n'avez pas encore créé d'articles</h2>	
				<?php
			}         
		?>
		</section>
		<?php include("include/pagination.php"); ?>			
	</div>				
</div>
<?php include("include/template2.php"); ?>