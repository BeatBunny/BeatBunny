<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 29/12/2019
 * Time: 21:44
 */

namespace frontend\tests\acceptance;
use common\fixtures\UserFixture as UserFixture;
use frontend\tests\AcceptanceTester;

class SignupAndLoginCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }
    public function _before(AcceptanceTester $I)
    {
    }

    public function tryToSignup(AcceptanceTester $I)
    {
        $I->amOnPage('/BeatBunny/advanced/frontend/web/');
        $I->click('Signup');
        $I->wait(2);
        $I->see('Please fill out the following fields to signup');
        $I->wait(2);
        $I->fillField('Username', 'olex0004');
        $I->fillField('Email','olex.ol.0004@gmail.com');
        $I->fillField('Password','dnister04');
        $I->fillField('Nome','oleksandr');
        $I->fillField('Nif','123456789');
        $I->wait(2);
        $I->click('signup-button');
        $I->wait(4);
    }
    public function tryToLogin(AcceptanceTester $I)
    {
        $I->wait(2);
        $I->amOnPage('/BeatBunny/advanced/frontend/web/site/login');
        $I->wait(2);
        $I->fillField('Username', 'olex04');
        $I->fillField('Password','dnister04');
        $I->wait(2);
        $I->click('login-button');
        $I->wait(2);
        $I->see('My Stuff');
        $I->wait(5);
    }
}