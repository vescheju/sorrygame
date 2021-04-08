<?php

use Game\Node as Node;
use Game\Game as Game;

class NodeTest extends \PHPUnit\Framework\TestCase {
    public function test_constructor() {
        $node = new Node(1 , 2);
        $this->assertEquals(false, $node->getBlocked());
        $this->assertEquals(false, $node->isReachable());
        $this->assertEquals(false, $node->getPath());
        $this->assertEquals(1, $node->getXPosition());
        $this->assertEquals(2, $node->getYPosition());
        $this->assertEquals(Node::NO_COLOR, $node->getPawnColor());
        $this->assertEquals(Node::SQUARE, $node->getLocationType());

        $node1 = new Node(2, 3, Node::BLUE, Node::HOME);
        $this->assertEquals(2, $node1->getXPosition());
        $this->assertEquals(3, $node1->getYPosition());
        $this->assertEquals(Node::BLUE, $node1->getPawnColor());
        $this->assertEquals(Node::HOME, $node1->getLocationType());

        $node2 = new Node(11, 12, Node::RED, Node::SAFE);
        $this->assertEquals(11, $node2->getXPosition());
        $this->assertEquals(12, $node2->getYPosition());
        $this->assertEquals(Node::RED, $node2->getPawnColor());
        $this->assertEquals(Node::SAFE, $node2->getLocationType());

        $node3 = new Node(10, 12, Node::YELLOW, Node::START);
        $this->assertEquals(Node::YELLOW, $node3->getPawnColor());
        $this->assertEquals(Node::START, $node3->getLocationType());

        $node4 = new Node(10, 12, Node::GREEN, Node::NO_COLOR);
        $this->assertEquals(Node::GREEN, $node4->getPawnColor());
        $this->assertEquals(Node::NO_COLOR, $node4->getLocationType());
    }
    public function test_addto() {
        $node = new Node(1, 2);
        $adjNode = new Node(2, 3);
        $node->addTo($adjNode);
        $this->assertContains($adjNode, $node->getNeighborNodes(), "Node after is not there");

        $node2 = new Node(4, 5);
        $node->addTo($node2);
        $this->assertContains($adjNode, $node->getNeighborNodes(), "Node after is not there");
        $this->assertContains($node2, $node->getNeighborNodes(), "Node after is not there");
    }

    public function test_reachableNodes() {
        $game = new Game();
        $game->ConstructNodes();

        // testing card type of 1
        $node = $game->getNodes()[0][0];
        $node->reachableNodes(1);
        $this->assertEquals(true, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[1][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $game->resetReachable();

        // testing card type of 2
        $node->reachableNodes(2);
        $this->assertEquals(true, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[1][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[2][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();

        // testing card type of 3
        $node->reachableNodes(3);
        $this->assertEquals(true, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();

        // testing card type of 4
        $node->reachableNodes(4);
        $this->assertEquals(false, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(true, $game->getNodes()[4][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[3][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[2][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[1][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();

        // testing card type of 5
        $node->reachableNodes(5);
        $this->assertEquals(true, $game->getNodes()[0][5]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[5][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();

        // testing card type of 7
        $node->reachableNodes(7);
        $this->assertEquals(true, $game->getNodes()[0][7]->isReachable());
        $this->assertEquals(true, $game->getNodes()[0][6]->isReachable());
        $this->assertEquals(true, $game->getNodes()[0][5]->isReachable());
        $this->assertEquals(true, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(true, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(true, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(true, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][8]->isReachable());
        $this->assertEquals(false, $game->getNodes()[1][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[2][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[3][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[4][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[5][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[6][0]->isReachable());
        $this->assertEquals(false, $game->getNodes()[7][0]->isReachable());
        $game->resetReachable();

        // testing card type of 8
        $node->reachableNodes(8);
        $this->assertEquals(true, $game->getNodes()[0][8]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][7]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][6]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][5]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();

        // testing card type of 10
        $node->reachableNodes(10);
        $this->assertEquals(true, $game->getNodes()[0][10]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][9]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][8]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][7]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][6]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][5]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $this->assertEquals(true, $game->getNodes()[1][0]->isReachable());
        $game->resetReachable();

        // testing card type of 11
        $node->reachableNodes(11);
        $this->assertEquals(true, $game->getNodes()[0][11]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][10]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][9]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][8]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][7]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][6]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][5]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();

        // testing card type of 12
        $node->reachableNodes(12);
        $this->assertEquals(true, $game->getNodes()[0][12]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][11]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][10]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][9]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][8]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][7]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][6]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][5]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][4]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][3]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][2]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][1]->isReachable());
        $this->assertEquals(false, $game->getNodes()[0][0]->isReachable());
        $game->resetReachable();
    }

    public function test_pawnColor() {
        $node = new Node(1, 2);
        $this->assertEquals(Node::NO_COLOR, $node->getPawnColor());

        $node->setPawnColor(Node::GREEN);
        $this->assertEquals(Node::GREEN, $node->getPawnColor());

        $node->setPawnColor(Node::YELLOW);
        $this->assertEquals(Node::YELLOW, $node->getPawnColor());

        $node->setPawnColor(Node::BLUE);
        $this->assertEquals(Node::BLUE, $node->getPawnColor());

        $node->setPawnColor(Node::RED);
        $this->assertEquals(Node::RED, $node->getPawnColor());
    }

    public function test_locationType() {
        $node = new Node(1, 2);
        $this->assertEquals(Node::SQUARE, $node->getLocationType());

        $node->setLocationType(Node::HOME);
        $this->assertEquals(Node::HOME, $node->getLocationType());

        $node->setLocationType(Node::SAFE);
        $this->assertEquals(Node::SAFE, $node->getLocationType());

        $node->setLocationType(Node::START);
        $this->assertEquals(Node::START, $node->getLocationType());

        $node->setLocationType(Node::SQUARE);
        $this->assertEquals(Node::SQUARE, $node->getLocationType());
    }

    public function test_reachable() {
        $node = new Node(1, 2);
        $this->assertEquals(false, $node->isReachable());

        $node->setReachable(true);
        $this->assertEquals(true, $node->isReachable());
    }

    public function test_blocked() {
        $node = new Node(1, 2);
        $this->assertEquals(false, $node->getBlocked());

        $node->setBlocked();
        $this->assertEquals(true, $node->getBlocked());
    }

    public function test_occupiedPawn() {
        $node = new Node(1, 2);
        $this->assertNull($node->getOccupiedPawn());

        $node->setOccupiedPawn(1);
        $this->assertNotNull($node->getOccupiedPawn());
    }

    public function test_reset() {
        $node = new Node(1, 2);
        $this->assertEquals(false, $node->getBlocked());
        $this->assertEquals(false, $node->isReachable());

        $node->setReachable(true);
        $node->setBlocked();
        $this->assertEquals(true, $node->getBlocked());
        $this->assertEquals(true, $node->isReachable());

        $node->reset();
        $this->assertEquals(false, $node->getBlocked());
        $this->assertEquals(false, $node->isReachable());
    }
}