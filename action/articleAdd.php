<?php include("../include/template.php"); ?>
    <?php 
        $dossier = 'images/articles/';
        $dossier2 = '../images/articles/';
        $fichier = basename($_FILES['fichier']['name']);
        $taille_maxi = 10000000;
        $taille = filesize($_FILES['fichier']['tmp_name']);
        $extensions = array('.png','.PNG', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['fichier']['name'], '.'); 
        //Début des vérifications de sécurité...
        if (!empty($_FILES['fichier']['name'])){
            if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                $erreur = '6';
                header('Location: ../articleNew.php?e=6'); 
            }
            if($taille>$taille_maxi)
            {
                $erreur = '7';
                header('Location: ../articleNew.php?e=7'); 
            }
        }
        if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
            //On formate le nom du fichier ici...
            $fichier = strtr($fichier, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier2 . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                echo 'Upload effectué avec succès !';
            }
            else //Sinon (la fonction renvoie FALSE).
            {
                echo 'Echec de l\'upload !';
            }        
            /* Si l'utilisateur à insérer un titre et du contenu */
            if(!empty($_POST['title']) AND !empty($_POST['editor2']) ){
                //Récupération des données du formulaire
                $article = $_POST['title'];
                $content = $_POST['editor2'];  
                $category = $_POST['category']; 
                $media = "$dossier$fichier";      
                //Requête pour récuperer l'enregistrement qui contient le même pseudo que sur la session
                $reponse = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$_SESSION["pseudo"].'"');
                if ($donnees = $reponse->fetch()){
                    //Récupération de l'id de l'utilisateur
                    $id_user = $donnees['ID'];
                }
                //Requête pour récuperer l'enregistrement d'un article si le titre existe déjà
                $reponse2 = $bdd->query('SELECT * FROM articles WHERE title = "'.$article.'"');
                if ($donnees2 = $reponse2->fetch()){
                    //Erreur on ne peut pas avoir le même nom d'article
                    header('Location: ../articleNew.php?e=9'); 
                }
                else{
                    //Insertion des données récupérer dans la base de données
                    $reponse = $bdd->prepare('INSERT INTO articles(title, content, date_create, category, content_media, user_id) VALUES(:title, :content, NOW(), :category, :content_media, :user_id)');
                    $reponse->execute(array(
                        'title' => $article,
                        'content' => $content,
                        'category' => $category,
                        'content_media' => $media,
                        'user_id' => $id_user
                    )); 
                    //Redirection vers la page de création d'un nouvel article
                    header('Location: ../articleNew.php');      
                }   
            }	
            else{/* Si l'utilisateur n'a pas insérer un titre et / ou du contenu */                 
                header('Location: ../articleNew.php?e=8'); 
            }
        }
        else{//Erreur lors de l'upload d'un fichier   
            header('Location: ../articleNew.php?e='.$erreur); 
        }
    ?>
<?php include("../include/template2.php"); ?>