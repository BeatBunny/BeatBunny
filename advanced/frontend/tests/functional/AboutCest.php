<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class AboutCest
{
    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute('site/about');
        $I->see('About', 'h1');
    }

    public function checkBecomeAProducer(FunctionalTester $I)
    {
        $I->amOnRoute('site/about');
        $I->see('Be a Producer!');
        $I->click('Be a Producer!');
        $I->see('Contact');
    }
}
