<?php


namespace Game;


class Player
{
    public function __construct($color, $site, $user){
        $this->color = $color; // Set the color of the player
        if($color == Game::RED){
            $pawn1 = new Pawn($this);
            $pawn1->SetPosition(12, 10);
            $pawn2 = new Pawn($this);
            $pawn2->SetPosition(12, 12);
            $pawn3 = new Pawn($this);
            $pawn3->SetPosition(14, 10);
            $pawn4 = new Pawn($this);
            $pawn4->SetPosition(14, 12);
            $this->pawns[] = $pawn1;
            $this->pawns[] = $pawn2;
            $this->pawns[] = $pawn3;
            $this->pawns[] = $pawn4;
        }elseif($color == Game::GREEN){
            $pawn1 = new Pawn($this);
            $pawn1->SetPosition(3, 12);
            $pawn2 = new Pawn($this);
            $pawn2->SetPosition(5, 12);
            $pawn3 = new Pawn($this);
            $pawn3->SetPosition(3, 14);
            $pawn4 = new Pawn($this);
            $pawn4->SetPosition(5, 14);
            $this->pawns[] = $pawn1;
            $this->pawns[] = $pawn2;
            $this->pawns[] = $pawn3;
            $this->pawns[] = $pawn4;
        }elseif($color == Game::BLUE){
            $pawn1 = new Pawn($this);
            $pawn1->SetPosition(10, 1);
            $pawn2 = new Pawn($this);
            $pawn2->SetPosition(10, 3);
            $pawn3 = new Pawn($this);
            $pawn3->SetPosition(12, 1);
            $pawn4 = new Pawn($this);
            $pawn4->SetPosition(12, 3);
            $this->pawns[] = $pawn1;
            $this->pawns[] = $pawn2;
            $this->pawns[] = $pawn3;
            $this->pawns[] = $pawn4;
        }else{
            $pawn1 = new Pawn($this);
            $pawn1->SetPosition(1, 3);
            $pawn2 = new Pawn($this);
            $pawn2->SetPosition(1, 5);
            $pawn3 = new Pawn($this);
            $pawn3->SetPosition(3, 3);
            $pawn4 = new Pawn($this);
            $pawn4->SetPosition(3, 5);
            $this->pawns[] = $pawn1;
            $this->pawns[] = $pawn2;
            $this->pawns[] = $pawn3;
            $this->pawns[] = $pawn4;

        }

        $playerTable = new PlayerTable($site);
        $currPlayer = $playerTable->getPlayerById($user->getId());
        if($currPlayer->getColor() == $color){
            $playerTable->SetPawns($user->getId(),$this->pawns);
        }


    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }


    /**
     * @return mixed
     */
    public function getPawns()
    {
        return $this->pawns;
    }

    /**
     * AZ
     * @return mixed
     */
    public function getSpawnLocation()
    {
        return $this->spawnLocation;
    }

    /**
     * AZ
     * @param mixed $spawnLocation
     */
    public function setSpawnLocation($spawnLocation)
    {
        $this->spawnLocation = $spawnLocation;
    }

    /**
     * @return bool
     */
    public function hasPlayerWon()
    {
        $won = true;
        foreach ($this->pawns as $pawn)
        {
            if ($pawn->getLocationType() != Node::HOME)
            {
                $won = false;
                break;
            }
        }

        return $won;
    }

    /**
     * @return int
     */
    public function getPawnCount(): int
    {
        return $this->pawnCount;
    }

    /**
     * @param int $pawnCount
     */
    public function setPawnCount(int $pawnCount)
    {
        $this->pawnCount = $pawnCount;
    }

    public function decreasePawnCount(){
        $this->pawnCount--;
    }


    public function setPawns($pawnArray){
        $this->pawns = $pawnArray;
    }



    private $pawnCount = 4;
    private $game; // The game itself
    private $gameController; //
    private $color; // the color of the player
    private $pawns; // the pawns owned by the player
    private $name; // the player's name
    private $reachEnd; // checking if the player has reached the end
    private $startNode; //  the starting node tile
    private $endNode; // the ending node tile
    private $currentPawn; // the current pawn being moved
    private $spawnLocation; // where the pawn will spawn


}