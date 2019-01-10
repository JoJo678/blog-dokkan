<?php 
// Affichage des erreurs en fonction du cas
if (isset($_GET["e"])){
    switch ($_GET["e"]) {
        case "1":
            echo"<script language='javascript'> alert('Veuillez remplir les champs correctement')</script>";
            break;
        case "2":
            echo"<script language='javascript'> alert('Veuillez entrer correctement votre adresse email')</script>";
            break;
        case "3":
            echo"<script language='javascript'> alert('Veuillez confirmer correctement votre mot de passe')</script>";
            break;
        case "4":
            echo"<script language='javascript'> alert('Veuillez renseigner un pseudo et un mot de passe valide')</script>";
            break;
        case "5":
            echo"<script language='javascript'> alert('Veuillez renseigner votre mot de passe correctement')</script>";
            break;
        case "6":
            echo"<script language='javascript'> alert('Vous devez uploader un fichier de type png, gif, jpg, jpeg')</script>";
            break;
        case "7":
            echo"<script language='javascript'> alert('Le fichier est trop gros')</script>";
            break;
        case "8":
            echo"<script language='javascript'> alert('Veuillez renseigner un titre et du contenu')</script>";
            break;
        case "9":
            echo"<script language='javascript'> alert('Le titre existe déjà, veuillez renseigner un autre titre')</script>";
            break;
        case "10":
            echo"<script language='javascript'> alert('Veuillez renseigner un pseudo inexistant')</script>";
            break;
        case "11":
            echo"<script language='javascript'> alert('Veuillez renseigner une adresse email inexistante')</script>";
            break;
    }
} 
?>