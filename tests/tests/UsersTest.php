<?php


class UsersTest extends \PHPUnit\Framework\TestCase
{
    private static $site;
    protected function setUp() {
        $users = new Game\Users(self::$site);
        $tableName = $users->getTableName();

        $sql = <<<SQL
delete from $tableName;
insert into $tableName(id, email, name, notes, password, joined, role, salt)
values (7, "dudess@dude.com", "Dudess, The", "Dudess Notes", 
        "49506d29656ad62805497b221a6bedacc304ad6496997f17fb39431dd462cf48", 
        "2015-01-22 23:50:26", "S", "Nohp6^v\$m(`qm#\$o"),
        (8, "cbowen@cse.msu.edu", "Owen, Charles", "Owen Notes", 
        "14831e3f21b423a557a0aa99a391a57a2400ef0fdade328890c9048ad3a8ab6a", 
        "2015-01-01 23:50:26", "A", "aeLWK6k`jzPpgZMi"),
        (9, "bart@bartman.com", "Simpson, Bart", "", 
        "a747a49bf74523c1760f649707bf3d2b4a858f088520fd98b35def1e6929ca26", 
        "2015-02-01 01:50:26", "C", "7xNhdV-8P#\$p)1c9"),
        (10, "marge@bartman.com", "Simpson, Marge", "", 
        "edfc83ceca3a49aef204cee0e51eeb1728f728c56b2ea9037017230cc39ae938", 
        "2015-02-01 01:50:26", "C", '!yhLrEo3d8vD_LNV')
SQL;

        self::$site->pdo()->query($sql);

        $this->user1 = array('id' => 7,
            'email' => "dudess@dude.com",
            'name' => 'Dudess, The',
            'notes' => 'Dudess Notes',
            'password' => '49506d29656ad62805497b221a6bedacc304ad6496997f17fb39431dd462cf48',
            'joined' => "2015-01-22 23:50:26",
            'role' => 'S',
            'salt' => 'Nohp6^v\$m(`qm#\$o'
        );

        $this->user2 = array('id' => 8,
            'email' => "cbowen@cse.msu.edu",
            'name' => "Owen, Charles",
            'notes' => 'Owen Notes',
            'password' => '14831e3f21b423a557a0aa99a391a57a2400ef0fdade328890c9048ad3a8ab6a',
            'joined' => "2015-01-01 23:50:26",
            'role' => 'A',
            'salt' => 'aeLWK6k`jzPpgZMi'
        );

    }

    public static function setUpBeforeClass() {
        self::$site = new Game\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }
    public function test_pdo() {
        $users = new Game\Users(self::$site);
        $this->assertInstanceOf('\PDO', $users->pdo());
    }

    private $user1;
    private $user2;

}