<?php
session_start();
$title = "modifier"; //title for current page
require_once("models/database.php");

$game = getGame();

$error = [];
$errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";


if (!empty($_POST["submited"])) {
    update($error);
}

require("view/updatePage.php");
?>
