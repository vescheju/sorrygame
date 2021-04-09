<?php
?>

<!DOCTYPE html>
<!-- instructions.php -->
<html lang="en">
<head>
    <link href="game.css" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>Sorry! Instructions</title>
</head>
<body>

<div class="help">
    <h1>Sorry! Instructions</h1>
    <h2>Basic Instructions</h2>
    <p>
        The starting menu is like selecting tokens in a game. If you have two players,
        they select two colors, say Red and Blue. One player will play as Red and the other as Blue.
        Each player gets four pawns of their color. These are place in the corresponding "Start" area of the board.
    </p>
    <p>
        The deck contains 45 cards: five 1 cards as well as 4 of the other cards (Sorry!, 2, 3, 4, 5, 7, 8, 10, 11,
        and 12). These a randomly ordered and placed face down in the area labeled "Place Pack Here". To select a card,
        the player whose turn it is, click on the deck. One card is "turned over" and displayed in the "Discard Here"
        area. The player then moves a pawn based on the card's instructions. Once a player has made their move, they
        click the "Done" button and the next player takes their turn.
    </p>
    <p>
        The game board at the start would look like it does below with Blue and Green playing. This is after the first
        card has been drawn but before any pieces have been moved:
    </p>
</div>

<figure>
    <img src="images/exampleBoard.png" alt="Sorry! Board Example" width="400" height="400" />
</figure>

<div class="help">
    <p>
        Pawns can only move forward (clockwise) or backward (counter clockwise) based on the actions described on the
        drawn card. A player wins by moving all their pawns from the "Start" position to the "Home" position.
    </p>
    <p>
        If a pawn lands at the start of a slide (except those of its own color), either by direct movement or as the
        result of a switch from an 11 card or a Sorry card, it immediately "slides" to the last square of the slide.
        All pawns on all spaces of the slide (including those belonging to the sliding player) are sent back to their
        respective Starts.
    </p>
    <h2>Special Rules</h2>
    <p>
        A pawn may jump over another pawn when moving.
    </p>
    <p>
        Only one pawn may occupy a square.
    </p>
    <p>
        A pawn that lands on an opponents pawn moves that pawn back to its own Start.
    </p>
    <p>
        The last five squares before each player's Home are "Safety Zones", and are specially colored corresponding to
        the colors of the Homes they lead to. Access is limited to pawns of the same color. Pawns inside the Safety
        Zones are immune to being bumped by opponents' pawns or being switched with opponents' pawns via 11 or Sorry!
        cards. However, if a pawn is forced via a 10 or 4 card to move backward out of the Safety Zone, it is no longer
        considered "safe" and may be bumped by or switched with opponents' pawns as usual until it re-enters the Safety
        Zone.
    </p>
</div>

<div class="credits">
    <h2>Team 25 Credits</h2>
    <p>Mihir Bhadange</p>
    <p>Jessica Maye Mccoy</p>
    <p>Pooja Panguru</p>
    <p>Justin James Vesche</p>
    <p>Andy Zhang</p>

</div>

<div class="game-links">
    <p class="game-link"><a href="game.php">Return to Game</a></p>
    <p class="game-link"><a href="index.php">Start Menu</a></p>
</div>



</body>
</html>