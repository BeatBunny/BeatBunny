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
            'profile' => [
                'class' =>ProfileFixture::className(),
                'dataFile'=> codecept_data_dir(). 'profile.php',
            ]
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }


    public function checkAccessGuest(FunctionalTester $I)
    {
      $I->amOnPage('user/index');
      $I->see('Not Found');
    }
    public function checkAccesssSettingsGuest(FunctionalTester $I)
    {
        $I->amOnPage('user/settings');
        $I->see('Not Found');
    }
    public function checkAccessWallet(FunctionalTester $I){
        $I->amOnPage("profile/wallet");
        $I->see("Not Found");
    }
    public function checkWalletLogin(FunctionalTester $I){
        $I->fillField('input[name="LoginForm[username]"]', 'olex04');
        $I->fillField('input[name="LoginForm[password]"]', 'dnister04');
        $I->click('button[name="login-button"]');
        $I->amOnPage("profile/wallet");
    }
}