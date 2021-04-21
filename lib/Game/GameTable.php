<?php


namespace Game;


class GameTable
{

    public function __construct($row){
        $this->id = $row['id'];
        $this->players = json_decode($row['players'],true);
        $this->started = $row['started'];
        $this->ownerId = $row['owner_id'];
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


    private $id;
    private $players;
    private $started;
    private $ownerId;
}