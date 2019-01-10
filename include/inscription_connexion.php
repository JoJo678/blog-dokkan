<?php
	if(isset($_GET["choix"])){
?>
	<div id="testou" onclick="test()">
		<?php 
		include("erreur.php");
		//Récupération du get choix pour savoir si le visiteur veut s'inscrire ou se connecter
		if ($_GET["choix"] === "inscription"){
		?>
		<!-- Formulaire d'inscription d'un nouvel utilisateur -->
		<table id="tablet" class="formulaire">
			<!-- Redirection vers l'action userAdd.php -->
			<form method="post" action="action/userAdd.php" id ="formAdd" enctype="multipart/form-data">
				<tr>	
					<td><input id="idUserPseudo" class="inputLogs" type="text" name="Pseudo" value="Pseudo" onmouseover="onOverForm(this)" onmouseout="onOutForm(this)"></td>
					<td><input id="idUserEmail" class="inputLogs" type="text" name="Email" value="Email" onmouseover="onOverForm(this)" onmouseout="onOutForm(this)"></td>
				</tr>
				<tr>
					<td><input id="idUserFirstname" class="inputLogs" type="text" name="Prénom" value="Prénom" onmouseover="onOverForm(this)" onmouseout="onOutForm(this)"></td>
					<td><input id="idUserName" class="inputLogs" type="text" name="Nom" value="Nom" onmouseover="onOverForm(this)" onmouseout="onOutForm(this)"></td>
				</tr>
				<tr>	
					<td><input id="idUserPassword" class="inputLogs" type="text" name="pass" value="Mot de Passe" onmouseover="onOverFormPass(this)" onmouseout="onOutFormPass(this)"></td>
					<td><input id="idUserPassword" class="inputLogs" type="text" name="pass2" value="Confirmation mdp" onmouseover="onOverFormPassConf(this)" onmouseout="onOutFormPassConf(this)"></td>	
				</tr>
				<tr>	
				<td><input id="idUserBirth" class="inputLogs" type="text" name="birth" value="Date de naissance" onmouseover=" onOverFormDate(this)"></td>		
					<td colspan="2"><label for="idImgProfil" id="labelUpload" class="labelLogs">Image :</label><input id="upload" class="inputLogs" type="file" name="fichier2"></td>					
				</tr>
				<tr>
					<td colspan="2"><label for="idUserNews"id="newslabel" class="labelLogs">Newsletters</label><input id="idUserNews" class="inputLogs" type="checkbox" name="Newsletters" ></td>
				</tr>
				<tr>	
					<td colspan="2" ><input class="envoi inputLogs" type="submit" value="Inscription" ></td>              
				</tr>
			</form>
		</table>
		<?php 
		}
		else{
			if ($_GET["choix"] === "connexion"){
			?>	
			<!-- Formulaire de connexion pour un utilisateur -->
			<table id="tablet2" class="formulaire">
				<!-- Redirection vers l'action userLog.php -->
				<form method="post" action="action/userLog.php" id ="formAdd">
					<tr>				
						<td><input id="idUserPseudo" class="inputLogs" type="text" name="Pseudo" value="Pseudo" onmouseover="onOverForm(this)" onmouseout="onOutForm(this)"></td>
						<td><input id="idUserPassword" class="inputLogs" type="text" name="pass" value="Mot de Passe" onmouseover="onOverFormPass(this)" onmouseout="onOutFormPass(this)"></td>
					</tr>
					<tr>
						<td colspan="2" ><input class="envoi inputLogs" type="submit" value="Connexion"></td>              
					</tr>
				</form>
			</table>
			<?php 
			}
		}
		?>	
	</div>
<?php
	}
?>