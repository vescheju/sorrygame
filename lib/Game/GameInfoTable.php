<?php


namespace Game;


class GameInfoTable extends Table
{
    public function __construct(Site $site)
    {
        parent::__construct($site, "game");
    }

    /*
     * get game by its state (started or not started)
     */
    public function getGamesByState($started){
        $sql = <<< SQL
SELECT * FROM $this->tableName
WHERE started=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($started));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $ret = array();
        foreach ($rows as $row){
            $ret[] = new GameInfo($row);
        }
        return $ret;
    }

    public function addNewGame($owner_id){

    }
}