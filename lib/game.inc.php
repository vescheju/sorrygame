<?php
require __DIR__ . "/../vendor/autoload.php";

// Start the PHP session system

$site = new Game\Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}

session_start();

$user = null;
if(isset($_SESSION[Game\User::SESSION_NAME])) {
    $user = $_SESSION[Game\User::SESSION_NAME];
}

$game_id = null;
define("GAME_ID", 'game_id');
if(isset($_SESSION[GAME_ID])) {
    $game_id = $_SESSION[GAME_ID];
}

// redirect if user is not logged in
if((!isset($open) || !$open) && $user === null) {
    $root = $site->getRoot();
    header("location: $root/");
    exit;
}

define("GAME_SESSION", 'game');

// If there is a Game session, use that. Otherwise, create one
if(!isset($_SESSION[GAME_SESSION])) {
    $_SESSION[GAME_SESSION] = new Game\Game();
}

$game = $_SESSION[GAME_SESSION];