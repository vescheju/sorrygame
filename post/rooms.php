<?php
require '../lib/game.inc.php';


$controller = new Game\RoomsController($site, $user, $_POST);
header("location: " . $controller->getRedirect());
exit;
