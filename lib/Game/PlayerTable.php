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
        $sql = <<<SQL
INSERT INTO $this->tableName (player_id)
VALUES (?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
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
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        return new GamePlayer($statement->fetchAll(\PDO::FETCH_ASSOC));
    }

    /*
     * get game by its state (started or not started)
     */
    public function SetPawns(GamePlayer $player, $pawnsArray){
        $sql = <<<SQL
UPDATE $this->tableName
SET pawns=?
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $str = json_encode($pawnsArray);

        $statement->execute(array($str, $player->getId()));
        if ($statement->rowCount() === 0) {
            return null;
        }
        return true;
    }

    public function setColor(GamePlayer $player, $color) {
        $sql = <<<SQL
UPDATE $this->tableName
SET color=?
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($color, $player->getId()));
        if ($statement->rowCount() == 0) {
            return false;
        }
        return true;

    }


}