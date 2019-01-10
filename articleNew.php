<?php include("include/template.php"); ?>
<div id="content">
    <?php include("include/erreur.php");?>
    <!-- Formulaire d'ajout d'un nouvel article -->
    <table id="tableArt">    
        <!-- Redirection vers l'action articleAdd.php -->
        <form method="post" action="action/articleAdd.php" id ="formAdd"  enctype="multipart/form-data">
            <tr>
                <td><label for="idArticleName">Nom de l'article :</label></td>
                <td><input id="idArticleName" type="text" name="title" ></td>
            </tr>
            <tr>
                <td><label for="idCat">Catégorie :</label></td>
                <td>
                    <select id="idCat" name="category">
                        <option value="0" selected="selected">Choix d'une catégorie</option>
                        <?php
                            //Requête pour récupérer toutes les catégories
                            $reponse = $bdd->query("SELECT * FROM category");
                            //Affichage des catégories
                            while ($donnees = $reponse->fetch())
                            {
                            ?>
                                <option value="<?php echo $donnees['name']; ?>"><?php echo $donnees['name']; ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <?php                                    
                        $reponse->closeCursor();
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="idContent">Description :</label></td>    
                <td><textarea name="editor2" id="idContent" rows="10" cols="80"></textarea></td>
            </tr>
            <tr>
                <td><input type="file" value="Parcourir" name="fichier"></td>
            </tr>
            <tr>
                <td colspan=2 ><input id="submitArt" type="submit" value="Envoyer"></td>             
            </tr>
            <tr>
                <td></td>            
            </tr>
        </form>
    </table>
    <script>
        // Replace the <textarea id="editor2"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'editor2' );
    </script>
</div>
<?php include("include/template2.php"); ?>