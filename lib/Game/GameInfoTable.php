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

    public function getGamesById($id){
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
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return new GameInfo($row);
    }

    public function joinRoomById($id, User $user){
        $room = $this->getGamesById($id);

        $sql = <<< SQL
UPDATE $this->tableName
SET players=?
WHERE id=?
SQL;
        $players = $room->getPlayers();
        $players["player".strval(count($players)+1)] = $user->getId();

        // print_r($players);

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $str = json_encode($players);
        // print($str);

        $statement->execute(array($str,$id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return new GameInfo($row);
    }

    public function leaveRoomById($id, User $user){
        $room = $this->getGamesById($id);

        $sql = <<< SQL
UPDATE $this->tableName
SET players=?
WHERE id=?
SQL;

        $players = $room->getPlayers();
        if (($key = array_search($user->getId(), $players)) !== false) {
            unset($players[$key]);
        }

        print_r($players);

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $str = json_encode($players);

        print($str);

        $statement->execute(array($str,$id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return new GameInfo($row);
    }
}