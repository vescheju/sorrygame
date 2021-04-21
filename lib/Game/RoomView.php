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
            TODO: update this page when room info is changed. ex. someone joined/ someone got ready/ host started the game
<form method="post" action="post/rooms-post.php?game-id=$this->game_id">
            <input type="submit" name="leave" id="" value="Leave">
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
        <p class="4">Ready?</p>
    </div>
    
HTML;
        }

        $html .=<<<HTML
    
    </fieldset>
    <p>
        <input type="submit" name="" id="" value="Ready">TODO: get ready
        <input type="submit" name="" id="" value="Start" disabled>TODO: owner can start a game when everyone is ready
        
    </p>
HTML;


        return $html;
    }


}