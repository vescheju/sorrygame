<?php

namespace Game;

class Cards
{
    /*
     * create an array of numbers for tracking what card types are left
     */
    public function __construct(Game $game){
        $this->cards = array();

        $this->createDeck();

    }

    private function createDeck(){
        // "there are five 1 cards as well as four each of the other cards."
        for ($i = 0; $i < 5; $i++){
            $this->cards[] = 1;
        }
        for ($i = 0; $i < 4; $i++){
            for ($j = 2; $j <= 13; $j++){
                // "The 6s or 9s are omitted to avoid confusion with each other."
                if ($j == 6 || $j == 9) continue;
                $this->cards[] = $j;
            }
        }

        shuffle($this->cards); // shuffle the deck

    }

    /*
     * pop the last element from shuffled card array to get a card number
     * then create a card class for return
     */
    public function draw(){
        // echo '<script>alert("A card has been drawn!")</script>';
        if (empty($this->cards)) $this->createDeck();
        return new Card(array_pop($this->cards));
    }

    public function getCards(){
        return $this->cards;
    }

    public function getNumCardsRemaining()
    {
        return count($this->cards);
    }


    public function isEmpty(){
        return empty($this->cards);
    }

    private $cards;
}