<!-- Contient la pagination pour les articles -->
<div id="testour">
    <?php
    //Si on a un filtre
    if(isset($_GET["filtre"])){
        $customPagination = 0;
        /* Affichage de la pagination */
        while ($customPagination < $pagination) {
            echo '<span id="pageMsg"><a href="?filtre='.($_GET["filtre"]).'&?p='.($customPagination+1).'">'.($customPagination+1).'</a> </span>';
            $customPagination++;
        }
    }
    else{// on a pas de filtre
        $customPagination = 0;
        /* Affichage de la pagination */
        while ($customPagination < $pagination) {
            echo '<span id="pageMsg"><a href="?p='.($customPagination+1).'">'.($customPagination+1).'</a> </span>';
            $customPagination++;
        }
    }
    ?>
</div>