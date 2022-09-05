<?php
$title = "Show"; //title for current page
require_once("models/database.php");

$game = getGame();

$title = $game['name'];
/**
 * Show view
 */
require("view/ShowPage.php");
?>
