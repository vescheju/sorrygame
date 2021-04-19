<?php


namespace Game;


class WaitingRoomController
{
    public function __construct(Site $site, array $post, Game $game) {
        $root = $site->getRoot();
        $this->redirect = "$root/waiting-room.php";

        if(isset($post['start_game'])) {
            if ($game->getPlayerCount() < 2) {
                $this->redirect = "$root/waiting-room.php";
            }
            else {
                $this->redirect = "$root/game.php";
            }
        }
        else if(isset($post['leave_game'])) {
            $this->redirect = "$root/start.php";
        }
    }

    /**
     * Get any redirect link
     * @return mixed Redirect link
     */
    public function getRedirect() {
        return $this->redirect;
    }

    private $redirect;
}