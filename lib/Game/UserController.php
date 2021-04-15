<?php


namespace Game;


class UserController{
    public function __construct(Site $site, User $user, array $post)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/users.php";

        if (isset($post['cancel'])) {
            return;
        }
    }

    /**
     * @return mixed
     */
    public function getRedirect() {
        return $this->redirect;
    }


        private $redirect;	///< Page we will redirect the user to.

}