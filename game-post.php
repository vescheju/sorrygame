<?php
require 'lib/game.inc.php';

if ($game->getWon() != null){
    header("location: win.php");
    exit;
}
else {
    $controller = new Game\GameController($game, $_POST);


//Testing
//$card_c = $game->getCard();
//$src = $card_c->getImageSource();
//echo $src;
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
    //echo $game->getPlayerCount();
   // print_r ($game->getPlayerTableIds());

    header("location: game.php");
    exit;
}
