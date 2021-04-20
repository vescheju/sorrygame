<?php


namespace Game;


class GameInfo
{
    private $id; // game session id
    private $owner_id; // owner's id, who can start the game
    private $players; // array of players

    public function __construct($row){
        $this->id = $row['id'];
        $this->owner_id = $row['owner_id'];
        $this->players = json_decode($row['players'], true);
    }

    public function getPlayersCount():int{
        return count($this->players);
    }

    public function getOwnerId(){
        return $this->owner_id;
    }

    public function getPlayers(){
        return $this->players;
    }

    public function getId(){
        return $this->id;
    }
}