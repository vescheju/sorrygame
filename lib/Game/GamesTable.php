<?php


namespace Game;


class GamesTable extends Table
{

    public function __construct(Site $site)
    {
        parent::__construct($site, "game");
    }

    public function get($id)
    {
        $sql = <<<SQL
SELECT * from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        return new GameTable($statement->fetch(\PDO::FETCH_ASSOC));
    }


    public function addPlayer($game_id, GamePlayer $player)
    {
        $gameTable =$this->get($game_id);
        $players = $gameTable->getPlayerIds();
        $count = count($players);
        $key = "player" . $count;
        $players[$key] = $player->getId();

        $json = json_encode($players);

        $sql = <<<SQL
UPDATE $this->tableName
SET players=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($json, $gameTable->getId()));
        } catch (\PDOException $e) {
            return false;
        }
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;

    }

    public function getPlayer(GameTable $gameTable, $colorCode)
    {
        $playerTable = new PlayerTable($this->site);
        $players = $gameTable->getPlayerIds();
        foreach ($players as $playerId) {
            $player = $playerTable->getPlayerById($playerId);
            if ($player->getColor() == $colorCode) {
                return $player;
            }
        }
        return null;
    }

    public function createGame(User $user, Game $game)
    {
        $players = array("player1" => $user->getId());
        $jsonPlayers = json_encode($players);
        $started = 0;
        $ownerId = $user->getId();
        $cards = new Cards($game);
        $cards_json = json_encode($cards->getCards());
        $occupied_json = json_encode(array());
        $player_turn = $ownerId;

        $sql = <<<SQL
INSERT INTO $this->tableName(started, owner_id, players, cards, player_turn, occupied_nodes)
values(?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute([
            $started,
            $ownerId,
            $jsonPlayers,
            $cards_json,
            $player_turn,
            $occupied_json
        ]);


        return $this->pdo()->lastInsertId();
    }


    public function deleteGame(GameTable $gameTable)
    {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($gameTable->getId()));
    }


    public function setStarted(GameTable $gameTable, $started)
    {
        $sql = <<<SQL
UPDATE $this->tableName
SET started=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($started, $gameTable->getId()));
        } catch (\PDOException $e) {
            return false;
        }
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    public function getCards(GameTable $gameTable){
        $sql =<<<SQL
SELECT cards from $this->tableName
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameTable->getId()));
        if($statement->rowCount() === 0) {
            return null;
        }

        $json = $statement->fetch(\PDO::FETCH_ASSOC);

        return json_decode($json, true);
    }

    public function setCards(GameTable $gameTable, $cards){
        $cards_json = json_encode($cards);

        $sql = <<<SQL
UPDATE $this->tableName
SET cards=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($cards_json, $gameTable->getId()));
        } catch (\PDOException $e) {
            return false;
        }
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    public function getPlayerTurn(GameTable $gameTable){

        $sql =<<<SQL
SELECT player_turn from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameTable->getId()));
        if($statement->rowCount() === 0) {
            return null;
        }

        $playerId = $statement->fetch(\PDO::FETCH_ASSOC);

        $playerTable = new PlayerTable($this->site);

        return $playerTable->getPlayerById($playerId);
    }

    public function setPlayerTurn(GameTable $gameTable, $colorCode){
        $player = $this->getPlayer($gameTable, $colorCode);

        $sql = <<<SQL
UPDATE $this->tableName
SET player_turn=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($player->getId(), $gameTable->getId()));
        } catch (\PDOException $e) {
            return false;
        }
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    public function getOccupied(GameTable $gameTable){
        $sql =<<<SQL
SELECT occupied_nodes from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameTable->getId()));
        if($statement->rowCount() === 0) {
            return null;
        }

        $json = $statement->fetch(\PDO::FETCH_ASSOC);

        return json_decode($json, true);
    }

    public function setOccupied(GameTable $gameTable, $nodes){
        $nodes_json = json_encode($nodes);

        $sql = <<<SQL
UPDATE $this->tableName
SET occupied_nodes=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($nodes_json, $gameTable->getId()));
        } catch (\PDOException $e) {
            return false;
        }
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    public function getAvailableColor($gameid){
        $game = $this->get($gameid);
        $colors = array(Game::GREEN, Game::RED, Game::BLUE, Game::YELLOW);

        foreach ($colors as $color){
            $check = $this->getPlayer($game, $color);
            if ($check == null){
                return $color;
            }
        }
        return null;
    }
}