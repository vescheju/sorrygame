<?php


namespace Game;


class Game
{
    const RED = 0;
    const GREEN = 1;
    const BLUE = 2;
    const YELLOW = 3;

    const DRAWCARD = 4; // wait for player to draw card
    const ACTION = 5; // wait for player's action
    const DONE = 6; // wait for player to click done button
    const GAMEOVER = 7; //Game is over

    public function __construct(){
        $this->cards = new Cards($this);
        $this->gameState = self::DRAWCARD;
    }

    public function addPlayer($color, $turn_bool, $site, $user){
        $player = new Player($color, $site, $user);
        $this->players[] = $player;
        if($turn_bool == true){
            $this->playerTurn = $player;
        }
    }
    public function resetPlayers(){
        $this->players = array();
    }


    /**
     * @return int
     */
    public function getPlayerCount(){
        return $this->playerCount;
    }

    public function getPlayers(){
        return $this->players;
    }

    // Update this function so the game can be reset upon each new game
    public function newGame(Site $site, $game_id, $user){
        $this->site = $site;
        $this->game_id=$game_id;

        $gamesTable = new GamesTable($site);
        $gameTable = $gamesTable->get($this->game_id);

        $this->gameState = self::DRAWCARD;

        $this->playerToDisplay = $gamesTable->getDisplayPlayer($gameTable);

        $this->cards = new Cards($this);
        $this->cards->setCardsArray($gameTable->getCards());
        $this->playerTableIds = $gameTable->getPlayerIds();
        $this->playerCount = count($this->playerTableIds);
        $this->card = null;
        $this->nodes = $gameTable->getOccupied();
        $this->ConstructNodes();
        $this->playerNumberTurn = 0;
        $this->selected = null;
        $this->game_won = null;


        $gamesTable->setStarted($gameTable, 1);
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getUsersColor()
    {
        $player = new PlayerTable($this->site);
        $currPlayer = $player->getPlayerById($this->user->getId());
        return $currPlayer->getColor();

    }



    public function updateGame(){
        $gamesTable = new GamesTable($this->site);
        $gameTable = $gamesTable->get($this->game_id);

        $card_array = $gameTable->getCards();
        $this->cards->setCardsArray($card_array);

        $this->playerToDisplay=$gamesTable->getDisplayPlayer($gameTable);
        $playerTurn = $gamesTable->getPlayerTurn($this->game_id);
        $this->currentPlayerId= $playerTurn->getId();

        if ($playerTurn != null) {
            $playerTurnColor = $playerTurn->getColor();
            foreach ($this->players as $player) {
                if ($playerTurnColor == $player->getColor()) {
                    $this->playerTurn = $player;
                }
            }
        }

        $this->card = $gameTable->getCardDrawn();

        foreach ($this->players as $player){
            $player_row = $gamesTable->getPlayer($gameTable, $player->getColor());
            $pawn_locations = $player_row->getPawns();
            $pawns = $player->getPawns();
            $new_pawns = array();
            for ($i=0; $i <count($pawns);$i++){
                $location = $pawn_locations[$i];
                $pawn = $pawns[$i];
                $pawn->SetPosition($location[0], $location[1]);
                $this->setOccupiedNode($pawn);
                $new_pawns[]=$pawn;
            }
            $player->setPawns($new_pawns);
        }

    }

    public function setOccupiedNode(Pawn $pawn){
        ($this->nodes[$pawn->getXLocation()][$pawn->getYLocation()])->setOccupiedPawn($pawn);
    }

    public function updateDB($nextPlayer){
        $gamesTable = new GamesTable($this->site);
        $gameTable = $gamesTable->get($this->game_id);

        $cards_array = $this->cards->getCards();
        $gamesTable->setCards($gameTable, $cards_array);

        if($nextPlayer) {

            //$gamesTable->setPlayerTurn($gameTable, $this->playerTurn->getColor());
        }
        $gamesTable->setCardDrawn($gameTable, $this->card);

        $playersTable = new PlayerTable($this->site);
        foreach ($this->players as $player){
            $player_row = $gamesTable->getPlayer($gameTable, $player->getColor());
            $pawns = $player->getPawns();
            $playersTable->SetPawns($player_row->getId(), $pawns);
        }
        $gamesTable->setDisplayPlayer($gameTable, $this->playerToDisplay);
    }

    public function ConstructNodes(){
        // construct all of the nodes
        for($i = 0; $i < 16; $i++) {
            $nodeRow = array();
            for($j = 0; $j < 16; $j++) {
                if($i == 0 && $j > 0 && $j < 5){ // Start of slides
                    $node = new Node($i, $j, Node::YELLOW, Node::SMALLSLIDE);
                    $nodeRow[] = $node;
                }elseif($i == 0 && $j > 8 && $j < 14){
                    $node = new Node($i, $j, Node::YELLOW, Node::BIGSLIDE);
                    $nodeRow[] = $node;
                }elseif($j == 15 && $i > 0 && $i < 5){
                    $node = new Node($i, $j, Node::GREEN, Node::SMALLSLIDE);
                    $nodeRow[] = $node;
                }elseif($j == 15 && $i > 8 && $i < 14){
                    $node = new Node($i, $j, Node::GREEN, Node::BIGSLIDE);
                    $nodeRow[] = $node;
                }elseif($i == 15 && $j > 10 && $j < 15){
                    $node = new Node($i, $j, Node::RED, Node::SMALLSLIDE);
                    $nodeRow[] = $node;
                }elseif($i == 15 && $j > 1 && $j < 7){
                    $node = new Node($i, $j, Node::RED, Node::BIGSLIDE);
                    $nodeRow[] = $node;
                }elseif($j == 0 && $i > 10  && $i < 15){
                    $node = new Node($i, $j, Node::BLUE, Node::SMALLSLIDE);
                    $nodeRow[] = $node;
                }elseif($j == 0 && $i > 1 && $i < 7){
                    $node = new Node($i, $j, Node::BLUE, Node::BIGSLIDE);
                    $nodeRow[] = $node;
                }elseif($i == 0 || $i == 15 || $j == 0 || $j == 15){ // Start of square tiles
                    $node = new Node($i, $j, Node::NO_COLOR, Node::SQUARE);
                    $nodeRow[] = $node;
                }elseif (($i == 1 && $j == 3) || ($i == 1 && $j == 5) || ($i == 3 && $j == 3) ||($i == 3 && $j == 5)){
                    // Start spots
                    $node = new Node($i, $j, Node::YELLOW, Node::START);
                    $nodeRow[] = $node;
                }elseif (($i == 3 && $j == 12) || ($i == 3 && $j == 14) || ($i == 5 && $j == 12) ||($i == 5 && $j == 14)){
                    $node = new Node($i, $j, Node::GREEN, Node::START);
                    $nodeRow[] = $node;
                }elseif (($i == 10 && $j == 1) || ($i == 10 && $j == 3) || ($i == 12 && $j == 1) ||($i == 12 && $j == 3)){
                    $node = new Node($i, $j, Node::BLUE, Node::START);
                    $nodeRow[] = $node;
                }elseif (($i == 12 && $j == 10) || ($i == 12 && $j == 12) || ($i == 14 && $j == 10) ||($i == 14 && $j == 12)){
                    $node = new Node($i, $j, Node::RED, Node::START);
                    $nodeRow[] = $node;
                }elseif($j == 2 && $i < 6 && $i > 0){ // Safe spots
                    $node = new Node($i, $j, Node::YELLOW, Node::SAFE);
                    $nodeRow[] = $node;
                }elseif($i == 13 && $j < 6 && $j > 0){
                    $node = new Node($i, $j, Node::BLUE, Node::SAFE);
                    $nodeRow[] = $node;
                }elseif($i == 2 && $j < 15 && $j > 9){
                    $node = new Node($i, $j, Node::GREEN, Node::SAFE);
                    $nodeRow[] = $node;
                }elseif($j == 13 && $i < 15 && $i > 9){
                    $node = new Node($i, $j, Node::RED, Node::SAFE);
                    $nodeRow[] = $node;
                }elseif($i == 6 && $j == 2){ // yellow home
                    $node = new Node($i, $j, Node::YELLOW, Node::HOME);
                    $nodeRow[] = $node;
                }elseif($i == 2 && $j == 9){ // green home
                    $node = new Node($i, $j, Node::GREEN, Node::HOME);
                    $nodeRow[] = $node;
                }elseif($i == 9 && $j == 13){ // red home
                    $node = new Node($i, $j, Node::RED, Node::HOME);
                    $nodeRow[] = $node;
                }elseif($i == 13 && $j == 6){ // blue home
                    $node = new Node($i, $j, Node::BLUE, Node::HOME);
                    $nodeRow[] = $node;
                }

                else{
                    $node = new Node($i, $j, Node::NO_COLOR, Node::SQUARE);
                    $node->setBlocked();
                    $nodeRow[] = $node;

                }

            }
            $this->nodes[] = $nodeRow;
        }


        $this->LinkNodes();

    }

    private function LinkNodes(){
        for($i = 0; $i < count($this->nodes); $i++) {
            for ($j = 0; $j < count(($this->nodes)[$i]); $j++) {
                if($i == 0 && $j != 15 ){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i][$j+1]);
                }elseif($i != 15 && $j == 15){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i+1][$j]);
                }elseif($i == 15 && $j != 0){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i][$j-1]);
                }elseif($i != 0 && $j == 0){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i-1][$j]);

                }elseif (($i == 1 && $j == 3) || ($i == 1 && $j == 5) || ($i == 3 && $j == 3) ||($i == 3 && $j == 5)){ // start links
                    ($this->nodes[$i][$j])->addTo($this->nodes[0][4]);
                }elseif (($i == 3 && $j == 12) || ($i == 3 && $j == 14) || ($i == 5 && $j == 12) ||($i == 5 && $j == 14)){
                    ($this->nodes[$i][$j])->addTo($this->nodes[4][15]);
                }elseif (($i == 10 && $j == 1) || ($i == 10 && $j == 3) || ($i == 12 && $j == 1) ||($i == 12 && $j == 3)){
                    ($this->nodes[$i][$j])->addTo($this->nodes[11][0]);
                }elseif (($i == 12 && $j == 10) || ($i == 12 && $j == 12) || ($i == 14 && $j == 10) ||($i == 14 && $j == 12)){
                    ($this->nodes[$i][$j])->addTo($this->nodes[15][11]);

                }elseif($j == 2 && $i < 6 && $i > 0){ //Start of safe links
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i+1][$j]);
                }elseif($i == 13 && $j < 6 && $j > 0){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i][$j+1]);
                }elseif($i == 2 && $j < 15 && $j > 9){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i][$j-1]);
                }elseif($j == 13 && $i < 15 && $i > 9){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i-1][$j]);
                }

                if ($i == 0 && $j == 2 ){ // Start of entrance to safe spots
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i+1][$j]);
                }elseif ($i == 2 && $j == 15){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i][$j-1]);
                }elseif ($i == 15 && $j == 13){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i-1][$j]);
                }elseif ($i == 13 && $j == 0){
                    ($this->nodes[$i][$j])->addTo($this->nodes[$i][$j+1]);
                }


            }

        }



        // adding the previous node as the very last node in the neighbors array
        for($i = 0; $i < count($this->nodes); $i++) {
            for ($j = 0; $j < count(($this->nodes)[$i]); $j++) {
                // adds the previous node for the regular spots of the board
                if ($j == 0 && $i != 15) {
                    $this->nodes[$i][$j]->addTo($this->nodes[$i+1][$j]);
                }
                else if ($i == 15 && $j != 15) {
                    $this->nodes[$i][$j]->addTo($this->nodes[$i][$j+1]);
                }
                else if ($j == 15 && $i != 0) {
                    $this->nodes[$i][$j]->addTo($this->nodes[$i-1][$j]);
                }
                else if ($i == 0  && $j != 0) {
                    $this->nodes[$i][$j]->addTo($this->nodes[$i][$j-1]);
                }

                // adds the previous nodes for the safe zones
                if ($j == 2 && $i < 6 && $i > 0) {
                    $this->nodes[$i][$j]->addTo($this->nodes[$i-1][$j]);
                }
                elseif($i == 13 && $j < 6 && $j > 0){
                    $this->nodes[$i][$j]->addTo($this->nodes[$i][$j-1]);
                }
                elseif($i == 2 && $j < 15 && $j > 9){
                    $this->nodes[$i][$j]->addTo($this->nodes[$i][$j+1]);
                }
                elseif($j == 13 && $i < 15 && $i > 9){
                    $this->nodes[$i][$j]->addTo($this->nodes[$i+1][$j]);
                }
            }
        }


    }

    /**
     * @return mixed
     */
    public function getNodes()
    {
        return $this->nodes;
    }


    public function drawCard(){
        $this->cards_drawn += 1;
        $newCard = $this->cards->draw();
        $this->card = $newCard;
        if ($this->cards_drawn >= 45){
            $this->cards_drawn = 0;
            $this->cards = new Cards($this);
        }
    }

    public function getCardsDrawn(){
        return $this->cards_drawn;
    }

    public function getCard()
    {
        return $this->card;
    }

    public function getCards() : Cards{
        return $this->cards;
    }

    /**
     * @return mixed
     */
    public function getPlayerTurn()
    {
        return $this->playerTurn;
    }
    /**
     * Set the next players turn
     * @param mixed
     */
    public function setPlayerTurn($turn)
    {
        $this->playerTurn = $turn;
        $this->holder = $this->playerTurn;
    }

    /**
     * Change the player pointer to the next player when called.
     */
    public function nextTurn($colorChange = true){
        if ($colorChange){
            $this->playerNumberTurn++;
            if($this->playerNumberTurn >= count($this->players)){
                $this->playerNumberTurn = 0;
            }
            $this->playerTurn = $this->players[$this->playerNumberTurn];
            $this->holder = $this->playerTurn;

        }
        $this->selected = null;

    }
    public function nextTurnForController(){
        $this->nextTurn();
        $newGame = new GamesTable($this->site);
        $theGame = $newGame->get($this->getGameId());
        $newGame->setPlayerTurn($theGame,$this->holder->getColor());
    }



    public function getNodeByXY($x, $y)
    {
        if (!isset($this->nodes[$x]))
        {
            return false;
        }
        if (!isset($this->nodes[$x][$y]))
        {
            return false;
        }

        return $this->nodes[$x][$y];

    }


    /**
     * This class will be used to interact with the controller to process movements
     * @param $loc string A string with the coordinates to our selection.
     */
    public function interact(string $loc){

        $split = explode(',', $loc);
        $x = +$split[0]; // Get the x cord.
        $y = +$split[1]; // Get the Y cord.
        $this->inHomeFlag = false;


        foreach($this->playerTurn->getPawns() as $pawn){
            if ($pawn->getXLocation() == $x && $pawn->getYLocation() == $y){
                $this->selected = $pawn;
                $this->resetReachable();

                // if player selected pawn is in spawn area:
                if ($this->selected->getXLocation() == $this->selected->getXSpawnLocation() && $this->selected->getYLocation() == $this->selected->getYSpawnLocation()) {
                    $cardType = $this->card->getCardType();
                    // if the player draw 1 or 2, the player is able to move a pawn from start.
                    if ($this->card->getCardType() == 1 || $this->card->getCardType() == 2) {
                        $this->nodes[$this->selected->getXSpawnLocation()][$this->selected->getYSpawnLocation()]->getNeighborNodes()[0]->setReachable(true);
                    // if the player draw sorry card, the player is able to swap a pawn from start with any other player's pawn that is not in the start.
                    } else if ($cardType == Card::SORRY){ // card sorry
                        // check if there is a swap available
                        $hasValidSwapTarget = false;
                        $hasValidSwapPawn = false;
                        // check other players.
                        foreach ($this->players as $p) {
                            // if this pawn is player's check if there is any pawn in the start area
                            foreach ($p->getPawns() as $_p) {
                                if ($p == $this->selected->getPlayer()){
                                    if ($_p->getXLocation() == $_p->getXSpawnLocation() && $_p->getYLocation() == $_p->getYSpawnLocation()){
                                        $hasValidSwapPawn = true;
                                    }
                                }
                                // if the other player's pawn is not in the start area, there is a valid swap.
                                else if ($_p->getXLocation() != $_p->getXSpawnLocation() && $_p->getYLocation() != $_p->getYSpawnLocation()) {
                                    $this->nodes[$_p->getXLocation()][$_p->getYLocation()]->setReachable(true);
                                    $hasValidSwapTarget = true;
                                }
                            }
                        }
                        if (!$hasValidSwapTarget || !$hasValidSwapPawn){
                            $this->setActionFlag(true);
                            $this->nextTurn();
                            $this->setNextGameState();
                            $this->setSelected(null);
                        }
                    } else {
                        // the pawn selected is in start area and not able to move, just simply change turn.
                        $this->inHomeFlag = true;
                        $this->setActionFlag(true);
                        if ($cardType == 2) $this->setBonusFlag(true);
                        if ($cardType != 2) $this->nextTurn();
                        $this->setNextGameState();
                        $this->setSelected(null);
                    }
                }
                else {
                    if ($this->card->getCardType() == 11) {
                        if ($this->nodes[$this->selected->getXLocation()][$this->selected->getYLocation()]->getLocationType() != Node::SAFE) {
                            foreach ($this->players as $p) {
                                if ($p == $this->selected->getPlayer()) {
                                    continue;
                                }
                                foreach ($p->getPawns() as $_p) {
                                    if ($_p->getXLocation() != $_p->getXSpawnLocation() && $_p->getYLocation() != $_p->getYSpawnLocation()){
                                        if ($this->nodes[$_p->getXLocation()][$_p->getYLocation()]->getLocationType() != Node::SAFE && $this->nodes[$_p->getXLocation()][$_p->getYLocation()]->getLocationType() != Node::HOME) {
                                            $this->nodes[$_p->getXLocation()][$_p->getYLocation()]->setReachable(true);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $this->nodes[$x][$y]->reachableNodes($this->card->getCardType());
                    if ($this->hasReachableNodes() == false) {
                        $this->setActionFlag(true);
                        $this->nextTurn();
                        $this->setNextGameState();
                        $this->setSelected(null);
                        $this->resetReachable();
                    }
                }
                return;
            }
        }
        // only call set position if we check for search reachable.
        if($this->selected != null) {
            if ($this->card->getCardType() == 11 && $this->nodes[$x][$y]->getOccupiedPawn() != null && $this->nodes[$x][$y]->isReachable() && $this->nodes[$x][$y]->getBlocked() == false) {
                $positionX = $this->selected->getXLocation();
                $positionY = $this->selected->getYLocation();
                $currPawn = $this->nodes[$x][$y]->getOccupiedPawn();
                $this->nodes[$this->selected->GetXLocation()][$this->selected->GetYLocation()]->setOccupiedPawn($currPawn);
                $this->nodes[$x][$y]->setOccupiedPawn($this->selected);
                $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                $currPawn->setPosition($positionX, $positionY, $this->getNodeByXY($positionX, $positionY));

                $this->resetReachable();
                $this->setActionFlag(true);
                $this->nextTurn();
                $this->setNextGameState();
                $this->setSelected(null);
                return;
            }
            if(!$this->nodes[$x][$y]->isReachable() || $this->nodes[$x][$y]->getBlocked()) { //If the node we select is not apart of the game
                return;
            }elseif ($this->nodes[$x][$y]->getLocationType() == Node::SAFE) {
                // ensure we are selecting the right colors safe zone
                if($this->nodes[$x][$y]->getPawnColor() != $this->playerTurn->getColor()){ // Check if the player
                    // is going into the correct safe spot
                     return;
                }
            }elseif($this->nodes[$x][$y]->getLocationType() == Node::START){ // make sure the player cant move back to start
                return;
            }elseif($this->nodes[$x][$y]->getOccupiedPawn() != null){ // If the selected node is occupied by another player
                $prevPawn = $this->nodes[$x][$y]->getOccupiedPawn(); // Get that players pawn
                // Move that pawn back home now
                $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                    $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
            }
            if ($this->card->getCardType() == 7) {
                $xDifference = abs($this->selected->getXLocation() - $x);
                $yDifference = abs($this->selected->getYLocation() - $y);
                $this->totalMovement = $xDifference + $yDifference;
                $this->difference = 7 - $this->totalMovement;
                if ($this->totalMovement != 7) {
                    if ($this->difference == 1) {
                        $this->difference = 14;
                    }
                    else if ($this->difference == 2) {
                        $this->difference = 15;
                    }
                    else if ($this->difference == 3) {
                        $this->difference = 16;
                    }
                    else if ($this->difference == 4) {
                        $this->difference = 17;
                    }
                    else if ($this->difference == 5) {
                        $this->difference = 18;
                    }
                    else if ($this->difference == 6) {
                        $this->difference = 19;
                    }
                }
            }
            // The bottom 2 functions handle the slides
            if(($x == 6 && $y == 0) || ($x == 0 && $y == 9) ||($x == 9 && $y == 15) ||($x == 15 && $y == 6)){
                $temp = $this->slideHandle(Node::BIGSLIDE, $x, $y); // Goto slideHandle to handle slide movement
                // This handles the teleportation of the big slides
                if (!empty($temp)){
                    $x = $temp[0];
                    $y = $temp[1];
                }
            }elseif(($x == 14 && $y == 0) || ($x == 0 && $y == 1) ||($x == 1 && $y == 15) ||($x == 15 && $y == 14)){
                $temp = $this->slideHandle(Node::SMALLSLIDE, $x, $y); // Goto slideHandle to handle slide movement
                // This handles the teleportation of the small slides
                if (!empty($temp)){
                    $x = $temp[0];
                    $y = $temp[1];
                }
            }

            if ($this->card->getCardType() == 7 && $this->totalMovement != 7) {
                $this->nodes[$this->selected->GetXLocation()][$this->selected->GetYLocation()]->setOccupiedPawn(null);
                $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                $this->nodes[$x][$y]->setOccupiedPawn($this->selected);
                $this->resetReachable();
                $this->card = new Card($this->difference);
                $this->gameState = self::ACTION;
                $this->setSelected(null);
                return;
            }


            // Reset the node ownership of pawns if we move
            $this->nodes[$this->selected->GetXLocation()][$this->selected->GetYLocation()]->setOccupiedPawn(null);
            // actually move the piece
            $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
            $this->resetReachable();
            $this->nodes[$x][$y]->setOccupiedPawn($this->selected); // Set the occupied node to our held pawn
            $this->setActionFlag(true);

            if($this->nodes[$x][$y]->getLocationType() == Node::HOME && $this->nodes[$x][$y]->getPawnColor() == $this->playerTurn->getColor()){
                $this->nodes[$x][$y]->setOccupiedPawn(null); // Set the occupied node to our held pawn
                $this->playerTurn->decreasePawnCount();
                if($this->playerTurn->getPawnCount() == 3){
                    if($this->playerTurn->getColor() == Game::YELLOW){
                        $x = 6;
                        $y = 1;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::RED){
                        $x = 7;
                        $y = 12;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::BLUE){
                        $x = 12;
                        $y = 6;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::GREEN){
                        $x = 1;
                        $y = 7;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }
                }elseif($this->playerTurn->getPawnCount() == 2){
                    if($this->playerTurn->getColor() == Game::YELLOW){
                        $x = 6;
                        $y = 3;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::RED){
                        $x = 7;
                        $y = 14;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::BLUE){
                        $x = 12;
                        $y = 8;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::GREEN){
                        $x = 1;
                        $y = 9;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }

                }elseif($this->playerTurn->getPawnCount() == 1){
                    if($this->playerTurn->getColor() == Game::YELLOW){
                        $x = 8;
                        $y = 1;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::RED){
                        $x = 9;
                        $y = 12;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::BLUE){
                        $x = 14;
                        $y = 6;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::GREEN){
                        $x = 3;
                        $y = 7;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }

                }else{
                    if($this->playerTurn->getColor() == Game::YELLOW){
                        $x = 8;
                        $y = 3;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::RED){
                        $x = 9;
                        $y = 14;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::BLUE){
                        $x = 14;
                        $y = 8;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }elseif($this->playerTurn->getColor() == Game::GREEN){
                        $x = 3;
                        $y = 9;
                        $this->selected->SetPosition($x, $y, $this->getNodeByXY($x, $y));
                    }
                    $this->game_won = $this->playerTurn;
                }

                $this->setSelected(null);

            }



            $cardType = $this->getCard()->getCardType();

            if ($this->isActionFlag()){
                $this->setActionFlag(false);
                $this->setBonusFlag(false);

                // updates the game state
                if ($cardType != 2){
                    $this->nextTurn();
                } else {
                    $this->setBonusFlag(true);
                }

                $this->setNextGameState();
                $this->setSelected(null);
            }
        }
    }


    /**
     * This class will be used to handle the sliding actions of the game, it should only be called if a piece
     * goes to the beginning of a slide.
     * @param $slideSize int A constant int that tells us if we are on a big or small slide
     * @return array an array of locations, or an empty array.
     */
    public function slideHandle($slideSize, $x, $y){
        $location = array(); // teleport the x and y values of the slide
        $this->nodes[$x][$y]->setOccupiedPawn(null); // Remove any occupied pawns at the beginning of the slide
        // Small slides
        if($slideSize == Node::SMALLSLIDE){
            if($this->nodes[$x][$y]->getLocationType() == Node::SMALLSLIDE){ //2nd proof checking for slide type
                if($x == 14 && $this->playerTurn->getColor() != SELF::BLUE){ // small blue
                    for($i = 1; $i < 4; $i++){
                        if($this->nodes[$x-$i][$y]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x-$i][$y]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x-$i][$y]->setOccupiedPawn(null); // If they are sent home update the node
                        }
                    }
                    $location = array(11,0); // where we teleport

                }elseif($y == 1 && $this->playerTurn->getColor() != SELF::YELLOW){ // small yellow
                    for($i = 1; $i < 4; $i++){
                        if($this->nodes[$x][$y+$i]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x][$y+$i]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x][$y+$i]->setOccupiedPawn(null); // If they are sent home update the node
                        }
                    }
                    $location = array(0,4); // where we teleport
                }elseif($x == 1 && $this->playerTurn->getColor() != SELF::GREEN){ // small green
                    for($i = 1; $i < 4; $i++){
                        if($this->nodes[$x+$i][$y]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x+$i][$y]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x+$i][$y]->setOccupiedPawn(null); // If they are sent home update the node
                        }
                    }
                    $location = array(4,15); // where we teleport
                }elseif($y == 14 && $this->playerTurn->getColor() != SELF::RED){ // small red
                    for($i = 1; $i < 4; $i++){
                        if($this->nodes[$x][$y-$i]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x][$y-$i]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x][$y-$i]->setOccupiedPawn(null); // If they are sent home update the node
                        }

                    }
                    $location = array(15,11); // where we teleport
                }
            }


        }elseif ($slideSize == Node::BIGSLIDE){
            if($this->nodes[$x][$y]->getLocationType() == Node::BIGSLIDE)
            { //2nd proof checking for slide type

                if($x == 6 && $this->playerTurn->getColor() != SELF::BLUE){ // Big blue
                    for($i = 1; $i < 5; $i++){
                        if($this->nodes[$x-$i][$y]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x-$i][$y]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x-$i][$y]->setOccupiedPawn(null); // If they are sent home update the node
                        }
                    }
                    $location = array(2,0); // where we teleport

                }elseif($y == 9 && $this->playerTurn->getColor() != SELF::YELLOW){ // big yellow
                    for($i = 1; $i < 5; $i++){
                        if($this->nodes[$x][$y+$i]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x][$y+$i]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x][$y+$i]->setOccupiedPawn(null); // If they are sent home update the node
                        }
                    }
                    $location = array(0,13); // where we teleport

                }elseif($x == 9 && $this->playerTurn->getColor() != SELF::GREEN){ // big green
                    for($i = 1; $i < 5; $i++){
                        if($this->nodes[$x+$i][$y]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x+$i][$y]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x+$i][$y]->setOccupiedPawn(null); // If they are sent home update the node
                        }
                    }
                    $location = array(13,15); // where we teleport

                }elseif($y == 6 && $this->playerTurn->getColor() != SELF::RED){ // big red
                    for($i = 1; $i < 5; $i++){
                        if($this->nodes[$x][$y-$i]->getOccupiedPawn() != null){ // if a pawn is on a slide send it home
                            $prevPawn = $this->nodes[$x][$y-$i]->getOccupiedPawn(); // Get that players pawn
                            // Move that pawn back start now
                            $prevPawn->SetPosition($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation(),
                                $this->getNodeByXY($prevPawn->getXSpawnLocation(),$prevPawn->getYSpawnLocation()));
                            $this->nodes[$x][$y-$i]->setOccupiedPawn(null); // If they are sent home update the node
                        }

                    }
                    $location = array(15,2); // where we teleport
                }
            }

        }
        return $location; // return our potential new location, or an empty array.
    }



    public function resetReachable() {
        foreach($this->nodes as $node) {
            foreach($node as $currNode) {
                $currNode->setReachable(false);
            }
        }
    }

    public function hasReachableNodes() : bool {
        $hasReachableNodes = false;
        foreach($this->nodes as $node) {
            foreach($node as $currNode) {
                if ($currNode->isReachable()) {
                    $hasReachableNodes = true;
                }
            }
        }
        return $hasReachableNodes;
    }


    /**
     * @return bool
     */
    public function isActionFlag(): bool
    {
        return $this->actionFlag;
    }

    /**
     * @param bool $actionFlag
     */
    public function setActionFlag(bool $actionFlag)
    {
        $this->actionFlag = $actionFlag;
    }


    // set game to next state: DRAWCARD -> ACTION -> DONE
    public function setNextGameState()
    {

        if ($this->gameState == self::DONE) {
            $this->gameState = self::DRAWCARD;


        }
        else{
            $this->gameState += 1;
        }

    }
    // get current game state;
    public function getGameState() : int
    {
        return $this->gameState;
    }

    /**
     * @return mixed
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * @param mixed $selected
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

    /**
     * @return bool
     */
    public function isBonusFlag(): bool
    {
        return $this->bonusFlag;
    }

    /**
     * @param bool $bonusFlag
     */
    public function setBonusFlag(bool $bonusFlag)
    {
        $this->bonusFlag = $bonusFlag;
    }

    //Function that sets the game state to win
    public function setGameStateToWin()
    {
        $this->gameState = self::GAMEOVER;

    }
    public function dataTurnColor(){
        $gameTable = new GamesTable($this->site);
        $newTable = $gameTable->get($this->getGameId());
        $playerTurn = $newTable->getPlayerTurn();

        $newPlayerTable = new PlayerTable($this->site);
        $newPlayer = $newPlayerTable->getPlayerById($playerTurn);
        return $newPlayer->getColor();

    }



    /**
     * @return mixed
     */
    public function getPlayerToDisplay()
    {
        return $this->playerToDisplay;
    }

    /**
     * @param mixed $playerToDisplay
     */
    public function setPlayerToDisplay($playerToDisplay)
    {
        $this->playerToDisplay = $playerToDisplay;
    }

    public function getInHomeFlag(){
        return $this->inHomeFlag;
    }

    public function getWon(){
        return $this->game_won;
    }

    public function setGameId($id){
        $this->game_id = $id;
    }

    public function getGameId(){
        return $this->game_id;
    }

    public function getPlayerTableIds(){
        return $this->playerTableIds;
    }

    public function getCurrentPlayerId(){

    }

    private $selected; // The selected pawn from the player
    private $playerCount;
    private $players; // All the players in the current game
    private $playerTurn; // A pointer to the player
    private $playerNumberTurn = 0; // the player numbers turn
    private $card; // Current card
    private $cards; // All the cards
    private $cards_drawn = 0;
    private $nodes; // A 2d array of our collection of the node tiles.
    private $setFlag = false;
    private $gameState = self::DRAWCARD;
    private $actionFlag = false;
    private $bonusFlag = false;
    private $playerToDisplay;
    private $inHomeFlag = false;
    private $difference = 0; // for the 7 card if they choose to split, so we know how much to move the second time
    private $totalMovement; // for first turn of 7 card if they choose to split
    private $game_won=null;
    private $game_id;
    private $site;
    private $playerTableIds =array();
    private $user;
    private $currentPlayerId;
    private $holder;
}