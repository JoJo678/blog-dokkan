<?php
    //Connexion à la base de données
    try{
        $bdd = new PDO ('mysql:host=127.0.0.1;dbname=blog;charset=utf8','root','',
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e)
    {
        die ('Erreur : ' . $e ->getMessage());
    }
?>