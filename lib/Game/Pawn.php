<?php


namespace Game;


class Pawn
{

    // Basic for now. Subject to change
    public function __construct($player) {
        $this->player = $player;
    }

    public function SetPosition($x, $y, $node = null){
        $this->xLocation = $x;
        $this->yLocation = $y;
        $this->node = $node;
        // A statement that will set the perm spawns for the pawns
        if($this->xSpawnLocation == -1 && $this->ySpawnLocation == -1){
            $this->xSpawnLocation = $x;
            $this->ySpawnLocation = $y;
        }
    }

    public function getLocationType()
    {
        if(is_null($this->node))
        {
            return -1;
        }

        return $this->node->getLocationType();
    }



    /**
     * @return mixed
     */
    public function getXLocation()
    {
        return $this->xLocation;
    }

    /**
     * @return mixed
     */
    public function getYLocation()
    {
        return $this->yLocation;
    }

    public function getIsInSpawn()
    {
        return $this->isInSpawn;
    }

    /**
     * @return int
     */
    public function getXSpawnLocation(): int
    {
        return $this->xSpawnLocation;
    }

    /**
     * @return int
     */
    public function getYSpawnLocation(): int
    {
        return $this->ySpawnLocation;
    }

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }




    private $xSpawnLocation = -1; // Pawn spawns x location
    private $ySpawnLocation = -1; // Pawn spawns y location
    private $xLocation;
    private $yLocation;
    private $isInSpawn;
    private $player; // who owns the current piece
    private $node;
}