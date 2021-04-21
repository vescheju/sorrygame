<?php


namespace Game;


class RoomsView extends View
{
    private $site;
    public function __construct(Site $site){
        $this->site = $site;
        $this->setTitle("Sorry! Rooms");
        $this->addLink("instructions.php", "Instructions");
    }

    public function present(){
        $info = new GameInfoTable($this->site);
        $rooms = $info->getGamesByState(false);
        $users = new Users($this->site);
        $html = <<<HTML

<a href="./rooms.php">Refresh list</a>
<form method="post" action="">
    <fieldset>
        <legend>Room List</legend>
HTML;

for ($i=0; $i<count($rooms); $i++){
    $game_id = $rooms[$i]->getId();
    $players = strval($rooms[$i]->getPlayersCount()) . " / 4";
    $owner = $users->get($rooms[$i]->getOwnerId())->getName(). "'s room";
    $html .= <<< HTML
    <div class="room_entry">
        <p class="1">$game_id</p>
        <p class="2">$owner</p>
        <p class="3">$players</p>
        <p class="4"><a href="post/rooms-post.php?game-id=$game_id">Join</a></p>
    </div>
HTML;
}

        $html .= <<<HTML
    </fieldset>
    <p>
        <input type="submit" name="create_room" id="create_room" value="Create a room">TODO
        <input type="submit" name="random_room" id="random_room" value="Join a random room">TODO
    </p>

</form>
HTML;
        return $html;
    }
}