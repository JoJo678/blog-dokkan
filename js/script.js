// Fonction sur la page index
$("#eventOn").ready(function() {
    var slideIndex = 0;
    showSlides();		
    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");	
        for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        slides[slideIndex-1].style.display = "block";  
        setTimeout(showSlides, 3500); // Change image every 2 seconds
    }
});	
$("#eventOn").ready(function() {
    var slideIndex = 0;
    showSlides();		
    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides2");	
        for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        slides[slideIndex-1].style.display = "block";  
        setTimeout(showSlides, 3500); // Change image every 2 seconds
    }
});	
/////////////////////////////////////////////////////////////////////////////


// Fonction sur la page inscription/connexion
//onOverForm, onOutForm, onOverFormPass, onOutFormPass, onOverFormDate

// Fonction pour faire apparaitre la partie inscription/connexion
function test(){
    $('#testou').on('click', function(e) {
        $("#testou").css("display", "none");
        location.href = 'index.php';
    }).on('click', '.formulaire', function(e) {
        e.stopPropagation();
    });
}

// Fonction lorsqu'on va sur un élément ou lorsque l'on ressort de l'élément
// La valeur de l'élément est retiré
function onOverForm(over){
    var getName = over.name;
    if (over.value==getName){
        over.value='';
    } 
}

// Réaffichage de la valeur de l'élément
function onOutForm(out){
    var getName = out.name;
    if (out.value==''){
        out.value=getName;
    } 
}

// Changement du type du champ (texte en mdp) La valeur de l'élément est retiré
function onOverFormPass(over){
    if (over.value=='Mot de Passe'){
        over.value='';   
    } 
    if (over.value==''){
        over.type='password';
    }  
}

// Changement du type du champ (mdp en texte) La valeur de l'élément est ajouté
function onOutFormPass(out){
    if (out.value==''){
        out.value='Mot de Passe';
    } 
    if (out.value=='Mot de Passe'){
        out.type='text';
    }
}

// Changement de la valeur de l'élément
function onOverFormDate(over){
    if (over.value=='Date de naissance'){
        over.type='date'; 
    } 
}

// Changement du type du champ (texte en mdp) La valeur de l'élément est retiré
function onOverFormPassConf(over){
    if (over.value=='Confirmation mdp'){
        over.value='';   
    } 
    if (over.value==''){
        over.type='password';
    }  
}

// Changement du type du champ (mdp en texte) La valeur de l'élément est ajouté
function onOutFormPassConf(out){
    if (out.value==''){
        out.value='Confirmation mdp';
    } 
    if (out.value=='Confirmation mdp'){
        out.type='text';
    }
}

// Fonction pour faire apparaitre l'éditeur d'article si l'utilisateur clique sur le lien modifier l'article
function showModif(){
    $("#cke_modifp").css("display", "block");
    $("#formArtModif").css("display", "block");
    $("#btnArtModif").css("display", "none");
    $(".showContent").css("display", "none");
    $("#espaceCommentaire").css("display", "none");
}