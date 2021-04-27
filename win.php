<?php
require __DIR__ . '/lib/game.inc.php';
$winner = $game->getWon();
if ($winner == null){
    $color = "Nobody";
    $id = "noWin";

}else{
    $color = $winner->getColor();
    /*
    $gamesTable = new \Game\GamesTable($site);
    $winningPlayer = $gamesTable->getPlayer($game, $color);
    if ($winningPlayer->getId() != $user->getId()){
        $message="Better Luck Next Time!";
    }
    else{
        $message="Great Job!";
    }
    */

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
        <?php
        if($id === 'noWin'){
            echo '<p>won the game!</p>';

        }else{
            echo '<p>won the game! Congratulations!!</p>';

        }
        ?>

    </div>
</div>

<div id = "loseDisplay">

    <div id='LoserDiv'>
        <p>Better Luck next time!</p>
    </div>
</div>


<div class="game-links">
    <p class="game-link"><a href="start.php">Start Menu</a></p>
    <p class="game-link"><a href="logout-post.php">Log Out</a></p>
</div>

</body>
</html>
