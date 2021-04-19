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

    public function addPlayer($playerId, $color)
    {
        //TO DO
    }

    public function createGame(){
        //TO DO
    }

    public function deleteGame(){
        //TO DO
    }
}