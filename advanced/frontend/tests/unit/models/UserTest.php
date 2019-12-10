<?php 
namespace frontend\tests\unit\models;
use common\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testUsernameValidation()
    {
        $user = new User();
        $user->username = null;
        $this->assertFalse($user->validate(['username']));
        $user->username = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";   
        $this->assertFalse($user->validate(['username']));
        $user->username = "Richardus1";
        $this->assertTrue($user->validate(['username']));
        return $user->username;
    }

    public function testPasswordValidation(){
        $user = new User();
        /*$user->password = null;
        $this->assertTrue($user->validate(['password']), 'Password null, NOP');
        $user->password = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
        $this->assertTrue($user->validate(['password']), 'Password demasiado longa, NOP');
        $user->password = 123456789;
        $this->assertTrue($user->validate(['password']), 'Password certa, NOP');*/
        $user->password = "teste12345";
        $this->assertTrue($user->validate(['password']), 'Password certa, YE');
        return $user->password;
    }

    public function testEmailValidation(){
        $user = new User();
        $user->email = null;
        $this->assertFalse($user->validate(['email']), 'Email é null');
        $user->email = 1;
        $this->assertFalse($user->validate(['email']), 'Email é numérico');
        $user->email = 'a';
        $this->assertFalse($user->validate(['email']), 'Email tem uma letra');
        $user->email = 'a2';
        $this->assertFalse($user->validate(['email']), 'Email tem uma letra e número');
        $user->email = 'a2@gmail';
        $this->assertFalse($user->validate(['email']), 'Email tem uma letra , número e arroba');
        $user->email = 'richardus1@gmail.com';
        $this->assertTrue($user->validate(['email']), 'Email tem uma letra , número ,  arroba e .com');
        return $user->email;
    }

    public function testInsertUser(){
        $user = new User();
        $user->username = $this->testUsernameValidation();
        $user->password = $this->testPasswordValidation();
        $user->email = $this->testEmailValidation();
        
        $this->assertTrue($user->signup());
        $this->tester->seeInDatabase("user", ['username' => "Richardus1"]);
    }
}