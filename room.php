<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\RoomView($site, $_GET);
?>

<!doctype html>
<html>
<head>
    <?php echo $view->head(); ?>
</head>
<body>
<?php echo $view->header(); ?>
<?php echo $view->present(); ?>
<?php echo $view->footer(); ?>
</body>

</html>