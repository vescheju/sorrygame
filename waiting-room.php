<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\WaitingRoomView($game, $site);
if(!$view->protect($site, $user)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="waiting-room">
    <?php echo $view->header(); ?>
    <?php echo $view->present() ?>
    <?php echo $view->footer() ?>
</div>

</body>
</html>