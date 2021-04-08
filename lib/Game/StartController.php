<?php


namespace Game;


class StartController
{
    public function __construct(Game $game, $post)
    {
        $game->newGame();
        if(isset($post['color']) && in_array('Red', $post['color'])) {
            $game->addPlayer(game::RED);
        }
        if(isset($post['color']) && in_array('Green', $post['color'])) {
            $game->addPlayer(game::GREEN);
        }
        if(isset($post['color']) && in_array('Blue', $post['color'])) {
            $game->addPlayer(game::BLUE);
        }
        if(isset($post['color']) && in_array('Yellow', $post['color'])) {
            $game->addPlayer(game::YELLOW);
        }

        $this->numPlayers = $game->getPlayerCount();

        if($this->numPlayers < 2) {
            $this->currPage = 'index.php';
        }

    }

    /**
     * @return bool
     */
    public function isReset()
    {
        return $this->reset;
    }

    public function getCurrPage() {
        return $this->currPage;
    }

    private $reset = false;
    private $numPlayers;
    private $currPage = 'game.php';
}