<?php
$title = "Show"; //title for current page
require_once("models/Game.php");

$model = New Game();
$game = $model->getGame();

$title = $game['name'];
/**
 * Show view
 */
require("view/ShowPage.php");
?>
