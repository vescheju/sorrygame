<?php
$open = true;		// Can be accessed when not logged in
require '../lib/game.inc.php';

$controller = new Game\UserController($site, $_POST);
header("location: " . $controller->getRedirect());
exit;