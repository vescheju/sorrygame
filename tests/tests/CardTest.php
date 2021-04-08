<?php

class CardTest extends \PHPUnit\Framework\TestCase {

    public function test_constructor()
    {
        $game = new Game\Game();
        $cards = new Game\Cards($game);
        $this->assertInstanceOf('Game\Cards', $cards);

        $card = new Game\Card(5);
        $this->assertInstanceOf('Game\Card', $card);

        $this->assertEquals(5, $card->getCardType());
    }

    public function test_drawn(){
        $game = new Game\Game();
        $cards = new Game\Cards($game);

        $this->assertCount(45, $cards->getCards());

        $this->assertEquals(45, $cards->getNumCardsRemaining());

        for ( $i = 0; $i < 45; $i++){
            $card = $cards->draw();
            $this->assertInstanceOf('Game\Card', $card);
        }
        // ensure 45 cards in the deck
        $this->assertTrue($cards->isEmpty());
    }


}
