<?php


namespace Game;


class RoomView extends View
{
    private $site;
    public function __construct(Site $site){
        $this->site = $site;
    }

    public function present(){


        $html = <<<HTML

HTML;
        return $html;
    }
}