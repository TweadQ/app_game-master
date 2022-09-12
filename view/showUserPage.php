<?php

// $title = "Show"; //title for current page
ob_start();
require("view/partials/_showUser.php");

$content = ob_get_clean();
require("layout.php");