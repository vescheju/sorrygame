<?php


namespace Game;


class UserController{
    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();
        $this->redirect = "$root";

        if (isset($post['cancel'])) {
            return;
        }

        $email = strip_tags($post['email']);
        $name = strip_tags($post['name']);
        $id = 0;
        $notes = '';
        $role = User::CLIENT;

        $row = ['id' => $id,
            'email' => $email,
            'name' => $name,
            'notes' => $notes,
            'password' => null,
            'joined' => null,
            'role' => $role
        ];
        $editUser = new User($row);

        $users = new Users($site);
        $mailer = new Email();
        $users->add($editUser, $mailer);


    }

    /**
     * @return mixed
     */
    public function getRedirect() {
        return $this->redirect;
    }


        private $redirect;	///< Page we will redirect the user to.

}