<?php


namespace Game;


class Card
{
    const SORRY = 13;

    public function __construct($type){
        $this->cardType = $type;
        $this->setImageSource();
    }

    private function setImageSource(){
        if ($this->cardType <= 12){
            $this->imageSource = "images/card_" . $this->cardType . ".png";
        }
        else if ($this->cardType >= 14) {
            $this->imageSource = "images/card_7.png";
        }
        else{
            $this->imageSource = "images/card_sorry.png";
        }
    }

    public function getImageSource(){
        return $this->imageSource;
    }

    /**
     * @return mixed
     */
    public function getCardType(){
        return $this->cardType;
    }


    //1. Move 1 / spawn
    //2. Move 2 / spawn => move two? => draw again
    //3. Move 3
    //4. Move -4
    //5. Move 5
    //6. N / A
    //7. Split into 2 pawns => move total 7? => ok
    //8. Move 8
    //9. N / A
    //10. Move 10 or one back
    //11. Move 11 or switch place with other pawn
    //12. Move 12
    //13. Sorry!


    private $cardType;
    private $imageSource;
}