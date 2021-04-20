<?php


class PlayerTableTest extends \PHPUnit\Framework\TestCase
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
        $info = new Game\PlayerTable(self::$site);
        $tableName = $info->getTableName();

        $sql = <<<SQL
delete from $tableName;
insert into $tableName(player_id, color, pawns)
values (1, 2, '{"pawn1":"(1,2)", "player2":"(3,4)"}')
SQL;

        self::$site->pdo()->query($sql);
    }
}