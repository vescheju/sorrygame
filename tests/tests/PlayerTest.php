<?php


class PlayerTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct(){
        $color = Game\Game::RED;

        $player = new Game\Player($color);
        $this->assertInstanceOf('Game\Player', $player);

    }

    public function test_pawns(){
        $color = Game\Game::RED;
        $player = new Game\Player($color);

        $pawns = $player->getPawns();
        $pawn1 = new Game\Pawn($player);
        $pawn1->SetPosition(12, 10);
        $pawn2 = new Game\Pawn($player);
        $pawn2->SetPosition(12, 12);
        $pawn3 = new Game\Pawn($player);
        $pawn3->SetPosition(14, 10);
        $pawn4 = new Game\Pawn($player);
        $pawn4->SetPosition(14, 12);

        $this->assertEquals($pawn1, $pawns[0]);
        $this->assertEquals($pawn2, $pawns[1]);
        $this->assertEquals($pawn3, $pawns[2]);
        $this->assertEquals($pawn4, $pawns[3]);

        $color = Game\Game::GREEN;
        $player = new Game\Player($color);

        $pawns = $player->getPawns();
        $pawn1 = new Game\Pawn($player);
        $pawn1->SetPosition(3, 12);
        $pawn2 = new Game\Pawn($player);
        $pawn2->SetPosition(5, 12);
        $pawn3 = new Game\Pawn($player);
        $pawn3->SetPosition(3, 14);
        $pawn4 = new Game\Pawn($player);
        $pawn4->SetPosition(5, 14);

        $this->assertEquals($pawn1, $pawns[0]);
        $this->assertEquals($pawn2, $pawns[1]);
        $this->assertEquals($pawn3, $pawns[2]);
        $this->assertEquals($pawn4, $pawns[3]);

        $color = Game\Game::BLUE;
        $player = new Game\Player($color);

        $pawns = $player->getPawns();
        $pawn1 = new Game\Pawn($player);
        $pawn1->SetPosition(10, 1);
        $pawn2 = new Game\Pawn($player);
        $pawn2->SetPosition(10, 3);
        $pawn3 = new Game\Pawn($player);
        $pawn3->SetPosition(12, 1);
        $pawn4 = new Game\Pawn($player);
        $pawn4->SetPosition(12, 3);

        $this->assertEquals($pawn1, $pawns[0]);
        $this->assertEquals($pawn2, $pawns[1]);
        $this->assertEquals($pawn3, $pawns[2]);
        $this->assertEquals($pawn4, $pawns[3]);

        $color = Game\Game::YELLOW;
        $player = new Game\Player($color);

        $pawns = $player->getPawns();
        $pawn1 = new Game\Pawn($player);
        $pawn1->SetPosition(1, 3);
        $pawn2 = new Game\Pawn($player);
        $pawn2->SetPosition(1, 5);
        $pawn3 = new Game\Pawn($player);
        $pawn3->SetPosition(3, 3);
        $pawn4 = new Game\Pawn($player);
        $pawn4->SetPosition(3, 5);

        $this->assertEquals($pawn1, $pawns[0]);
        $this->assertEquals($pawn2, $pawns[1]);
        $this->assertEquals($pawn3, $pawns[2]);
        $this->assertEquals($pawn4, $pawns[3]);

    }

    public function test_getColor(){
        $color = Game\Game::RED;
        $player = new Game\Player($color);
        $this->assertEquals($color,$player->getColor());

        $color = Game\Game::GREEN;
        $player = new Game\Player($color);
        $this->assertEquals($color,$player->getColor());

        $color = Game\Game::BLUE;
        $player = new Game\Player($color);
        $this->assertEquals($color,$player->getColor());

        $color = Game\Game::YELLOW;
        $player = new Game\Player($color);
        $this->assertEquals($color,$player->getColor());
    }

    public function test_getSetSpawnLocation(){
        $color = Game\Game::RED;
        $player = new Game\Player($color);

        $node = new Game\Node(0,0);
        $player->setSpawnLocation($node);
        $this->assertEquals($node, $player->getSpawnLocation());
    }

    public function test_pawnCount(){
        $color = Game\Game::RED;
        $player = new Game\Player($color);

        $this->assertEquals(4, $player->getPawnCount());

        $player->decreasePawnCount();
        $this->assertEquals(3, $player->getPawnCount());

        $player->setPawnCount(10);
        $this->assertEquals(10, $player->getPawnCount());
    }

}