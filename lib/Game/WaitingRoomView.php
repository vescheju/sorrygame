<?php


namespace Game;


class WaitingRoomView extends View
{
    /** Constructor
     * @param Game $currGame start menu object
     */
    public function __construct(Game $currGame){
        $this->game = $currGame;
        $this->setTitle("Waiting Room");
        $this->addLink("instructions.php", "Instructions");
    }

    private $game;
}