<?php


namespace Game;


class PlayerTable extends Table
{
    public function __construct(Site $site)
    {
        parent::__construct($site, "player");
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

}