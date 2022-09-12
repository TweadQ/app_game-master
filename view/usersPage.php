<?php

$title = "User page"; //title for current page
ob_start();
require("view/partials/_user.php");

$content = ob_get_clean();
require("layout.php");