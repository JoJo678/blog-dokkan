<?php include("../include/template.php"); ?>	
    <?php 
        //On vérifie que l'utilisteur à bien écris un pseudo et un mot de passe
        if(!empty($_POST['Pseudo']) AND !empty($_POST['pass'])){
            //On récupère les données fournis par l'utilisateur
            $pseudo = $_POST['Pseudo'];
            $pass = $_POST['pass']; 
            //On cherche dans la base de données le pseudo fournis par l'utilisateur
            $reponse = $bdd->query("SELECT * FROM users WHERE pseudo = '".$pseudo."' ");
            //Si le pseudo existe dans la base de données
            if ($reponse = $reponse->fetch()){
                //On récupère son mot de passe
                $mdpUser = $reponse['pass'];
                //On vérifie si le mot de passe récupérer correspond bien à celui que l'utilisateur a renseigné
                if ($mdpUser == $pass){
                    // On récupére son nom, prénom et puis on lance une nouvelle session et redirection sur la page d'accueil
                    $firstname = $reponse['firstname'];
                    $name = $reponse['username'];
                    session_start();
                    $_SESSION['pseudo'] = $pseudo;
                    header('Location: ../index.php');                                  
                }
                else{// L'utilisateur a renseigné un mauvais mot de passe
                    header('Location: ../index.php?choix=connexion&e=5'); 
                }
            }
            else{// L'utilisateur a renseigné un mauvais pseudo
                header('Location: ../index.php?choix=connexion&e=4'); 
            }
            $reponse->closeCursor();
        }            
    ?> 
<?php include("../include/template2.php"); ?>