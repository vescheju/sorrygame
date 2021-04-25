<?php

namespace Game;


class RoomsController{

    public function __construct(Site $site, User $user, $post){
        $root = $site->getRoot();
        $this->redirect = "$root/rooms.php";
        $gamesTable = new GamesTable($site);

        if(isset($post['create_room'])){
            $game = new Game();
            $gameID = $gamesTable->createGame($user,$game);
            $this->redirect = "$root/room.php?game-id=" . strval($gameID);

            $playerTable = new PlayerTable($site);
            $playerTable->setPlayerId($user->getId());
            $player = $playerTable->getPlayerById($user->getId());
            $playerTable->setColor($player, Game::RED);
        }


    }

    public function getRedirect(){
        return $this->redirect;
    }

    private $redirect;
}