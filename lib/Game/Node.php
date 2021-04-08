<?php


namespace Game;


class Node
{
    // different pawn colors that are on the node
    const RED = Game::RED;
    const GREEN = Game::GREEN;
    const BLUE = Game::BLUE;
    const YELLOW = Game::YELLOW;
    const NO_COLOR = 4;

    // different types
    const START = 5;
    const SAFE = 6;
    const HOME = 7;
    const SQUARE = 8; // represents a normal square
    const  SMALLSLIDE = 9;
    const  BIGSLIDE = 10;

    // slide start and end nodes
    const BEGINOFSLIDE = 11;
    const ENDOFSLIDE = 12;



    // ways that the player can move
    const BACK = 15;
    const FRONT = 16;


    public function __construct($xPos, $yPos, $pawnColor=self::NO_COLOR, $locationType=self::SQUARE) {
        $this->onPath = false;
        $this->blocked = false;
        $this->reachable = false;
        $this->to = [];

        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->pawnColor = $pawnColor;
        $this->locationType = $locationType;
    }

    /**
     * Add a neighboring node
     * @param Node $neighborNode Node we can step into
     */
    public function addTo($neighborNode) {
        $this->to[] = $neighborNode;
    }

    public function searchReachable($distance, $displayAllNodes = false, $currWay = self::FRONT) {
        $this->index = 0;
        if($distance === 0) {
            $this->reachable = true;
            return;
        }

        $this->onPath = true;
        $initial = true;
        // index in the neighbors array
        foreach($this->to as $to) {
            $this->index += 1;
            if ($currWay == self::FRONT && $initial == true && $this->index != count($this->to)) {
                if ($displayAllNodes == true) {
                    $this->reachable = true;
                }
                $initial = false;
            }
            if ($currWay == self::BACK && $this->index == count($this->to)) {
                if(!$to->getBlocked() && !$to->getPath()) {
                    $to->searchReachable($distance-1, $displayAllNodes, $currWay);
                }
                break;
            }

            if(!$to->getBlocked() && !$to->getPath() && $currWay == self::FRONT && $this->index != count($this->to)) {
                $to->searchReachable($distance-1, $displayAllNodes, $currWay);
            }
            $initial = false;
        }

        $this->onPath = false;
    }

    public function reachableNodes($cardType) {
        if ($cardType == 1) {
            $this->searchReachable(1, false, Node::FRONT);
        }
        else if ($cardType == 2) {
            $this->searchReachable(2, false, Node::FRONT);
        }
        else if ($cardType == 3) {
            $this->searchReachable(3, false, Node::FRONT);
        }
        else if ($cardType == 4) {
            $this->searchReachable(4, false, Node::BACK);
        }
        else if ($cardType == 5) {
            $this->searchReachable(5, false, Node::FRONT);
        }
        else if ($cardType == 7) {
            // need to add functionality for 7 for splitting
            $this->searchReachable(7, true, Node::FRONT);
        }
        else if ($cardType == 8) {
            $this->searchReachable(8, false, Node::FRONT);
        }
        else if ($cardType == 10) {
            $this->searchReachable(10, false, Node::FRONT);
            $this->searchReachable(1, false, Node::BACK);
        }
        else if ($cardType == 11) {
            $this->searchReachable(11, false, Node::FRONT);
        }
        else if ($cardType == 12) {
            $this->searchReachable(12, false, Node::FRONT);
        }
        else if ($cardType == 14) {
            $this->searchReachable(1, false, Node::FRONT);
        }
        else if ($cardType == 15) {
            $this->searchReachable(2, false, Node::FRONT);
        }
        else if ($cardType == 16) {
            $this->searchReachable(3, false, Node::FRONT);
        }
        else if ($cardType == 17) {
            $this->searchReachable(4, false, Node::FRONT);
        }
        else if ($cardType == 18) {
            $this->searchReachable(5, false, Node::FRONT);
        }
        else if ($cardType == 19) {
            $this->searchReachable(6, false, Node::FRONT);
        }
    }

    public function getNeighborNodes() {
        return $this->to;
    }

    public function getPath() {
        return $this->onPath;
    }

    public function getBlocked() {
        return $this->blocked;
    }

    public function isReachable() {
        return $this->reachable;
    }

    public function getXPosition() {
        return $this->xPos;
    }

    public function getYPosition() {
        return $this->yPos;
    }

    public function getPawnColor() {
        return $this->pawnColor;
    }

    public function getLocationType() {
        return $this->locationType;
    }

    public function setPawnColor($pawnColor) {
        $this->pawnColor = $pawnColor;
    }

    public function setLocationType($locationType) {
        $this->locationType = $locationType;
    }

    public function reset() {
        $this->onPath = false;
        $this->blocked = false;
        $this->reachable = false;
    }

    public function setBlocked(){
        $this->blocked = true;
    }

    public function setReachable($reachable) {
        $this->reachable = $reachable;
    }

    /**
     * @return null
     */
    public function getOccupiedPawn()
    {
        return $this->occupiedPawn;
    }

    /**
     * @param null $occupiedPawn
     */
    public function setOccupiedPawn($occupiedPawn)
    {
        $this->occupiedPawn = $occupiedPawn;
    }






    // This node is blocked and cannot be visited
    private $blocked;
    // This node is on a current path
    private $onPath;
    // Node is reachable in the current move
    private $reachable;
    // Pointers to adjacent nodes
    private $to;
    // the pawn color associated to that node
    private $pawnColor;
    // the x position on the board
    private $xPos;
    // the y position on the board
    private $yPos;
    // the type of the location: square, start location, or home
    private $locationType;
    private $occupiedPawn = null;
    private $index;

}