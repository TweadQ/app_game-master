<?php

$title = "Update"; //title for current page
ob_start();
require("view/partials/_update.php");

$content = ob_get_clean();
require("layout.php");