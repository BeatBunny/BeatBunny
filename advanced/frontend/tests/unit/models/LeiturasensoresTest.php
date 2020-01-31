<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 27/12/2019
 * Time: 12:33
 */
namespace frontend\tests\unit\models;
use common\fixtures\LeiturasensoresFixture as LeiturasensoresFixture;
use common\models\Leiturasensores;

class LeiturasensoresTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'leiturasensores' => [
                'class' => LeiturasensoresFixture::className(),
                'dataFile' => codecept_data_dir() . 'leitura_sensores.php'
            ]
        ]);
    }

    public function testLeiturasensoresTemperaturaValidation()
    {
        $leiturasensores = new Leiturasensores();
        $leiturasensores->temperatura = null;
        $this->assertFalse($leiturasensores->validate(['temperatura']));
        $leiturasensores->temperatura = "24.4";
        $this->assertTrue($leiturasensores->validate(['temperatura']));
        return $leiturasensores->temperatura;
    }

    public function testLeiturasensoresHumidadeValidation()
    {
        $leiturasensores = new Leiturasensores();
        $leiturasensores->humidade = null;
        $this->assertFalse($leiturasensores->validate(['humidade']));
        $leiturasensores->humidade = "50";
        $this->assertTrue($leiturasensores->validate(['humidade']));
        return $leiturasensores->humidade;
    }

    public function testLeiturasensoresLuminosidadeValidation()
    {
        $leiturasensores = new Leiturasensores();
        $leiturasensores->luminosidade = null;
        $this->assertFalse($leiturasensores->validate(['luminosidade']));
        $leiturasensores->luminosidade = "150.66";
        $this->assertTrue($leiturasensores->validate(['luminosidade']));
        return $leiturasensores->luminosidade;
    }

    public function testLeiturasensoresDescricaoValidation()
    {
        $leiturasensores = new Leiturasensores();
        $leiturasensores->descricao = null;
        $this->assertFalse($leiturasensores->validate(['descricao']));
        $leiturasensores->descricao = "Descricao teste bla bla bla";
        $this->assertTrue($leiturasensores->validate(['descricao']));
        return $leiturasensores->descricao;
    }

    public function testInsertLeiturasensores()
    {
        $leiturasensores = new Leiturasensores();
        $leiturasensores->attributes = [
            'humidade' => $this->testLeiturasensoresHumidadeValidation(),
            'temperatura' => $this->testLeiturasensoresTemperaturaValidation(),
            'luminosidade' => $this->testLeiturasensoresLuminosidadeValidation(),
            'descricao' => $this->testLeiturasensoresDescricaoValidation(),
        ];
        $leiturasensores->save();
        $this->tester->seeRecord('common\models\LeituraSensores', array('humidade' => '50'));
    }



}