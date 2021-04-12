<?php


namespace Game;


class LoginController
{
    public function __construct(Site $site, array &$session, array $post){
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;
        $root = $site->getRoot();
        if($user === null) {
            // Login failed
            $this->redirect = "$root/login.php?e";
        } else {
            $this->redirect = "$root/start.php";
        }
    }

    public function getRedirect(){
        return $this->redirect;
    }

    private $redirect;
}