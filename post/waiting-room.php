<?php
require '../lib/game.inc.php';

$controller = new Game\WaitingRoomController($site, $_POST, $game);
header("location: " . $controller->getRedirect());
