<?php


namespace Game;


class GameController
{

    public function __construct(Game $game, $post, $user)
    {
        if ($game->getGameState() == Game::DRAWCARD &&
            isset($post["card_x"]) && isset($post["card_y"])) {
            $game->drawCard();
            $game->setNextGameState();
            $game->updateDB(false);
        } else if($game->getGameState() == Game::ACTION &&
            isset($post['cell'])){

            $value = strip_tags($post['cell']);
            $game->interact($value);
            // the code below is for the reachable nodes
            //$split = explode(',', $value);
            //$node = new Node(+$split[0], +$split[1], $game->getPlayerTurn()->getColor(), Node::SQUARE);
            //$node->reachableNodes($game->getCard()->getCardType(), $node->getPawnColor());

            $game->updateDB(false);

        } else if (isset($post['done'])){
            // you can skip turn when you draw 11
            if($game->getGameState() == Game::DONE){
                $game->setNextGameState();

            }
            elseif($game->getCard()->getCardType()==11 && $game->getGameState() == Game::ACTION) {
                $game->setNextGameState();
                $game->setNextGameState();
                $game->setBonusFlag(false);
                $game->nextTurn();
            }
            $game->updateDB(true);
        }
        $this->reload($game, $user->getId());

    }

    private function reload(Game $game, $userID){
        /*
        * PHP code to cause a push on a remote client.
        */
        $players = $game->getPlayerTableIds();
        foreach ($players as $player) {
            $key = "team25_" . $player;
            $msg = json_encode(array('key' => "$key", 'cmd' => 'reload'));

            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            $sock_data = socket_connect($socket, '127.0.0.1', 8078);
            if (!$sock_data) {
                echo "Failed to connect";
            } else {
                socket_write($socket, $msg, strlen($msg));
            }
            socket_close($socket);
        }

    }

    public function isReset()
    {
        return $this->reset;
    }

    private $reset = false;
    // private $selectedPawn;
}

