<?php


namespace Game;


class GameController
{

    public function __construct(Game $game, $post)
    {
        if ($game->getGameState() == Game::DRAWCARD &&
            isset($post["card_x"]) && isset($post["card_y"])) {
            $game->drawCard();
            $game->setNextGameState();
        } else if($game->getGameState() == Game::ACTION &&
            isset($post['cell'])){

            $value = strip_tags($post['cell']);
            $game->interact($value);
            // the code below is for the reachable nodes
            //$split = explode(',', $value);
            //$node = new Node(+$split[0], +$split[1], $game->getPlayerTurn()->getColor(), Node::SQUARE);
            //$node->reachableNodes($game->getCard()->getCardType(), $node->getPawnColor());


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
        }
    }

    public function isReset()
    {
        return $this->reset;
    }

    private $reset = false;
    // private $selectedPawn;
}

