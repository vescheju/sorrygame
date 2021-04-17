<?php


namespace Game;


class WaitingRoomView extends View
{
    /** Constructor
     * @param Game $currGame game object that the players are in
     * @param Site $site site object
     */
    public function __construct(Game $currGame, Site $site){
        $this->game = $currGame;
        $this->site = $site;
        $this->setTitle("Waiting Room");
        $this->addLink("instructions.php", "Instructions");
    }

    public function present() {
        $html = <<<HTML
<form class="table" method="post" action="">
    <p>
        <input type="submit" name="start_game" id="start_game" value="Start Game">
        <input type="submit" name="leave_game" id="leave_game" value="Leave Game">
    </p>
    
    <table>
        <tr>
            <th>Name</th>
        </tr>
    </table>
</form>
HTML;

        return $html;

    }

    private $game;
    private $site;
}