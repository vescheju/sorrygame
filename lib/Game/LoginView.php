<?php


namespace Game;


class LoginView
{
    public function __construct(){

    }

    public function present(){
        $html = <<<HTML
<h1>Welcome to Sorry!</h1>
<h2>Please Login</h2>
<form method="post" action="login-post.php">
    <fieldset>
        <legend>Login</legend>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email">
        </p>
        <p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Password">
        </p>
        <p>
            <input type="submit" name="login" id="login" value="Log in"><input type="submit" name="signup" id="signup" value="Sign up">
        </p>

    </fieldset>
</form>
HTML;
        return $html;

    }
}