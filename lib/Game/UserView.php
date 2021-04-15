<?php


namespace Game;


class UserView extends View{
    public function __construct(Site $site) {
        $this->site = $site;
        $this->setTitle("New User Sign Up");
    }

    public function present(){
        $html = <<<HTML
<form action="post/user.php">
        <fieldset>
            <legend>User</legend>
            <p>Please enter in the following information:</p>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email">
            </p>
            <p>
                <label for="name">Name</label><br>
                <input type="text" id="name" name="name" placeholder="Name">
            </p>
            <p>
                <input type="submit" value="OK"> <input type="submit" value="Cancel">
            </p>

        </fieldset>
    </form>
        
HTML;
        return $html;
    }

    private $site;


}