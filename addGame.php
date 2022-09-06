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
if (!empty($_POST["submited"]) && isset($_FILES["url_img"]) && $_FILES["url_img"]["error"] == 0) {
    create($error);
}

/**
 * Show view
 */
require("view/addGamePage.php");
?>
