<?php
require __DIR__ . "/../vendor/autoload.php";

// Start the PHP session system
session_start();

define("GAME_SESSION", 'game');

// If there is a Game session, use that. Otherwise, create one
if(!isset($_SESSION[GAME_SESSION])) {
    $_SESSION[GAME_SESSION] = new Game\Game();
}

$game = $_SESSION[GAME_SESSION];