<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 27/12/2019
 * Time: 12:33
 */
namespace frontend\tests\unit\models;
use common\fixtures\ProfileFixture as ProfileFixture;
use common\fixtures\UserFixture as UserFixture;
use common\models\Profile;
use common\models\User;

class ProfileFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testProfileNomeValidation()
    {
        $profile = new Profile();
        $profile->nome = null;
        $this->assertFalse($profile->validate(['nome']));
        $profile->nome = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
        $this->assertFalse($profile->validate(['nome']));
        $profile->nome = "Olex Ol";
        $this->assertTrue($profile->validate(['nome']));
        return $profile->nome;
    }

    public function testProfileNifValidation()
    {
        $profile = new Profile();
        $profile->nif = 'wewewew';
        $this->assertFalse($profile->validate(['nif']), 'Nif must be a number.');
        $profile->nif = '123456789';
        $this->assertTrue($profile->validate(['nif']));
        return $profile->nif;
    }

    public function testProfileIDUserValidation()
    {
        $profile = new Profile();
        $profile->user_id = ' ';
        $this->assertFalse($profile->validate(['user_id']));
        $profile->user_id = 1;
        $this->assertTrue($profile->validate(['user_id']));
        return $profile->user_id;
    }

    public function testProfileSaldoValidation(){
        $profile = new Profile();
        $profile->saldo= 'wewewew';
        $this->assertFalse($profile->validate(['saldo']), 'Nif must be a number.');
        $profile->saldo = '12';
        $this->assertTrue($profile->validate(['saldo']));
        return $profile->saldo;
    }


    public function testInsertProfile(){

        $this->tester->haveRecord('common\models\Profile',[
            'nome' => $this->testProfileNomeValidation(),
            'nif' =>  $this->testProfileNifValidation(),
            'saldo' => $this->testProfileSaldoValidation(),
            'isprodutor' =>'N',
            'profileimage'=>'',
            'user_id' => $this->testProfileIDUserValidation(),
        ]);
        $this->tester->seeRecord('common\models\Profile' ,array('nome' => $this->testProfileNomeValidation()));
    }



}