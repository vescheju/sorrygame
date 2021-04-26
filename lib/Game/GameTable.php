<?php


namespace Game;


class GameTable
{

    public function __construct($row){
        $this->id = $row['id'];
        $this->players = json_decode($row['players'],true);
        $this->started = $row['started'];
        $this->ownerId = $row['owner_id'];
        $this->cards = json_decode($row['cards'],true);
        $this->player_turn = $row['player_turn'];
        $this->occupied = json_decode($row['occupied_nodes'], true);
        $this->card_drawn = $row['card_drawn'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStarted()
    {
        return $this->started;
    }

    public function getOwnerId(){
        return $this->ownerId;
    }
    public function getPlayerIds(){
        return $this->players;
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function getPlayerTurn()
    {
        return $this->player_turn;
    }

    public function getOccupied()
    {
        return $this->occupied;
    }

    public function getCardDrawn(){
        return new Card($this->card_drawn);
    }

    private $id;
    private $players;
    private $started;
    private $ownerId;
    private $cards;
    private $player_turn;
    private $occupied;
    private $card_drawn;
}