<?php 
namespace frontend\tests\unit\models;
use common\models\Profile;

class ProfileTest extends \Codeception\Test\Unit
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
    public function testProfileNomeValidation()
    {
        $profile = new Profile();
        $profile->nome = null;
        $this->assertFalse($profile->validate(['nome']));
        $profile->nome = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
        $this->assertFalse($profile->validate(['nome']));
        $profile->nome = "Ricardo Duarte";
        $this->assertTrue($profile->validate(['nome']));
        return $profile->nome;
    }

    public function testProfileNIFValidation(){
        $profile = new Profile();
        $profile->NIF = null;
        $this->assertFalse($profile->validate(['NIF']), "NIF é NULL");
        $profile->NIF = 123456789;
        $this->assertTrue($profile->validate(['NIF']), "NIF tem 9 caracteres");
        return $profile->NIF;
    }

    public function testProfileIdUserValidation(){
        $profile = new Profile();
        $profile->user_id = null;
        $this->assertFalse($profile->validate(['user_id']), 'ID USER é null');
        $profile->user_id = 'a';
        $this->assertFalse($profile->validate(['user_id']), 'ID USER é numérico');
        $profile->user_id = 1;
        $this->assertTrue($profile->validate(['user_id']), 'ID USER é apenas um numero');
        return $profile->user_id;
    }

    public function testInsertProfile(){
        $profile = new Profile();
        $profile->nome = $this->testProfileNomeValidation();
        $profile->email = $this->testProfileNIFValidation();
        $profile->user_id = $this->testProfileIdUserValidation();
        
        $this->assertTrue($profile->save());
        $this->tester->seeInDatabase("profile", ['nome' => "Ricardo Duarte"]);
    }
}