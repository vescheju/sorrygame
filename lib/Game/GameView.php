<?php


namespace Game;



class GameView extends View{
    public function __construct(Game $game) {
        $this->game = $game;
        $this->game->updateGame();
    }
    /**
     * Create the HTML for the board grid
     * @return string HTML for the grid
     */
    public function grid(){
        $location = "";
        if ($this->whoTurn == $this->game->getUsersColor()){
            $location = "game-post.php";
        }

        $html = '<nav><p class="navigation"><a href="instructions.php">Instructions</a></p></nav>';

        $html .= '<div class="gameForm">';
        $html .= '<form method="post" action="game-post.php">';
        $html .= '<div class="game">';
        $html .= '<div class="board">';
        for ($i = 0; $i < 16; $i++) {
            $html .= '<div class="row">';
            for ($j = 0; $j < 16; $j++) {

                $html .= '<div class="cell">';

                if (($j < 5 || $j > 10 ) || ($i < 5 || $i > 8)) {
                    if ( !($i == 10 && $j == 7) && !($i == 10 && $j == 8)) {
                        $html .= "<button type='submit' name='cell' value='$i, $j'";
                        if ($this->game->getNodes()[$i][$j]->isReachable()) {
                            $html .= ' style= "border: 8px solid orange;"';
                        }
                        $html.=">";

                    }
                }

                for ($k = 0; $k < $this->game->getPlayerCount(); $k++) {
                    $html .= $this->PlacePiece($this->game->getPlayers()[$k], $i, $j);
                }

                //if ($this->game->getNodes()[$i][$j]->isReachable()) {
                  //  $html .= '<img class="player_piece" src="images/yellow_square.jpg" width=100% height=100%>';
                //}
                if (($j < 5 || $j > 10 ) || ($i < 5 || $i > 9)) {
                    if ( !($i == 10 && $j == 7) && !($i == 10 && $j == 8)) {

                        $html .= "</button>";
                    }
                }

                $html .= '</div>';
            }

            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '<input  type="image" class = "cards" src="images/card_back.png" name = "card" value="card">';
        if ($this->game->getCard() != null) {
            $src = $this->game->getCard()->getImageSource();
            $html .= '<img id = "current_card" src ="' . $src . '">';
        }
        $html .= "<button type='submit' name='done' value='DONE'>DONE";
        $html .= '</div>';
        $html .= '</form>';
        $html .= '</div>';
        return $html;
    }

    private function PlacePiece($player,$x, $y){
        $html = '';
        for($i = 0; $i < 4; $i++){
            $pawn = $player->getPawns()[$i];

            if ($pawn->getXLocation() == $x && $pawn->getYLocation() == $y){
                if($player->getColor() == game::BLUE) {
                    $html = '<img class="player-piece" src="images/blue.png" width=100% height=100%>';
                }elseif($player->getColor() == game::GREEN){
                    $html = '<img class="player-piece" src="images/green.png" width=100% height=100%>';
                }elseif($player->getColor() == game::YELLOW){
                    $html = '<img class="player-piece" src="images/yellow.png" width=100% height=100%>';
                }elseif($player->getColor() == game::RED){
                    $html = '<img class="player-piece" src="images/red.png" width=100% height=100%>';
                }
            }
        }
        return $html;
    }

    public function displayPlayer($turn){
        $color = $this->game->getUsersColor();
        $turn = $this->game->dataTurnColor();

        $this->whoTurn = $turn;
        if ($turn == Game::RED) $turn = "RED";
        else if ($turn == Game::GREEN) $turn = "GREEN";
        else if ($turn == Game::BLUE) $turn = "BLUE";
        else if ($turn == Game::YELLOW) $turn = "YELLOW";
        if ($color == Game::RED) $color = "RED";
        else if ($color == Game::GREEN) $color = "GREEN";
        else if ($color == Game::BLUE) $color = "BLUE";
        else if ($color == Game::YELLOW) $color = "YELLOW";



        $html = "<div id='playerTurn'>";
        $html .= "<p>You are Player: $color</p>";


        $html .= "<p>It is player: </p>";
        if ($turn == "GREEN"){
            $html .= "<p class='turn' id='greenTurn'>$turn</p>";
        }
        elseif($turn == "RED"){
            $html .= "<p class='turn' id='redTurn'>$turn</p>";
        }
        elseif($turn == "BLUE"){
            $html .= "<p class='turn' id='blueTurn'>$turn</p>";
        }
        elseif($turn == "YELLOW"){
            $html .= "<p class='turn' id='yellowTurn'>$turn</p>";
        }
        $html .= "<p>turn.</p>";
        $html .= "</div>";
        return $html;
    }

    public function gameState(){
        $html = '';
        $state = strval($this->game->getGameState());
        $html .= "<div class='gameinfo'>";
        if ($state == "4"){
            $this->game->setPlayerToDisplay($this->game->getPlayerTurn()->getColor());
            $html .= $this->displayPlayer($this->game->getPlayerToDisplay());
            if ($this->game->isBonusFlag()){
                $html .= "*This is a bonus draw!* <br>";
            }
            $html .= "Please draw a card!";
        } else if ($state == "5") {
            $html .= $this->displayPlayer($this->game->getPlayerToDisplay());
            $card = $this->game->getCard()->getCardType();
            if ($card < 14) {
                if ($card == Card::SORRY){
                    $card ='SORRY';
                }
                $html .= "<p class = 'state5'>You drew card $card.</p>";
            }
            if ($card == 1 || $card == 2)$html .= "<p class ='state5' id = 'instruction'>With this card, you can move a pawn from the START area.</p>";
            if ($card == 2) $html .= "<p class='state5'>*You also get to draw again after this turn!*</p>";
            if ($card == 11){
                $html .= "<p class = 'state5' id = 'instruction'>With this card, you have the option to skip your turn by clicking *DONE*.</p>";
            }
            if ($card == 14) $html .= "<p class ='state5'>*You chose to split, so you get to move a pawn 1 space forward!*</p>";
            if ($card == 15) $html .= "<p class ='state5'>*You chose to split, so you get to move a pawn 2 spaces forward!*</p>";
            if ($card == 16) $html .= "<p class ='state5'>*You chose to split, so you get to move a pawn 3 spaces forward!*</p>";
            if ($card == 17) $html .= "<p class ='state5'>*You chose to split, so you get to move a pawn 4 spaces forward!*</p>";
            if ($card == 18) $html .= "<p class ='state5'>*You chose to split, so you get to move a pawn 5 spaces forward!*</p>";
            if ($card == 19) $html .= "<p class ='state5'>*You chose to split, so you get to move a pawn 6 spaces forward!*</p>";
            if (!$this->game->getSelected()) $html .= "<p class='state5'>Please select the pawn you want to move!</p>";
            else{
                $html .= "<p class='state5'>Please move your pawn!</p>";
            }

        } else if ($state == "6"){
            $html .= $this->displayPlayer($this->game->getPlayerToDisplay());
            if ($this->game->getInHomeFlag()){
                $html .= "<p>Card 1 or Card 2 is needed to move a pawn from START.</p>";
            }
            $html .= "You have finished your turn, please click *DONE* to continue.";
        }



        $html .= "</div>";
        return $html;
    }

    private $whoTurn;
    private $game;

}