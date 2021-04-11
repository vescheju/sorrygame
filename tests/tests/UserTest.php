<?php


class UserTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct() {
        $row = array('id' => 12,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'notes' => 'Some Notes',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => 'S'
        );
        $user = new Game\User($row);
        $this->assertEquals(12, $user->getId());
        $this->assertEquals('dude@ranch.com', $user->getEmail());
        $this->assertEquals('Some Notes', $user->getNotes());
        $this->assertEquals(strtotime('2015-01-15 23:50:26'),
            $user->getJoined());
        $this->assertEquals('S', $user->getRole());
    }
}