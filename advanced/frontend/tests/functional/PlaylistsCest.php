<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 27/12/2019
 * Time: 01:40
 */

namespace frontend\tests\functional;


use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class PlaylistsCest
{
    protected $formId = '#form-signup';
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('playlists/index');
    }
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkCreate(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'olex004',
            'SignupForm[email]' => 'olex.ol.004@gmail.com',
            'SignupForm[password]' => 'dnister04',
            'SignupForm[nome]' => 'testes',
            'SignupForm[nif]' => '123456789',
        ]);
        $I->amOnPage('site/login');
        $I->fillField('Username','olex004');
        $I->fillField('Password','dnister04');
        $I->amOnRoute('playlists/index');
        $I->see('Create a playlist!');
        $I->click('Create a playlist!');
        $I->see('Nome');
        $I->fillField('Nome','teste');
        $I->click('Save');
        $I->see('Teste');
    }


    public function checkGuestCantAccess(FunctionalTester $I)
    {
        $I->amOnPage('playlists/index');
        $I->see('Not Found');
    }
}
