<?php


class PawnTest extends \PHPUnit\Framework\TestCase{
    public function test_constructor(){

        $player = new Game\Player(Game\Game::RED);
        $pawn = new Game\Pawn($player);

        $this->assertInstanceOf('Game\Pawn', $pawn);
    }

    public function test_SetPosition(){
        $player = new Game\Player(Game\Game::RED);
        $pawn = new Game\Pawn($player);
        $pawn->SetPosition(1,2);
        $this->assertEquals(1, $pawn->getXLocation());
        $this->assertEquals(2, $pawn->getYLocation());
        $pawn->SetPosition(0,0);
        $this->assertEquals(0, $pawn->getXLocation());
        $this->assertEquals(0, $pawn->getYLocation());
    }



}