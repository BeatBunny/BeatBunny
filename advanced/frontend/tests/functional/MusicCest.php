<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 28/12/2019
 * Time: 23:46
 */

namespace frontend\tests\functional;


use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class MusicCest
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

    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }
//perguntar ao Stor
//    public function checkGuestCantAcessCreate(FunctionalTester $I)
//    {
//        $I->amOnRoute('musics/index');
//          $I->See('Welcome to Beat Bunny');
//    }
}