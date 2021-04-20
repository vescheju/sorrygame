<?php
$open = true;		// Can be accessed when not logged in
require '../lib/game.inc.php';

print_r($_GET);

$controller = new Game\RoomsController($site, $user, $_GET, $_POST);
header("location: " . $controller->getRedirect());