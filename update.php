<?php
session_start();
$title = "modifier"; //title for current page
require_once("models/database.php");

$game = getGame();

$error = [];
$errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";


if (!empty($_POST["submited"])) 
{
    if(empty($Files["url_img"]["name"])) 
    {
        $url_img = $game["url_img"];
    }
    update($error);
}

require("view/updatePage.php");
?>
