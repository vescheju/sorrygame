<?php


class GameInfoTableTest extends \PHPUnit\Framework\TestCase
{
    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Game\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    protected function setUp() {
        $info = new Game\GameInfoTable(self::$site);
        $tableName = $info->getTableName();

        $sql = <<<SQL
delete from $tableName;
insert into $tableName(id, started, owner_id, players)
values (1, FALSE, 1, '{"player1":1, "player2":2}'),
        (2, FALSE, 7, '{"player1":7, "player2":8, "player3":6}'),
        (3, TRUE, 3, '{"player1":3}')
SQL;

        self::$site->pdo()->query($sql);
    }

    public function test_getGamesByState(){
        $info = new Game\GameInfoTable(self::$site);
        $user = new Game\User(array("id"=>10,"email"=>"123@xxx.com","name"=>"helloworld","notes"=>"","joined"=>"","role"=>"A"));

        $rows = $info->getGamesByState(false);
        $this->assertCount(2, $rows);
        $this->assertEquals(1, $rows[0]->getPlayers()["player1"]);
        $this->assertEquals(2, $rows[0]->getPlayers()["player2"]);
        $this->assertEquals(2, $rows[0]->getPlayersCount());
        $info->joinRoomById(1, $user);

        $g = $info->getGamesById(1);

        $this->assertEquals(10, $g->getPlayers()["player3"]);
        $info->leaveRoomById(1, $user);

        $g = $info->getGamesById(1);

        $this->assertEquals(False, isset($g->getPlayers()["player3"]));

        $rows = $info->getGamesByState(true);
        $this->assertCount(1, $rows);

        // $this->assertEquals("1", $rows);
    }



}