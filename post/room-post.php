<?php
require '../lib/game.inc.php';

print_r($_GET);

$controller = new Game\RoomController($site, $user, $_GET, $_POST);
header("location: " . $controller->getRedirect());
exit;