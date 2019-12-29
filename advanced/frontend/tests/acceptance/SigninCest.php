<?php 

namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    	$I->amOnPage('/web');
    	$I->click('Login');
    	$I->wait(2);
    	$I->amOnPage('/login');
    	$I->see('Please fill out the following fields to login:');

		$I->fillField('Username', 'beatbunnyproject');
		$I->fillField('Password','beatbunnyproject');
		$I->click('Login', '.btn');
		$I->wait(2);
		
    	
    }
}
