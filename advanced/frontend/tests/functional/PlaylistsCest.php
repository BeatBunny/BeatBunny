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
        $I->amOnRoute('site/login');
    }
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    protected function createPlaylistParams($nome){
        return [
          'Playlists[nome]' => $nome,
        ];
    }

    public function checkGuestCantAccess(FunctionalTester $I)
    {
        $I->amOnPage('playlists/index');
        $I->see('Not Found');
    }

    public function checkGuestCantCreate(FunctionalTester $I)
    {
        $I->amOnPage('playlists/create');
        $I->see('Not Found');
    }

    public function checkGuestCantDeletePlaylist(FunctionalTester $I)
    {
        $I->amOnPage('playlists/delete');
        $I->see('Not Found');
    }

    public function checkLogedUserCanAcessPlaylistsAndCreate(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('olex04', 'dnister04'));
        $I->amOnPage('playlists/create');
        $I->see('Create Playlists');
    }

    public function checkLogedUserCantDeletePlaylistsIfNotExist(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('olex04', 'dnister04'));
        $I->amOnPage('playlists/delete');
        $I->see('Not Allowed');
    }

}
