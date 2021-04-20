<?php


namespace Game;


class GameLobby
{
    private $id; // game's id
    private $owner_id; // owner's id
    private $players; // number of players.

    public function __construct($id, $owner_id, $players)
    {
        $this->id = $id;
        $this->owner_id = $owner_id;
        $this->players = $players;
    }
}