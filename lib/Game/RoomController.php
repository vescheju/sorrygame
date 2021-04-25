<?php


namespace Game;


class RoomController
{
    private $site;
    private $user;
    private $game_id;
    private $redirect;

    public function __construct(Site $site, User $user, $get, &$post){
        $root = $site->getRoot();
        $this->site = $site;
        $this->user = $user;

        $info = new GameInfoTable($this->site);
        $game = new GamesTable($this->site);


        if (isset($post["leave"]) || isset($post["home"])){
            $info->LeaveRoomById($get["game-id"], $user);
            $this->redirect = "$root/rooms.php";
        } else if (isset($get["game-id"])){
            $this->game_id = $get["game-id"];
            $info->joinRoomById($get["game-id"], $user);
            $this->redirect = "$root/room.php?game-id=".strval($this->game_id);
            $playerTable = new PlayerTable($site);
            $playerTable->setPlayerId($user->getId());
        }
        else if (isset($post["start"])) {
            $this->game_id = $get["game-id"];
            $this->redirect = "$root/game.php?game-id=".strval($this->game_id);
        }




    }

    public function getRedirect(){
        return $this->redirect;
    }
}