<?php
/**
 * This file show the home page
 */
session_start();
$title = "Accueil"; //title for current page
 /**
  * Get all games from models and stock in array $games
  */

require_once("models/Game.php");

$model = New Game();
$games = $model->getAllGames();
/**
 * Show view
 */
require("view/Homepage.php");

