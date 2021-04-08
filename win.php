<?php
require __DIR__ . '/lib/game.inc.php';
$winner = $game->getWon();
if ($winner == null){
    $color = "Nobody has";
    $id = "noWin";
}
else{
    $color = $winner->getColor();
    if ($color == Game\Game::RED){
        $color = "RED";
        $id = "redWin";
    }
    else if ($color == Game\Game::GREEN){
        $color = "GREEN";
        $id = "greenWin";
    }
    else if ($color == Game\Game::BLUE) {
        $color = "BLUE";
        $id = "blueWin";
    }
    else if ($color == Game\Game::YELLOW) {
        $color= "YELLOW";
        $id = "yellowWin";
    }
}
?>

<!doctype html>
<html lang ="en">
<head>
    <meta charset="utf-8">
    <title>Sorry!</title>
    <link href="lib/game.css" type="text/css" rel="stylesheet" />

</head>
<body>

<div id = "winDisplay">

    <div id='WinnerDiv'>
        <p id = '<?php echo $id;?>'><?php echo $color;?></p>
        <p>won the game!</p>
    </div>
</div>


<div class="game-links">
    <p class="game-link"><a href="index.php">Start Menu</a></p>
</div>

</body>
</html>
