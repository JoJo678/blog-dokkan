<?php 
	include("include/template.php"); 
?>
<div id="content">
	<!-- Affichage d'un article unique -->
	<div id="articlesShow">
		<section>
		<?php
			// Requête pour obtenir tous les articles selon l'id du show récupérer avec le GET
			$reponse = $bdd->query('SELECT * FROM articles WHERE ID = "'.$_GET['show'].'" ');
			// Affichage des données de l'article
			if($donnees = $reponse->fetch()){
				?>
				<article>	
					<?php
						// Requête pour récupérer le pseudo de l'auteur
						$reponse2 = $bdd->query('SELECT u.pseudo pseudo_auteur FROM users u INNER JOIN articles a ON a.user_ID = u.ID WHERE a.ID = "'.$_GET['show'].'" ');
						if($donnees2 = $reponse2->fetch())
						{
						?>			
							<img id="imgArticleShow" class="showContent" src="<?php echo $donnees['content_media'] ?>">
							<?php
							if (isset($_SESSION['pseudo'])){
								?>
								<div>
									<!-- Lien qui permet d'afficher l'éditeur d'article -->
									<a id="btnArtModif" href="#" onclick="showModif()">Modifier un article</a>
								</div>
								<!-- Formulaire de modification d'article -->
								<form method="post" action="action/artModif.php?show=<?php echo $donnees['ID'] ?>" id ="formArtModif" enctype="multipart/form-data">  	
									<img id="imgArticleShow" src="<?php echo $donnees['content_media'] ?>">
									<input id="uploadsModifArt"  class="inputLogs" type="file" name="fichier2">
									<input type="text" id="titleModif" name="title" value="<?php echo $donnees['title'] ?>">
									<textarea name="editor1" id="modifp" rows="10" cols="80">
										<?php echo $donnees['content'] ?>
									</textarea>
									<input type="submit" class="artModifSend"  value="Enregistrer">           
								</form>			
								<script>
									// Replace the <textarea id="editor1"> with a CKEditor
									// instance, using default configuration.
									CKEDITOR.replace( 'editor1' );
								</script>
								<?php
							}
							?>					
								<h1 class="showContent"><?php echo $donnees['title'] ?></h1>
								<p class="showContent"> Par <?php echo $donnees2['pseudo_auteur']; ?></p>
								<div class="showContent"><?php echo $donnees['content'] ?></div>					
						<?php
						}
					?>
					<!-- Lien retour vers les articles -->
					<a id="back" class="showContent" href="articles.php">Retour</a>
					<?php
			}
			$reponse->closeCursor(); 
			?>
					<!-- Espace commentaire de l'article -->
					<div id="espaceCommentaire">
						<h2> Commentaires </h2>
						<?php
						// Requête des commentaires où l'id de l'article correspond à l'article en cours
						$reponse3 = $bdd->query('SELECT * FROM commentary  WHERE article_id = "'.$_GET['show'].'" ORDER BY date_create');	
						// Jointure pour avoir le pseudo de celui qui a écrit le commentaire
						$reponse4 = $bdd->query('SELECT u.pseudo pseudo_commentary FROM users u INNER JOIN commentary c ON u.ID = c.user_id  WHERE article_id = "'.$_GET['show'].'" ORDER BY date_create');
						while ($donnees3 = $reponse3->fetch()){
								// Si on trouve l'auteur du commentaire
								if($donnees4 = $reponse4->fetch())
								{
									// Requête pour obtenir l'image de profil qui correspond au pseudo de celui qui a écrit le commentaire
									$reponse5 = $bdd->query('SELECT picture_profil FROM users WHERE pseudo = "'.$donnees4['pseudo_commentary'].'" ');
									if($donnees5 = $reponse5->fetch())
									{
								?>
									<!-- On affiche le pseudo de l'auteur du commentaire -->
									<p id="debCom"><strong id="pseudoCom"><?php echo $donnees4['pseudo_commentary']; ?></strong> - le <?php echo $donnees3['date_create'] ?></p>		
									<!-- On affiche l'image de profil de l'auteur -->
									<img id="imgProfilCom" src="<?php echo $donnees5['picture_profil'] ?>"/>
									<!-- On affiche le commentaire de l'auteur -->
									<p id="com"><?php echo $donnees3['content'] ?></p>	
									<p id="finCom"></p>
								<?php
									}
								}
						}
						?>
						<?php
							// Si aucune session
							if(empty($_SESSION['pseudo'])){
							?>
								<p>Veuillez vous <a class="postCom" href="index.php?choix=connexion" onclick="test();">connecter</a> pour laisser un commentaire, vous ne posséder pas de compte ? <a class="postCom" href="index.php?choix=inscription" onclick="test();">Inscription</a></p>							
							<?php
							}
							else{// Si il y a une session
						?>		
								<!-- Formulaire pour poster commentaire -->
								<table>    
									<form method="post" action="action/commentaryAdd.php?show=<?php echo $_GET['show'] ?>" id ="formAdd"  enctype="multipart/form-data">
										<tr>
											<td><textarea id="zoneComs" type="text" name="content" value="Commentaires ici .."> </textarea></td>
										</tr>	
										<tr>
											<td><input id="envoiComs" class="envoi inputLogs" type="submit" value="Envoyer"></td>              
										</tr>
									</form>
								</table>
							<?php
							}
							?>
					</div>
				</article>
		</section>
	</div>				
</div>
<?php include("include/template2.php"); ?>

