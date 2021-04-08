<?php


class StartViewTest  extends \PHPUnit\Framework\TestCase {
    public function test_construct(){
        $game = new Game\Game();
        $startView = new Game\StartView($game);
        $this->assertInstanceOf('Game\StartView', $startView);
    }
    public function test_Start(){
        $game = new Game\Game();
        $startView = new Game\StartView($game);
        $solution = $startView->choose();

        $expected = '<form method="post" action="start-post.php">';
        $this->assertContains($expected, $solution, "Not proper form type");

        $expected .= <<< HTML
<fieldset>
<h1>Welcome to Sorry!</h1>
HTML;
        $this->assertContains($expected, $solution, "header not displayed properly");

        $expected = '<p class="checkColor"><input type="checkbox" name="color[]" value="Red">
<label for="Red"> Red</label><br>';
        $this->assertContains($expected, $solution, "Red not displayed properly");

        $expected = '<input type="checkbox" name="color[]" value="Green">
<label for="Green"> Green</label><br>';
        $this->assertContains($expected, $solution, "Green not displayed properly");

        $expected = '<input type="checkbox" name="color[]" value="Blue">
<label for="Blue"> Blue</label><br>';
        $this->assertContains($expected, $solution, "Blue not displayed properly");

        $expected = '<input type="checkbox" name="color[]" value="Yellow">
<label for="Yellow"> Yellow</label><br></p>';
        $this->assertContains($expected, $solution, "Yellow not displayed properly");

        $expected = '<p class="startChoice">Select at least 2 players to play the game.</p>';
        $this->assertContains($expected, $solution, "Number of Players not displayed properly");

        $expected = '<p class="submit"><input type="submit" name="clear"></p>';
        $this->assertContains($expected, $solution, "Submit button not displayed properly");

        $expected = '<nav><p><a href="instructions.php">Instructions</a></p></nav>';
        $this->assertContains($expected, $solution, "Instructions page navigation not displayed properly");
    }

    public function test_numPlayers() {
        # 0 players - should display error
        $game = new Game\Game();
        $startView = new Game\StartView($game);

        $solution = $startView->choose();
        $this->assertContains('Error! You have not selected enough players. You must select at least two players to play', $solution, "Not enough players");

        # one player - should display error
        $game1 = new Game\Game();
        $game1->addPlayer(Game\Game::RED);
        $startView = new Game\StartView($game1);

        $solution1 = $startView->choose();
        $this->assertContains('Error! You have not selected enough players. You must select at least two players to play', $solution1, "Not enough players");

        # two players - should not display error
        $game2 = new Game\Game();
        $game2->addPlayer(Game\Game::RED);
        $game2->addPlayer(Game\Game::BLUE);
        $startView = new Game\StartView($game2);

        $solution2 = $startView->choose();
        $expected = '<p>Error! You have not selected enough players. You must select at least two players to play</p>';
        $this->assertNotContains($expected, $solution2, "Enough players");

        # three players - should not display error
        $game3 = new Game\Game();
        $game3->addPlayer(Game\Game::RED);
        $game3->addPlayer(Game\Game::BLUE);
        $game3->addPlayer(Game\Game::GREEN);
        $startView = new Game\StartView($game3);

        $solution3 = $startView->choose();
        $expected = '<p>Error! You have not selected enough players. You must select at least two players to play</p>';
        $this->assertNotContains($expected, $solution3, "Enough players");

        # four players - should not display error
        $game4 = new Game\Game();
        $game4->addPlayer(Game\Game::RED);
        $game4->addPlayer(Game\Game::BLUE);
        $game4->addPlayer(Game\Game::GREEN);
        $game4->addPlayer(Game\Game::YELLOW);
        $startView = new Game\StartView($game4);

        $solution4 = $startView->choose();
        $expected = '<p>Error! You have not selected enough players. You must select at least two players to play</p>';
        $this->assertNotContains($expected, $solution4, "Enough players");
    }
}