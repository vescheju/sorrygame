<?php


namespace Game;


class PlayerTable extends Table
{
    public function __construct(Site $site)
    {
        parent::__construct($site, "player");
    }

    /*
     * Inserts a player id into the player table
     **/
    public function setPlayerId($id) {
        $pawns = array();
        $pawns_json = json_encode($pawns);
        $color = 5;
        $sql = <<<SQL
INSERT INTO $this->tableName (player_id, color, pawns)
VALUES (?, ?, ?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id, $color, $pawns_json));
        if($statement->rowCount() === 0) {
            return null;
        }


        return $pdo->lastInsertId();

    }
    /*
     * get game by its state (started or not started)
     */
    public function getPlayerById($id){
        $sql = <<< SQL
SELECT * FROM $this->tableName
WHERE player_id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        return new GamePlayer($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /*
     * get game by its state (started or not started)
     */
    public function SetPawns($id, $pawnsArray){
        $sql = <<<SQL
UPDATE $this->tableName
SET pawns=?
WHERE player_id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $str = json_encode($pawnsArray);

        $statement->execute(array($str, $id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        return true;
    }

    public function setColor($id, $color) {
        $sql = <<<SQL
UPDATE $this->tableName
SET color=?
WHERE player_id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($color, $id));
        if ($statement->rowCount() == 0) {
            return false;
        }
        return true;

    }


}