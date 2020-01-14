<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 27/12/2019
 * Time: 02:43
 */

namespace frontend\tests\functional;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture as UserFixture;
use frontend\tests\FunctionalTester;
use yii\rbac\Assignment;

class AlbumsCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ], 'profile' => [
                'class' => ProfileFixture::className(),
                'dataFile' => codecept_data_dir(). 'profile.php'
                ]
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

    public function checkGuestCantAccess(FunctionalTester $I)
    {
        $I->amOnPage('albums/index');
        $I->see('Not Found');
    }
    public function checkGuestCantCreate(FunctionalTester $I)
    {
        $I->amOnPage('albums/create');
        $I->see('Not Found');
    }

    public function checkGuestCantDelete(FunctionalTester $I)
    {
        $I->amOnPage('albums/index');
        $I->see('Not Found');
    }

    public function checkLogedCommonUserCantOpen(FunctionalTester $I)
    {
        $I->fillField('input[name="LoginForm[username]"]', 'olex04');
        $I->fillField('input[name="LoginForm[password]"]', 'dnister04');
        $I->click('button[name="login-button"]');
        $I->amOnPage('albums/index');
        $I->see('Welcome to beatBunny');
    }

    public function checkLogedCommonUserCantCreate(FunctionalTester $I)
    {
        $I->fillField('input[name="LoginForm[username]"]', 'olex04');
        $I->fillField('input[name="LoginForm[password]"]', 'dnister04');
        $I->click('button[name="login-button"]');
        $I->amOnPage('albums/create');
        $I->see('Welcome to beatBunny');
    }

    public function checkLogedCommonUserCantDelete(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('olex04', 'dnister04'));
        $I->amOnPage('albums/delete');
        $I->see('Not Allowed');
    }


}