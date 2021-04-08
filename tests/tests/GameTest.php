<?php


class GameTest extends \PHPUnit\Framework\TestCase{
    public function test_constructor(){
        $game = new Game\Game();

        $this->assertInstanceOf('Game\Game', $game);

    }

    public function test_player(){
        $game = new Game\Game();

        $this->assertEquals(0, $game->getPlayerCount());

        $game->addPlayer(Game\Game::RED);
        $this->assertEquals(1, $game->getPlayerCount());
        $this->assertCount(1, $game->getPlayers(), "Array has wrong player count");

        $game->addPlayer(Game\Game::YELLOW);
        $this->assertEquals(2, $game->getPlayerCount());
        $this->assertCount(2, $game->getPlayers(), "Array has wrong player count");

        $game->addPlayer(Game\Game::BLUE);
        $this->assertEquals(3, $game->getPlayerCount());
        $this->assertCount(3, $game->getPlayers(), "Array has wrong player count");

        $game->addPlayer(Game\Game::GREEN);
        $this->assertEquals(4, $game->getPlayerCount());
        $this->assertCount(4, $game->getPlayers(), "Array has wrong player count");

        $game->newGame();
        $this->assertEquals(0, $game->getPlayerCount());
    }

    public function test_nodes(){
        $game = new Game\Game();
        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();
        $this->assertCount(16, $game->getNodes(), "The amount of rows in the 2d array is incorrect");
        $this->assertCount(16, $game->getNodes()[0], "The amount of columns in the 2d array is incorrect");

        // Check the node neighbors
        $this->assertCount(2, $game->getNodes()[0][0]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[0][6]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[0][15]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[15][15]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[0][15]->getNeighborNodes());

        // Check for spots that should have 2 paths/the entrance to the safe spots
        $this->assertCount(3, $game->getNodes()[0][2]->getNeighborNodes());
        $this->assertCount(3, $game->getNodes()[2][15]->getNeighborNodes());
        $this->assertCount(3, $game->getNodes()[13][0]->getNeighborNodes());
        $this->assertCount(3, $game->getNodes()[15][13]->getNeighborNodes());


        // check if nodes are blocked
        $this->assertTrue($game->getNodes()[4][5]->getBlocked());
        $this->assertFalse($game->getNodes()[0][0]->getBlocked());
        $this->assertTrue($game->getNodes()[10][7]->getBlocked());

    }
    public function test_yellow(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();

        // Check start nodes for yellow
        $this->assertCount(1, $game->getNodes()[1][3]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[1][5]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[3][3]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[3][5]->getNeighborNodes());

        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[1][3]->getPawnColor());
        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[1][5]->getPawnColor());
        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[3][3]->getPawnColor());
        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[3][5]->getPawnColor());

        $this->assertEquals(Game\Node::START, $game->getNodes()[1][3]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[1][5]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[3][3]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[3][5]->getLocationType());

        //Check a Yellow Safes spot
        $this->assertCount(2, $game->getNodes()[2][2]->getNeighborNodes());
        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[2][2]->getPawnColor());
        $this->assertEquals(Game\Node::SAFE, $game->getNodes()[2][2]->getLocationType());


    }
    public function test_green(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();

        // Check start nodes for green
        $this->assertCount(1, $game->getNodes()[3][12]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[3][14]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[5][12]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[5][14]->getNeighborNodes());

        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[3][12]->getPawnColor());
        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[3][14]->getPawnColor());
        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[5][12]->getPawnColor());
        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[5][14]->getPawnColor());

        $this->assertEquals(Game\Node::START, $game->getNodes()[3][12]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[3][14]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[5][12]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[5][14]->getLocationType());

        //Check a Green Safes spot
        $this->assertCount(2, $game->getNodes()[2][14]->getNeighborNodes());
        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[2][14]->getPawnColor());
        $this->assertEquals(Game\Node::SAFE, $game->getNodes()[2][14]->getLocationType());

    }
    public function test_blue(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();

        // Check start nodes for blue
        $this->assertCount(1, $game->getNodes()[10][1]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[10][3]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[12][1]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[12][3]->getNeighborNodes());

        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[10][1]->getPawnColor());
        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[10][3]->getPawnColor());
        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[12][1]->getPawnColor());
        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[12][3]->getPawnColor());

        $this->assertEquals(Game\Node::START, $game->getNodes()[10][1]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[10][3]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[12][1]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[12][3]->getLocationType());

        //Check a Blue Safes spot
        $this->assertCount(2, $game->getNodes()[13][4]->getNeighborNodes());
        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[13][4]->getPawnColor());
        $this->assertEquals(Game\Node::SAFE, $game->getNodes()[13][4]->getLocationType());

    }
    public function test_red(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();

        // Check start nodes for red
        $this->assertCount(1, $game->getNodes()[12][10]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[12][12]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[14][10]->getNeighborNodes());
        $this->assertCount(1, $game->getNodes()[14][12]->getNeighborNodes());

        $this->assertEquals(Game\Node::RED, $game->getNodes()[12][10]->getPawnColor());
        $this->assertEquals(Game\Node::RED, $game->getNodes()[12][12]->getPawnColor());
        $this->assertEquals(Game\Node::RED, $game->getNodes()[14][10]->getPawnColor());
        $this->assertEquals(Game\Node::RED, $game->getNodes()[14][12]->getPawnColor());

        $this->assertEquals(Game\Node::START, $game->getNodes()[12][10]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[12][12]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[14][10]->getLocationType());
        $this->assertEquals(Game\Node::START, $game->getNodes()[14][12]->getLocationType());

        //Check a Red Safes spot
        $this->assertCount(2, $game->getNodes()[10][13]->getNeighborNodes());
        $this->assertEquals(Game\Node::RED, $game->getNodes()[10][13]->getPawnColor());
        $this->assertEquals(Game\Node::SAFE, $game->getNodes()[10][13]->getLocationType());

    }

    public function test_slides(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();

        // Check the node slides, and if they are properly linked and created
        $this->assertCount(3, $game->getNodes()[0][2]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[0][11]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[3][15]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[10][15]->getNeighborNodes());
        $this->assertCount(3, $game->getNodes()[15][13]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[15][4]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[12][0]->getNeighborNodes());
        $this->assertCount(2, $game->getNodes()[4][0]->getNeighborNodes());

        // Check the slides colors
        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[0][2]->getPawnColor());
        $this->assertEquals(Game\Node::YELLOW, $game->getNodes()[0][11]->getPawnColor());
        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[3][15]->getPawnColor());
        $this->assertEquals(Game\Node::GREEN, $game->getNodes()[10][15]->getPawnColor());
        $this->assertEquals(Game\Node::RED, $game->getNodes()[15][13]->getPawnColor());
        $this->assertEquals(Game\Node::RED, $game->getNodes()[15][4]->getPawnColor());
        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[12][0]->getPawnColor());
        $this->assertEquals(Game\Node::BLUE, $game->getNodes()[4][0]->getPawnColor());

        //Check if it is a big or small slide
        $this->assertEquals(Game\Node::SMALLSLIDE, $game->getNodes()[0][2]->getLocationType());
        $this->assertEquals(Game\Node::BIGSLIDE, $game->getNodes()[0][11]->getLocationType());
        $this->assertEquals(Game\Node::SMALLSLIDE, $game->getNodes()[3][15]->getLocationType());
        $this->assertEquals(Game\Node::BIGSLIDE, $game->getNodes()[10][15]->getLocationType());
        $this->assertEquals(Game\Node::SMALLSLIDE, $game->getNodes()[15][13]->getLocationType());
        $this->assertEquals(Game\Node::BIGSLIDE, $game->getNodes()[15][4]->getLocationType());
        $this->assertEquals(Game\Node::SMALLSLIDE, $game->getNodes()[12][0]->getLocationType());
        $this->assertEquals(Game\Node::BIGSLIDE, $game->getNodes()[4][0]->getLocationType());

    }

    public function test_drawCard(){
        $game = new Game\Game();
        $deck = $game->getCards();

        $this->assertNotEquals(null, $deck);
        $this->assertInstanceOf('Game\Cards', $deck);

        $deckCopy = clone $deck;
        $array = $deckCopy->getCards();

        $game->drawCard();
        $card = $game->getCard();

        $this->assertNotEquals(null, $card);
        $this->assertInstanceOf('Game\Card', $card);

        $cardCopy = new Game\Card(array_pop($array));
        $this->assertEquals($cardCopy, $card);

        $this->assertEquals(1, $game->getCardsDrawn());

        for ($i=2; $i < 45; $i++){
            $game->drawCard();
            $this->assertEquals($i, $game->getCardsDrawn());

            $card = $game->getCard();
            $cardCopy = new Game\Card(array_pop($array));
            $this->assertEquals($cardCopy, $card);
        }

        $game->drawCard();
        $this->assertEquals(0, $game->getCardsDrawn());
    }

    public function test_getCardsDrawn(){
        $game = new Game\Game();
        $this->assertEquals(0, $game->getCardsDrawn());

        for ($i=1; $i < 45; $i++){
            $game->drawCard();
            $this->assertEquals($i, $game->getCardsDrawn());
        }

        $game->drawCard();
        $this->assertEquals(0, $game->getCardsDrawn());
    }

    public function test_getCard(){
        $game = new Game\Game();
        $game->drawCard();
        $card = $game->getCard();

        $this->assertNotEquals(null, $card);
        $this->assertInstanceOf('Game\Card', $card);
    }

    public function test_getCards(){
        $game = new Game\Game();
        $deck = $game->getCards();

        $this->assertNotEquals(null, $deck);
        $this->assertInstanceOf('Game\Cards', $deck);
    }

    public function test_getPlayerTurn(){
        $game = new Game\Game();

        $game->addPlayer(Game\Game::RED);
        $game->addPlayer(Game\Game::YELLOW);
        $game->addPlayer(Game\Game::BLUE);
        $game->addPlayer(Game\Game::GREEN);

        $turn1 = $game->getPlayerTurn();
        $this->assertNotEquals(null, $turn1);

        $game->nextTurn(true);
        $turn2 = $game->getPlayerTurn();
        $this->assertNotEquals(null, $turn2);
        $this->assertNotEquals($turn1, $turn2);

        $game->nextTurn(true);
        $turn3 = $game->getPlayerTurn();
        $this->assertNotEquals(null, $turn3);
        $this->assertNotEquals($turn1, $turn3);
        $this->assertNotEquals($turn2, $turn3);

        $game->nextTurn(true);
        $turn4 = $game->getPlayerTurn();
        $this->assertNotEquals(null, $turn4);
        $this->assertNotEquals($turn1, $turn4);
        $this->assertNotEquals($turn2, $turn4);
        $this->assertNotEquals($turn3, $turn4);

        $game->nextTurn(true);
        $turn5 = $game->getPlayerTurn();
        $this->assertEquals($turn1, $turn5);
    }

    public function test_nextTurn(){
        $game = new Game\Game();

        $game->addPlayer(Game\Game::RED);
        $game->addPlayer(Game\Game::YELLOW);
        $game->addPlayer(Game\Game::BLUE);
        $game->addPlayer(Game\Game::GREEN);

        $turn1 = $game->getPlayerTurn();
        $this->assertNotEquals(null, $turn1);

        $game->nextTurn(true);
        $turn2 = $game->getPlayerTurn();
        $this->assertNotEquals(null, $turn2);
        $this->assertNotEquals($turn1, $turn2);

        $game->nextTurn(false);
        $turn3 = $game->getPlayerTurn();
        $this->assertEquals($turn2, $turn3);
    }

    public function test_GetSetSelected(){
        $game = new Game\Game();

        $player = new Game\Player(0);
        $pawn = new Game\Pawn($player);

        $game->setSelected($pawn);
        $selected = $game->getSelected();

        $this->assertInstanceOf('Game\Pawn', $selected);
        $this->assertEquals($pawn, $selected);
    }

    public function test_bonusFlag(){
        $game = new Game\Game();

        $game->setBonusFlag(false);
        $this->assertEquals(false, $game->isBonusFlag());

        $game->setBonusFlag(true);
        $this->assertEquals(true, $game->isBonusFlag());
    }

    public function test_NewGame(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getCard());
        $this->assertTrue(empty($game->getPlayers()));
        $this->assertEquals(0, $game->getPlayerCount());
        $this->assertEquals(null, $game->getPlayerTurn());
        $this->assertInstanceOf("Game\Cards", $game->getCards());
        $cardArray = $game->getCards()->getCards();
        $this->assertEquals(45, sizeof($cardArray));
        $this->assertEquals(0, $game->getSelected());

        $game->addPlayer(Game\Game::BLUE);
        $game->addPlayer(Game\Game::GREEN);
        $game->drawCard();
        $player = $game->getPlayerTurn();
        $pawn = new Game\Pawn($player);
        $game->setSelected($pawn);


        $this->assertNotEquals(null, $game->getCard());
        $this->assertInstanceOf("Game\Card", $game->getCard());
        $this->assertFalse(empty($game->getPlayers()));
        $this->assertEquals(2, $game->getPlayerCount());
        $this->assertEquals($player, $game->getPlayerTurn());
        $this->assertInstanceOf("Game\Player", $game->getPlayerTurn());
        $this->assertInstanceOf("Game\Cards", $game->getCards());
        $cardArray = $game->getCards()->getCards();
        $this->assertEquals(44, sizeof($cardArray));
        $this->assertEquals($pawn, $game->getSelected());
        $this->assertInstanceOf("Game\Pawn", $game->getSelected());

        $game->newGame();
        $this->assertEquals(null, $game->getCard());
        $this->assertTrue(empty($game->getPlayers()));
        $this->assertEquals(0, $game->getPlayerCount());
        $this->assertEquals(null, $game->getPlayerTurn());
        $this->assertInstanceOf("Game\Cards", $game->getCards());
        $cardArray = $game->getCards()->getCards();
        $this->assertEquals(45, sizeof($cardArray));
        $this->assertEquals(0, $game->getSelected());
    }
    public function test_slideMovement(){
        $game = new Game\Game();

        $this->assertEquals(null, $game->getNodes());

        // Make sure that sure we have a 16x16 array
        $game->ConstructNodes();
        $player1 = new Game\Player(Game\Game::RED);
        $player2 = new Game\Player(Game\Game::GREEN);
        $player3 = new Game\Player(Game\Game::BLUE);
        $player4 = new Game\Player(Game\Game::YELLOW);
        // Check small blue slide
        $pawn1 = $player1->getPawns()[0];
        $game->setSelected($pawn1);
        $pawn1->setPosition(14,0);
        $game->setPlayerTurn($player1);
        $array = array(11, 0);

        $this->assertEquals($array, $game->slideHandle(Game\Node::SMALLSLIDE,14 ,0));

        // Check large blue slide
        $pawn1 = $player1->getPawns()[0];
        $game->setSelected($pawn1);
        $pawn1->setPosition(6,0);
        $game->setPlayerTurn($player1);
        $array = array(2, 0);


        $this->assertEquals($array, $game->slideHandle(Game\Node::BIGSLIDE,6 ,0));

        // Ensure the same colors cannot use their slides.
        $pawn1 = $player3->getPawns()[0];
        $game->setSelected($pawn1);
        $pawn1->setPosition(6,0);
        $game->setPlayerTurn($player3);
        $array = array();

        $this->assertEquals($array, $game->slideHandle(Game\Node::BIGSLIDE,6 ,0));

    }

    /*
    public function test_interact(){
        $game = new Game\Game();

        $game->ConstructNodes();

        //$game->addPlayer(Game\Game::BLUE);
        //$game->addPlayer(Game\Game::GREEN);
        //$game->addPlayer(Game\Game::YELLOW);


        for ($i=1; $i < 45; $i++){
            $game->drawCard();

            $card = $game->getCard();

            if ($card->getCardType() == 2){
                $game->addPlayer(Game\Game::RED);
                $pawn1 =$game->getPlayerTurn()->getPawns()[0];
                $pawn1->setPosition(14,10);
                $game->setSelected($pawn1);
                $game->interact('14, 10');
                $this->assertEquals($pawn1, $game->getSelected());

                $nodes = $game->getNodes();
                $node = $nodes[15][11];
                $this->assertTrue($node->isReachable());
            }

        }

    }
    */

}
