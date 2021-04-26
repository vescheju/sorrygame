<?php


namespace Game;


class RoomView extends View
{
    private $site;
    private $game_id;
    private $players;

    public function __construct(Site $site, $get){
        $this->site = $site;
        $this->game_id = $get["game-id"];

        $info = new GameInfoTable($this->site);
        $room = $info->getGamesById($this->game_id);
        $users = new Users($this->site);
        // print_r($room);
        $owner = $users->get($room->getOwnerId())->getName();
        $this->setTitle("$owner's Waiting Room");
        $this->addLink("instructions.php", "Instructions");
    }

    public function present(){

        $info = new GameInfoTable($this->site);
        $room = $info->getGamesById($this->game_id);
        $users = new Users($this->site);
        // print_r($room);
        $html = <<<HTML
<form method="post" action="post/room-post.php?game-id=$this->game_id">
 <fieldset>
HTML;
        $players = $room->getPlayers();

        foreach ($players as $player_id){
            $user = $users->get($player_id);

            $player_name = $user->getName();
            $player_email = $user->getEmail();

            $html .= <<< HTML
    <div class="room_entry">
        <p class="1">$player_id</p>
        <p class="2">$player_name</p>
        <p class="3">$player_email</p>
        <p class="4">Ready</p>
    </div>
    </fieldset>
HTML;
        }

        if (count($players) < 2) {
            $html .= <<<HTML
    <p>Must have a minimum of 2 players to start the game!</p>
HTML;
        }
        else {
            $html .= <<<HTML
    <p>Any player can click the start button to start the game!</p>
HTML;
        }


        $html .=<<<HTML
    <p>
        <input type="submit" name="start" id="start" value="Start">
        
    </p>
HTML;



        return $html;
    }


}