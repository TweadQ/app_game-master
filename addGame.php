<!-- header -->
<?php
session_start();
/**
 * This file show form to create a new game
 */
$title = "Add Game"; //title for current page
require_once("models/database.php");


// traitement du formulaire
//////////////////////////
// creation array error
$error = [];
$errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";



// 1-je verifie si le formulaire est soumis
if (!empty($_POST["submited"])) {
    require_once("utils/security-form/include.php");
    if(count($error) == 0) 
    {
        create($name, $price, $note, $description, $genre_clear, $plateforms_clear, $PEGI, $url_img);
    }
}

/**
 * Show view
 */
require("view/addGamePage.php");
?>
