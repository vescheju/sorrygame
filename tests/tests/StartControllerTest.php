<?php


class StartControllerTest extends \PHPUnit\Framework\TestCase{
    public function test_construct() {
        $game = new Game\Game();
        $controller = new Game\StartController($game, array());

        $this->assertInstanceOf('Game\StartController', $controller);
        //$this->assertFalse($controller->isReset());
        //$this->assertEquals('game.php', $controller->getPage());
    }

    public function test_players(){
        $game = new Game\Game();
        $colors = array('Red', 'Blue');
        $controller = new Game\StartController($game, ['color' => $colors]);

        $this->assertEquals(2, $game->getPlayerCount());

        $game = new Game\Game();
        $colors = array();
        $controller = new Game\StartController($game, ['color' => $colors]);
        $this->assertEquals(0, $game->getPlayerCount());

        $game = new Game\Game();
        $colors = array('Red');
        $controller = new Game\StartController($game, ['color' => $colors]);
        $this->assertEquals(1, $game->getPlayerCount());

        $game = new Game\Game();
        $colors = array('Red','Blue','Green');
        $controller = new Game\StartController($game, ['color' => $colors]);
        $this->assertEquals(3, $game->getPlayerCount());

        $game = new Game\Game();
        $colors = array('Red','Blue','Green','Yellow');
        $controller = new Game\StartController($game, ['color' => $colors]);
        $this->assertEquals(4, $game->getPlayerCount());
    }

    public function test_currPage() {
        # 0 colors - should go to index.php
        $game = new Game\Game();
        $colors = array();
        $controller = new Game\StartController($game, ['color' => $colors]);

        $solution = $controller->getCurrPage();
        $expected = 'index.php';
        $this->assertEquals($solution, $expected);

        # 1 color - should go to index.php
        $game = new Game\Game();
        $colors = array('Red');
        $controller = new Game\StartController($game, ['color' => $colors]);

        $solution = $controller->getCurrPage();
        $expected = 'index.php';
        $this->assertEquals($solution, $expected);

        # 2 colors - should go to game.php
        $game = new Game\Game();
        $colors = array('Red', 'Blue');
        $controller = new Game\StartController($game, ['color' => $colors]);

        $solution = $controller->getCurrPage();
        $expected = 'game.php';
        $this->assertEquals($solution, $expected);

        # 3 colors - should go to game.php
        $game = new Game\Game();
        $colors = array('Red', 'Blue', 'Yellow');
        $controller = new Game\StartController($game, ['color' => $colors]);

        $solution = $controller->getCurrPage();
        $expected = 'game.php';
        $this->assertEquals($solution, $expected);

        # 4 colors - should go to game.php
        $game = new Game\Game();
        $colors = array('Red', 'Blue', 'Yellow', 'Green');
        $controller = new Game\StartController($game, ['color' => $colors]);

        $solution = $controller->getCurrPage();
        $expected = 'game.php';
        $this->assertEquals($solution, $expected);

    }

}