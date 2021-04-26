<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\GameView($game);
$key = "team25_" . $user->getId();
$game_id = $game->getGameId();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sorry!</title>
    <link href="lib/game.css" type="text/css" rel="stylesheet" />
    <script>
        /**
         * Initialize monitoring for a server push command.
         * @param key Key we will receive.
         */
        function pushInit(key) {
            var conn = new WebSocket('ws://webdev.cse.msu.edu/ws');
            conn.onopen = function (e) {
                console.log("Connection to push established!");
                conn.send(key);
            };

            conn.onmessage = function (e) {
                console.log("got message");
                try {
                    var msg = JSON.parse(e.data);
                    if (msg.cmd === "reload") {
                        location.reload();
                    }
                } catch (e) {
                }
            };
        }

        pushInit("<?php echo $key;?>");
    </script>
</head>
<body>


<?php
echo $view->gameState();
echo $view->grid();
?>

</body>
</html>


