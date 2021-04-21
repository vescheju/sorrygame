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


    //getState and setState need to be updated once we decide what state is

    /*
    public function getState(GameTable $gameTable)
    {
        $sql = <<<SQL
SELECT state from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameTable->getId()));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        $json = $row['state'];
        return json_decode($json, true);
    }

    public function setState(GameTable $gameTable)
    {
        $json = json_encode($gameTable->getState());

        $sql = <<<SQL
UPDATE $this->tableName
SET state=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($json, $gameTable->getId()));
        }
        catch(\PDOException $e) {
            return false;
        }
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }
    */

    public function addPlayer(GameTable $gameTable, GamePlayer $player)
    {
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
        }
        catch(\PDOException $e) {
            return false;
        }
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;

    }

    public function getPlayer(GameTable $gameTable, $colorCode){
        $playerTable = new PlayerTable($this->site);
        $players = $gameTable->getPlayerIds();
        foreach ($players as $playerId){
            $player = $playerTable->getPlayerById($playerId);
            if($player->getColor() == $colorCode){
                return $player;
            }
        }
        return null;
    }

    public function createGame(User $user, GamePlayer $player){
        $players = array("player1"=>$player->getId());
        $jsonPlayers = json_encode($players);
        $started = 0;
        $ownerId = $user->getId();

        $sql = <<<SQL
INSERT INTO $this->tableName(started, owner_id, players)
values(?, ?, ?,)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute([
            $started,
            $ownerId,
            $jsonPlayers
        ]);
        return $this->pdo()->lastInsertId();
    }

    public function setStarted(GameTable $gameTable, $started){
        $sql = <<<SQL
UPDATE $this->tableName
SET started=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($started, $gameTable->getId()));
        }
        catch(\PDOException $e) {
            return false;
        }
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }


    public function deleteGame(GameTable $gameTable){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($gameTable->getId()));
    }
}