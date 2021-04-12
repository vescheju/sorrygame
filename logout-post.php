<?php
require  __DIR__ . '/lib/game.inc.php';

unset($_SESSION[Game\User::SESSION_NAME]);

$root = $site->getRoot();
header("location: $root/");
exit;