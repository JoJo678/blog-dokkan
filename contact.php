<?php include("include/template.php"); ?>	
<div id="content">
    <div id="panelContact">
        <h1>Contactez moi: </h1>
		<table id="tabletContact">   
			<!-- Formulaire pour contacter le créateur du blog  -->
			<form action="mailto:jordandivito@hotmail.com" method="post"  id ="formAdd" enctype="text/plain">			
				<tr>
					<td><input id="idUserObjet" class="inputLogs" type="text" name="Objet" value="Objet" onmouseover="onOverForm(this)" onmouseout="onOutForm(this)"></td>
				</tr>
				<tr>
					<td><textarea name="editor3" id="msgEnvoi" rows="10" cols="80">Commentaires ici ..</textarea></td>	
				</tr>
				<tr>
					<td><input id="envoiComs" class="envoi inputLogs" type="submit" value="Envoyer"></td>              
				</tr>
			</form>
		</table>         
		<script>
			// Replace the <textarea id="editor3"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace( 'editor3' );
		</script>
    </div>				
</div>
<?php include("include/template2.php"); ?>