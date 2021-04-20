<?php
require __DIR__ . '/lib/game.inc.php';
$open = true;
$view = new Game\RoomView($site);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sorry!</title>
    <link href="lib/game.css" type="text/css" rel="stylesheet" />

</head>
<body>
<?php echo $view->present(); ?>
</body>
<?php echo $view->footer(); ?>
</html>