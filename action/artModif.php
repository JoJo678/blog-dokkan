<?php include("../include/template.php"); ?>	
    <?php 
    if (!empty($_POST['title']) OR !empty($_POST['editor1']) OR !empty($_FILES['fichier2']['name'])){
        // L'utilisateur à mis une photo de profil    
        //Début des vérifications de sécurité...       
        if (!empty($_FILES['fichier2']['name'])){
            $taille_maxi = 10000000;
            $taille = filesize($_FILES['fichier2']['tmp_name']);
            $extensions = array('.png','.PNG','.gif', '.jpg', '.jpeg');
            $extension = strrchr($_FILES['fichier2']['name'], '.'); 
            if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                $erreur = '6';
                header('Location: ../contact.php'); 
                /* header('Location: ../artModif.php?show=<?php echo $donnees["ID"] ?>&?e=6'); A modif */ 
            }
            if($taille>$taille_maxi)
            {
                $erreur = '7';
                header('Location: ../panelModification.php?e=7');
                /* header('Location: ../artModif.php?show=<?php echo $donnees["ID"] ?>&?e=6'); A modif */ 
            }
            if(!isset($erreur)){ //S'il n'y a pas d'erreur, on upload     
                $dossier = 'images/articles/';
                $dossier2 = '../images/articles/';
                $fichier = basename($_FILES['fichier2']['name']);//Récupération du nom de la photo de profil
                $fichier = strtr($fichier, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);// Formate le nom du fichier
                move_uploaded_file($_FILES['fichier2']['tmp_name'],$dossier2 . $fichier);// copie le fichier vers le dossier de l'utilisateur sur le serveur
                $media = "$dossier$fichier";//Contient l'adresse de l'image sur le serveur
                //Requête pour modifier le lien de l'image
                $reponse = $bdd->prepare('UPDATE articles SET content_media=:content_media WHERE ID = "'.$_GET['show'].'" ');
                $reponse->execute(array(       
                    'content_media' => $media
                ));   
            }  
        }
        $title = $_POST['title'];
        $content = $_POST['editor1']; 
        //Mise a jour des données récupérer du formulaire dans la base de données
        $reponse = $bdd->prepare('UPDATE articles SET content=:content, title=:title WHERE ID = "'.$_GET['show'].'" ');
        $reponse->execute(array(
            'content' => $content ,
            'title'=> $title
        ));
        header('Location: ../index.php'); 
    }          
    ?>
<?php include("../include/template2.php"); ?>