<?php


namespace Game;


class LoginController
{
    public function __construct(Site $site, array &$session, array $post){
        $users = new Users($site);
        $root = $site->getRoot();
        $this->redirect = "$root";
        if (isset($post['login'])) {
            $email = strip_tags($post['email']);
            $password = strip_tags($post['password']);
            $user = $users->login($email, $password);
            $session[User::SESSION_NAME] = $user;

            if($user === null) {
                // Login failed
                $this->redirect = "$root/?e";
            } else {
                $this->redirect = "$root/start.php";
            }

        }else if(isset($post['signup'])){
            $this->redirect = "$root/user.php";

        }

    }

    public function getRedirect(){
        return $this->redirect;
    }

    private $redirect;
}