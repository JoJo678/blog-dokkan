<?php include("../include/template.php"); ?>
    <?php    
        // Si l'utilisateur connecté écris un commentaire
        if(!empty($_POST['content']) ){
            //Récupération du commentaire
            $content = $_POST['content']; 
            // Requête pour récupérer l'id de l'article où l'id correspond au GET show de l'article
            $reponse2 = $bdd->query('SELECT * FROM articles WHERE ID = "'.$_GET['show'].'"'); 
            if ($donnees2 = $reponse2->fetch()){
                // Récupération de l'id d'un article
                $id_article = $donnees2['ID'];
            }
            // Requête pour récupérer l'id de l'utilisateur où le pseudo correspond au pseudo de la session
            $reponse3 = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$_SESSION["pseudo"].'"');
            if ($donnees3 = $reponse3->fetch()){
                // Récupération de l'id de l'utilisateur
                $id_user = $donnees3['ID'];
            }   
            // Insertion des données récupérées dans la base de données
            $reponse = $bdd->prepare('INSERT INTO commentary(content, date_create, article_id, user_id) VALUES(:content, NOW(), :article_id, :user_id)');
            $reponse->execute(array(
                'content' => $content,
                'article_id' => $id_article,
                'user_id' => $id_user
            )); 
            // Redirection vers l'article en cours
            header('Location: ../articleShow.php?show='.$_GET['show'].' ');           
        }	
        else{// L'utilisateur connecté n'a pas envoyer un commentaire                      
            echo "titre ou contenu non valide"; 
        }
    ?>           
<?php include("../include/template2.php"); ?>