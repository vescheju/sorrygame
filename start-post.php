<?php
require __DIR__ . '/lib/game.inc.php';
$controller = new Game\StartController($game, $_POST);

if ($controller->isReset()) {
    unset($_SESSION[GAME_SESSION]);
}
//Testing
//$players = $game->getPlayers();
//echo '<pre>'; print_r($players); echo '</pre>';
//echo '<pre>'; print_r($game->getPlayerCount()); echo '</pre>';
header("location: " . $controller->getCurrPage());
exit;