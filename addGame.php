<!-- header -->
<?php
// start session
session_start();
$title = "Add Game"; //title for current page
// include PDO pour la connexion BDD
require_once("models/database.php");
// debug_array($_GET)

// traitement du formulaire
//////////////////////////
// creation array error
$error = [];
$errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";
// variable success
$success = false;


// 1-je verifie si le formulaire est soumis
if (!empty($_POST["submited"]) && isset($_FILES["url_img"]) && $_FILES["url_img"]["error"] == 0) {
    
}

?>
