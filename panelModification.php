<?php include("include/template.php"); ?>	
<div id="content">
    <div id="panelModif">
        <h2>Modifications des données :</h2>
        <?php
            include("include/erreur.php");
            $reponse = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$_SESSION["pseudo"].'"');
            if ($donnees = $reponse->fetch()){
            ?>
            <table id="tabletModif">    
            <!-- Formulaire de modification d'un utilisateur -->
            <form method="post" action="action/userModif.php" id ="formAdd" enctype="multipart/form-data">  
                <tr>
                    <td><label for="idUserPseudo" class="labelLogsModif">Pseudo :</label><input id="idUserPseudo" class="inputLogs" type="text" name="pseudo" value="<?php echo $donnees['pseudo'] ?>" ></td>
                    <td><label for="idUserEmail" class="labelLogsModif">Email :</label><input id="idUserEmail" class="inputLogs" type="text" name="email" value="<?php echo $donnees['email'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="idUserName" class="labelLogsModif">Nom :</label><input id="idUserName" class="inputLogs" type="text" name="username" value="<?php echo $donnees['username'] ?>"></td>
                    <td><label for="idUserFirstname" class="labelLogsModif">Prénom :</label><input id="idUserFirstname" class="inputLogs" type="text" name="firstname" value="<?php echo $donnees['firstname'] ?>"></td>
                </tr>       
                <tr>
                    <td><label for="idUserPassword" class="labelLogsModif">Mot de passe :</label><input id="idUserPassword" class="inputLogs" type="password" name="pass" value="<?php echo $donnees['pass'] ?>"></td>
                    <td><label for="idUserPassword" class="labelLogsModif">Confirmation Mot de passe :</label><input id="idUserPassword" class="inputLogs" type="password" name="pass2" value="<?php echo $donnees['pass'] ?>"></td>
                </tr> 
                <tr>
                <!-- SELECT .. DATE_FORMAT -->
                    <td id="newsTd"><label for="idUserNews" id="newstest" class="labelLogsModif">Newsletters :</label><input type="checkbox" id="newsBox" class="inputLogs" name="newsletters" <?php echo $donnees['newsletters'] ?>></td>
                    <td><label for="idUserBirth" class="labelLogsModif">Date de naissance :</label><input id="idUserBirth" class="inputLogs" type="date" name="birth" value="<?php echo $donnees['date_of_birth'] ?>"></td>
                </tr>       
                <tr>
                    <td rowspan=2><label for="idImgProfil" class="labelLogsModif">Image de profil Actuelle :</label><img src="<?php echo $donnees['picture_profil'] ;?>" id="imgProfilMain" /></td>
                    <td><label for="idImgProfil" class="labelLogsModif">Ancienne image de profil : </label>
                        <select id="idImgProfil2" name="profilImage" >
                            <option class="testou" selected value="0">Aucune image sélectionné</option>                                     
                        </select>
                    <?php
                        $dir_nom = 'images/'.$donnees['pseudo']; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
                        $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                        $fichier= array(); // on déclare le tableau contenant le nom des fichiers
                        $dossier= array(); // on déclare le tableau contenant le nom des dossiers                                  
                        while($element = readdir($dir)) {
                            if($element != '.' && $element != '..') {
                                if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}
                                else {$dossier[] = $element;}
                            }
                        }                                   
                        closedir($dir);                                    
                        if(!empty($fichier)){
                            sort($fichier);// pour le tri croissant, rsort() pour le tri décroissant                                        
                            foreach($fichier as $lien) {
                                $dossier ="$dir_nom/$lien";
                                if ($dossier != $donnees['picture_profil'] ){
                                ?>                                               
                                    <img src="<?php echo $dossier ;?>" class="imagesProfil" name="test" onclick="selectImg('<?php echo $dossier ;?>')"/>
                                    <script>
                                        //Fonction qui change le background-image pour voir quel image l'utilisateur à choisi dans celle qu'il a déjà mis sur le site
                                        function selectImg(lien){                                                       
                                            $("#idImgProfil2").css("background", "url("+lien+")");
                                            $("#idImgProfil2").css("background-size", "200px, 100px");
                                            $("#idImgProfil2").css("background-repeat", "no-repeat");
                                            var css = $("#idImgProfil2").css("background-image");
                                            var img = css.replace(/(?:^url\(["']?|["']?\)$)/g, "");
                                            var res = img.substring(26);
                                            var present = 0;
                                            //Change l'attribut selected des éléments
                                            $(".testou").each(function() {                     
                                                if(($(this).val()) == res){
                                                    present = 1;
                                                    $(this).attr('selected', true);
                                                }
                                                else{
                                                    $(this).attr('selected', false);
                                                }
                                            });
                                            if(present != 1){                                 
                                                $("#idImgProfil2").append("<option class='testou' value='t' selected ></option>");
                                                $("#idImgProfil2").children().last().val(res);
                                            }
                                        }
                                    </script>                                
                                <?php
                                }    
                            }   
                        }
                    ?>               
                    </td>                 
                </tr>
                <tr>             
                    <td><label for="idImgProfil" class="labelLogsModif">Ajouter une nouvelle photo :</label><input id="uploadss"  class="inputLogs" type="file" name="fichier2"></td>     
                </tr>
                <tr>
                    <td colspan="2" ><input type="submit" id="sendModif" class="envoi inputLogs" value="Enregistrer"></td>              
                </tr>
            </form>
            </table>         
            <?php             
            }
            $reponse->closeCursor();           
        ?>   
    </div>				
</div>
<?php include("include/template2.php"); ?>