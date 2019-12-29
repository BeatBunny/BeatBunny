<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 29/12/2019
 * Time: 20:05
 */

namespace frontend\tests\functional;


use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture as UserFixture;
use frontend\tests\FunctionalTester;

class UserCest
{
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
        $I->amOnRoute('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }


    public function checkAccessGuesst(FunctionalTester $I)
    {
      $I->amOnPage('user/index');
      $I->see('Not Found');
    }
//Perhuntar ao Stor
    public function checkAccessSettings(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('olex04', 'dnister04'));
        $I->see('My Stuff');
//        $I->amOnPage('user/settings');
//        $I->click('My Stuff');
    }

}