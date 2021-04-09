<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sorry Players</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="lib/game.css">
</head>

<body>
<div class="users">
    <nav>
        <ul class="left">
            <li><a href="./">Home</a></li>
        </ul>
        <ul class="right">
            <li><a href="staff.php">Staff</a></li>
            <li><a href="./">Log out</a></li>
        </ul>
    </nav>

    <header class="main">

    </header>

    <form class="table">
        <p>
            <input type="submit" name="add" id="add" value="Add">
            <input type="submit" name="edit" id="edit" value="Edit">
            <input type="submit" name="delete" id="delete" value="Delete">
        </p>

        <table>
            <tr>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>

            <tr>
                <td><input type="radio" name="user"></td>
                <td>Bogart, Humphrey</td>
                <td>bogart@felis.com</td>
                <td>Admin</td>
            </tr>
            <tr>
                <td><input type="radio" name="user"></td>
                <td>Spade, Sam</td>
                <td>spade@felis.com</td>
                <td>Staff</td>
            </tr>
            <tr>
                <td><input type="radio" name="user"></td>
                <td>Bacall, Lauren</td>
                <td>bacall@gmail.com</td>
                <td>Client</td>
            </tr>
        </table>
    </form>


    <footer>
        <p>Sorry</p>
    </footer>

</div>

</body>
</html>




