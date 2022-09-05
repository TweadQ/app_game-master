<?php

// $title = "Show"; //title for current page
ob_start();
require("view/partials/_show.php");

$content = ob_get_clean();
require("layout.php");