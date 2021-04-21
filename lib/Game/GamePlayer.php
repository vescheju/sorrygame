<?php


namespace Game;


class GamePlayer
{
    public function __construct($row)
    {
        $this->id = $row["player_id"];
        $this->color = $row["color"];
        $this->pawns = json_decode($row["pawns"], true);
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

    private $id;
    private $color;
    private $pawns;
}