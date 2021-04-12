<?php
$open = true;
require __DIR__ . '/lib/game.inc.php';
$view = new Game\LoginView();
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
</html>