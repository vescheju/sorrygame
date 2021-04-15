<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sorry Players</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="lib/game.css">
</head>

<body>
<div class="user">
    <div class="nav">
        <nav>
            <ul class="left">
                <li><a href="./">Home</a></li>
            </ul>
        </nav>
    </div>

    <header class="main">
        <h1><img src="images/green.png" alt="Green game piece"> New User Sign Up
            <img src="images/green.png" alt="Green game piece"></h1>
    </header>

    <form method="post" action="post/password-validate.php">
        <fieldset>
            <input type="hidden" name="validator" value="434342423">
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

    <footer>
        <p>Sorry! Team 25</p>
    </footer>

</div>

</body>
</html>
