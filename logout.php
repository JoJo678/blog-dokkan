<!-- Permet de faire déconnecter un utilisateur -->
<?php 
    session_start();
    session_destroy();
    header('Location: index.php');  
?>   
