<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\GameView($game);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sorry!</title>
    <link href="game.css" type="text/css" rel="stylesheet" />


</head>
<body>


<?php
echo $view->gameState();
echo $view->grid();

?>

</body>
</html>


