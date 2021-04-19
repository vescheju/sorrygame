<?php


namespace Game;


class PasswordValidateView extends View{
    const INVALID_VALIDATOR = 1;
    const EMAIL_NOT_VALID_USER = 2;
    const EMAIL_DOES_NOT_MATCH = 3;
    const PASSWORD_DOES_NOT_MATCH = 4;
    const PASSWORD_TOO_SHORT = 5;

    public function __construct(Site $site, $get) {
        $this->site = $site;
        $this->setTitle("Sorry! Password Entry");
        $this->validator = strip_tags($get['v']);
        $this->message = "";
        if(isset($get['e'])){
            $error = +$get['e'];
            if($error == self::INVALID_VALIDATOR){
                $this->message = "<p>Invalid or unavailable validator</p>";
            }elseif ($error == self::EMAIL_NOT_VALID_USER){
                $this->message = "<p>Email address is not for a valid user</p>";
            }elseif ($error == self::EMAIL_DOES_NOT_MATCH){
                $this->message = "<p>Email address does not match validator</p>";
            }elseif ($error == self::PASSWORD_DOES_NOT_MATCH){
                $this->message = "<p>Passwords did not match</p>";
            }elseif ($error == self::PASSWORD_TOO_SHORT){
                $this->message = "<p>Password too short</p>";
            }
        }

    }

    public function present(){
        $html = <<<HTML
<form method="post" action="post/password-validate.php">
	<fieldset>
	<input type="hidden" name="validator" value="$this->validator">
		<legend>Change Password</legend>
		
		<p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email">
        </p>
        <p>
            <label for="password">Password: </label><br>
            <input type="password" id="password" name="password" placeholder="password">
        </p>
        <p>
            <label for="password2">Password (again): </label><br>
            <input type="password" id="password2" name="password2" placeholder="password">
        </p>

		<p><input type="submit" name="ok" id="ok" value="OK"> <input type="submit" name="cancel" id="cancel" value="Cancel"></p>

	</fieldset>
</form>

HTML;

        $html .= $this->message;
        return $html;


    }


    private $site;
    private $message = "";
    private $validator;



}