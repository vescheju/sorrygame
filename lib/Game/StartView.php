<?php


namespace Game;


class StartView
{
    /** Constructor
     * @param Game $currGame start menu object
     */
    public function __construct(Game $currGame){
        $this->game = $currGame;
    }

    public function choose(){
        $html = '<form method="post" action="start-post.php">';

        $html .= <<< HTML
<fieldset>
<h1>Welcome to Sorry!</h1>
<p class="checkColor"><input type="checkbox" name="color[]" value="Red">
<label for="Red"> Red</label><br>
<input type="checkbox" name="color[]" value="Green">
<label for="Green"> Green</label><br>
<input type="checkbox" name="color[]" value="Blue">
<label for="Blue"> Blue</label><br>
<input type="checkbox" name="color[]" value="Yellow">
<label for="Yellow"> Yellow</label><br></p>

<p class="startChoice">Select at least 2 players to play the game.</p>
<p class="submit"><input type="submit" name="clear"></p>
<nav><p><a href="instructions.php">Instructions</a></p></nav>
</fieldset>
</form>

HTML;

        if($this->game->getPlayerCount() < 2) {
            $html .= '<p>Error! You have not selected enough players. You must select at least two players to play.</p>';
        }

        return $html;

    }

    private $game;
}