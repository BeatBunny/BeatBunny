<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 27/12/2019
 * Time: 02:43
 */

namespace frontend\tests\functional;


use frontend\tests\FunctionalTester;

class AlbumsCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('albums/index');
    }

    public function checkGuestCantAccess(FunctionalTester $I)
    {
        $I->amOnPage('albums/index');
        $I->see('Not Found');
    }
}