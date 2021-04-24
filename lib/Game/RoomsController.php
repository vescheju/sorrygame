<?php

namespace Game;


class RoomsController{

    public function __construct(Site $site, User $user, $post){
        $root = $site->getRoot();
        $this->redirect = "$root/rooms.php";
        $gamesTable = new GamesTable($site);

        if(isset($post['create_room'])){


        }


    }

    public function getRedirect(){
        return $this->redirect;
    }


    private $redirect;


}