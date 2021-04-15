<?php


namespace Game;


class View{

    /**
     * Protect a page for staff only access
     *
     * If access is denied, call getProtectRedirect
     * for the redirect page
     * @param $site The Site object
     * @param $user The current User object
     * @return bool true if page is accessible
     */
    public function protect($site, $user) {
        if($user->isStaff()) {
            return true;
        }

        $this->protectRedirect = $site->getRoot() . "/";
        return false;
    }
    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    public function head() {
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="lib/game.css">
HTML;

HTML;
    }

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML
<div class="nav">
<nav>
    <ul class="left">
        <li><a href="./">Home</a></li>
    </ul>
HTML;

        if(count($this->links) > 0) {
            $html .= '<ul class="right">';
            foreach($this->links as $link) {
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';
            }
            $html .= '</ul>';
        }
        $additional = $this->headerAdditional();

        $html .= <<<HTML
</nav>
</div>
<header class="main">
    <h1><img src="images/green.png" alt="Green game piece"> $this->title
    <img src="images/green.png" alt="Green game piece"></h1>
    $additional
</header>
HTML;
        return $html;
    }

    /**
     * Override in derived class to add content to the header.
     * @return string Any additional comment to put in the header
     */
    protected function headerAdditional() {
        return '';
    }



    /**
     * Add a link that will appear on the nav bar
     * @param $href What to link to
     * @param $text
     */
    public function addLink($href, $text) {
        $this->links[] = ["href" => $href, "text" => $text];
    }

    public function footer()
    {
        return <<<HTML
<footer><p>Sorry! Team 25</p></footer>
HTML;
    }




    private $title = "";
    private $links = [];	// Links to add to the nav bar


}