<?php
/**
 * This file show the home page
 */
session_start();

require_once("controllers/User.php");

$controller = new \Controllers\User();
$controller->index();
