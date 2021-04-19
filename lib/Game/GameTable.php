<?php


namespace Game;


class GameTable
{


    public function __construct($row){
        $this->id = $row['id'];
        $this->state = json_decode($row['state'],true);
        $this->redId = $row['red_player_id'];
        $this->blueId = $row['blue_player_id'];
        $this->greenId = $row['green_player_id'];
        $this->yellowId = $row['yellow_player_id'];
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
    public function getState()
    {
        return $this->state;
    }

    public function getPlayerId($color){
        if($color == Game::YELLOW){
            return $this->yellowId;
        }
        elseif($color == Game::BLUE){
            return $this->blueId;
        }
        elseif($color == Game::RED){
            return $this->redId;
        }
        elseif($color == Game::GREEN){
            return $this->greenId;
        }
    }

    private $id;
    private $state;
    private $redId;
    private $blueId;
    private $greenId;
    private $yellowId;

}