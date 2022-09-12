<?php

session_start();

require_once("controllers/Game.php");

$controller = new \Controllers\Game();
$controller->index();
