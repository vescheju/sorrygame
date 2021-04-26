<?php


namespace Game;


class RoomController
{
    private $site;
    private $user;
    private $game_id;
    private $redirect;
    private $get;

    public function __construct(Site $site, User $user, $get, &$post, &$gameClass){
        $root = $site->getRoot();
        $this->site = $site;
        $this->user = $user;

        $info = new GameInfoTable($this->site);
        $game = new GamesTable($this->site);
        $this->get = $get;


        if (isset($post["leave"]) || isset($post["home"])){
            $info->LeaveRoomById($get["game-id"], $user);
            $this->redirect = "$root/rooms.php";
        } else if (isset($get["game-id"])){
            $this->game_id = $get["game-id"];
            $set = $info->joinRoomById($get["game-id"], $user);
            $this->redirect = "$root/room.php?game-id=".strval($this->game_id);
            if($set != null) {
                $playerTable = new PlayerTable($site);
                $playerTable->setPlayerId($user->getId());

                $game = new GamesTable($this->site);
                $color = $game->getAvailableColor($this->game_id);
                if ($color != null) {
                    $playerTable->setColor($user->getId(), $color);
                }
            }
        }
        if (isset($post["start"])) {
            //$this->game_id = $get["game-id"];
            //$this->redirect = "$root/game.php?game-id=".strval($this->game_id);
            $gamesTable = new GamesTable($site);
            $playerTable = new PlayerTable($site);
            $gameTable = $gamesTable->get($this->game_id);

            $players = $gameTable->getPlayerIds();

            foreach ($players as $player){
                $player_turn = false;
                if ($player == $gameTable->getPlayerTurn()){
                    $player_turn = true;
                }
                $color = ($playerTable->getPlayerById($player))->getColor();
                $gameClass->addPlayer($color, $player_turn);
            }
            $gameClass->newGame($site, $this->game_id);
            $this->redirect = "$root/game.php";
        }
    }

    public function getRedirect(){
        return $this->redirect;
    }
}