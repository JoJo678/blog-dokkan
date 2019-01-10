<?php include("../include/template.php"); ?>	
    <?php 
        //Fonction pour vérifier l'adresse email 
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $reponse = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$_SESSION["pseudo"].'"');
        // On prend l'enregistrement en fonction du pseudo
        if ($donnees = $reponse->fetch()){
            $emailValide = test_input($_POST['email']);
            // On test pour voir si les champ requis sont renseigner par l'utilisateur
            if(!empty($_POST['pseudo']) AND !empty($_POST['username']) AND !empty($_POST['firstname']) AND !empty($_POST['pass'])){
                //On test pour voir si le pseudo existe déjà
                $reponse2 = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$_POST['pseudo'].'" AND pseudo != "'.$_SESSION['pseudo'].'"');
                if ($donnees2 = $reponse2->fetch()){
                    //Erreur on ne peut pas avoir le même pseudo qu'un autre utilisateur
                    header('Location: ../panelModification.php?e=10');
                }
                else{
                    // On test pour voir si l'email est valide
                    if(filter_var($emailValide, FILTER_VALIDATE_EMAIL)){
                        //Vérifier que l'adresse email existe dans la bd
                        $reponse2 = $bdd->query('SELECT * FROM users WHERE email = "'.$_POST['email'].'" AND pseudo != "'.$_SESSION['pseudo'].'"');
                        if ($donnees2 = $reponse2->fetch()){
                            //Erreur on ne peut pas avoir la même adresse email pour 2 utilisateurs
                            header('Location: ../panelModification.php?e=11');      
                        }
                        else{
                            // On test pour voir si le mot de passe et sa confirmation sont bien saisie
                            if ($_POST['pass'] === $_POST['pass2']){
                                //Récupération des contenus du formulaires
                                $pseudo = $_POST['pseudo'];
                                $name = $_POST['username'];  
                                $firstname = $_POST['firstname'];  
                                $email = $_POST['email'];
                                $password = $_POST['pass'];  
                                if ($_POST['newsletters'] == "on"){
                                    $news = "checked";
                                }
                                $birth = $_POST['birth'];
                                $userAct = $_SESSION["pseudo"];
                                $imgProfileAncienne = $_POST['profilImage'];
                                $imgProfilSrc = $donnees['picture_profil']; 
                                //On renommer le fichier de l'utilisateur si il change de pseudo               
                                if ($pseudo != $userAct){
                                    sleep(1);
                                    rename("../images/".$_SESSION["pseudo"]."/", "../images/".$pseudo."/");session_start();
                                    $_SESSION['pseudo'] = $pseudo;     
                                }
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
                                        header('Location: ../panelModification.php?e=6'); 
                                    }
                                    if($taille>$taille_maxi)
                                    {
                                        $erreur = '7';
                                        header('Location: ../panelModification.php?e=7'); 
                                    }    
                                    if(!isset($erreur)){ //S'il n'y a pas d'erreur, on upload      
                                        $dossier = "images/".$pseudo."/";
                                        $dossier2 = "../images/".$pseudo."/";
                                        $fichier = basename($_FILES['fichier2']['name']);//Récupération du nom de la photo de profil
                                        $fichier = strtr($fichier, 
                                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                                        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);// Formate le nom du fichier
                                        move_uploaded_file($_FILES['fichier2']['tmp_name'],$dossier2 . $fichier);// copie le fichier vers le dossier de l'utilisateur sur le serveur
                                        $imgProfilSrc = "$dossier$fichier";//Contient l'adresse de l'image sur le serveur
                                    }
                                }
                                else{
                                    if ($imgProfileAncienne!="0"){
                                        $dossier = $imgProfileAncienne;
                                        $imgProfilSrc = "$dossier";
                                    }
                                }
                                //Mise a jour des données récupérer du formulaire dans la base de données
                                $reponse = $bdd->prepare('UPDATE users SET pseudo =:pseudo, username=:username, firstname=:firstname, email=:email, pass=:pass, newsletters=:newsletters, date_of_birth=:date_of_birth,picture_profil=:picture_profil WHERE pseudo="'.$userAct.'"');
                                $reponse->execute(array(
                                    'pseudo' => $pseudo,
                                    'username' => $name,
                                    'firstname' => $firstname,
                                    'email' => $email,
                                    'pass' => $password,
                                    'newsletters' => $news,
                                    'date_of_birth' => $birth,
                                    'picture_profil' => $imgProfilSrc
                                    ));
                                header('Location: ../index.php');           
                            }
                            else{//Si l'utilisateur n'a pas correctement confirmé son mdp
                                header('Location: ../panelModification.php?e=3');  
                            }
                        }
                    }
                    else{//Si l'utilisateur n'a pas renseigner correctement son adresse email
                        header('Location: ../panelModification.php?e=2'); 
                    }
                }
            } 	
            else{//Si l'utilisateur n'a pas renseigner correctement les champs             
                header('Location: ../panelModification.php?e=1');           		
            }
        }
    ?>
<?php include("../include/template2.php"); ?>