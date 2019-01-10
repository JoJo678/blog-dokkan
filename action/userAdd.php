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
        $emailValide = test_input($_POST['Email']);
        // On test pour voir si les champ requis sont renseigner par l'utilisateur
        if(!empty($_POST['Pseudo']) AND !empty($_POST['Nom']) AND !empty($_POST['Prénom']) AND !empty($_POST['pass'])){      
            //On test pour voir si le pseudo existe déjà
            $reponse = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$_POST['Pseudo'].'"');
            if ($donnees = $reponse->fetch()){
                //Erreur on ne peut pas avoir le même pseudo
                header('Location: ../index.php?choix=inscription&e=10'); 
            }
            else{
                // On test pour voir si l'email est valide
                if(filter_var($emailValide, FILTER_VALIDATE_EMAIL)){
                    //Vérifier que l'adresse email existe dans la bd
                    $reponse = $bdd->query('SELECT * FROM users WHERE email = "'.$_POST['Email'].'"');
                    if ($donnees = $reponse->fetch()){
                        //Erreur on ne peut pas avoir la même adresse email
                        header('Location: ../index.php?choix=inscription&e=11'); 
                    }
                    else{
                        // On test pour voir si le mot de passe et sa confirmation sont bien saisie
                        if ($_POST['pass'] === $_POST['pass2']){
                            //Récupération des contenus du formulaires
                            $pseudo = $_POST['Pseudo'];
                            $name = $_POST['Nom'];  
                            $firstname = $_POST['Prénom'];  
                            $email = $_POST['Email'];
                            $password = $_POST['pass'];  
                            $news = $_POST['Newsletters'];
                            $birth = $_POST['birth'];
                            //On test pour voir si l'utilisateur n'a pas mis de photo de profil
                            if (empty($_FILES['fichier2']['name'])){
                                mkdir("../images/".$pseudo."", 0777, true); // Création du dossier de l'utilisateur
                                $dossier = "images/".$pseudo."/defaultUser.jpg"; // On donne à l'utilisateur une image par défaut
                                $imgProfilSrc = "$dossier"; 
                                copy("../images/defaultUser.jpg", "../images/$pseudo/defaultUser.jpg");// On copie l'image dans le dossier de l'utilisateur
                            }
                            else{// L'utilisateur à mis une photo de profil
                                $taille_maxi = 10000000;
                                $taille = filesize($_FILES['fichier']['tmp_name']);
                                $extensions = array('.png','.PNG', '.gif', '.jpg', '.jpeg');
                                $extension = strrchr($_FILES['fichier']['name'], '.'); 
                                //Début des vérifications de sécurité...
                                if (!empty($_FILES['fichier']['name'])){
                                    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                                    {
                                        $erreur = '6';
                                        header('Location: ../index.php?choix=inscription&e=6'); 
                                    }
                                    if($taille>$taille_maxi)
                                    {
                                        $erreur = '7';
                                        header('Location: ../index.php?choix=inscription&e=7'); 
                                    }
                                }
                                if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
                                {
                                    mkdir("../images/".$pseudo."", 0777, true);// Création du dossier de l'utilisateur
                                    $dossier = "images/".$pseudo."/";
                                    $dossier2 ="../images/".$pseudo."/";
                                    $fichier = basename($_FILES['fichier2']['name']);//Récupération du nom de la photo de profil        
                                    $fichier = strtr($fichier, 
                                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                                    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);// Formate le nom du fichier
                                    move_uploaded_file($_FILES['fichier2']['tmp_name'],$dossier2 . $fichier);// copie le fichier vers le dossier de l'utilisateur sur le serveur
                                    $imgProfilSrc = "$dossier$fichier";//Contient l'adresse de l'image sur le serveur
                                }              
                            }
                            //Insertion des données récupérer du formulaire dans la base de données
                            $reponse = $bdd->prepare('INSERT INTO users(pseudo, username, firstname, email, pass, newsletters, date_of_birth, date_of_sign, picture_profil) VALUES(:pseudo, :username, :firstname, :email, :pass, :newsletters, :date_of_birth, NOW(), :picture_profil)');
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
                            //Démarage d'une session avec le pseudo de l'utilisateur et le redirige sur l'accueil       
                            session_start();
                            $_SESSION['pseudo'] = $pseudo;
                            header('Location: ../index.php');   
                        }
                        else{//Si l'utilisateur n'a pas correctement confirmé son mdp
                            header('Location: ../index.php?choix=inscription&e=3');  
                        }
                    }   
                }
                else{//Si l'utilisateur n'a pas renseigner correctement son adresse email
                    header('Location: ../index.php?choix=inscription&e=2'); 
                } 
            }       
        }	
        else{//Si l'utilisateur n'a pas renseigner correctement les champs il est redirigé vers le formulaire d'inscription    
           header('Location: ../index.php?choix=inscription&e=1');    		
        }
    ?>           
<?php include("../include/template2.php"); ?>