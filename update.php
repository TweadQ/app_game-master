<?php
session_start();
$title = "modifier"; //title for current page
require_once("models/database.php");

$game = getGame();

$error = [];
$errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";


if (!empty($_POST["submited"])) 
{
    require_once("utils/security-form/include.php");
    if(count($error) == 0) 
    {
        update($name, $price, $note, $description, $genre_clear, $plateforms_clear, $PEGI, $url_img);
    }
}

require("view/updatePage.php");
?>
