<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\WaitingRoomView($game);
?>
<!doctype html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
    <?php echo $view->header(); ?>

    <?php echo $view->footer() ?>
</body>
</html>