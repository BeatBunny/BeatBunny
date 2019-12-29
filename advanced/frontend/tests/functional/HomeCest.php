<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpenAbout(FunctionalTester $I)
    {
        $I->amOnPage('site/index');
        $I->see('Welcome to beatBunny');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This App was created as University Project!');
    }

    public function checkOpenAboutUS(FunctionalTester $I)
    {
        $I->amOnPage('site/index');
        $I->see('Welcome to beatBunny');
        $I->seeLink('Know more about you? Yes please!');
        $I->click('Know more about you? Yes please!');
        $I->see('About Us');
    }

    public function checkOpenSignup(FunctionalTester $I)
    {
        $I->amOnPage('site/index');
        $I->see('Welcome to beatBunny');
        $I->seeLink('Signup');
        $I->click('Signup');
        $I->see('Please fill out the following fields to signup:');
    }

    public function checkContact(FunctionalTester $I)
    {
        $I->amOnPage('site/index');
        $I->see('Welcome to beatBunny');
        $I->seeLink('Contact');
        $I->click('Contact');
        $I->see('If you have business inquiries or other questions, please fill out the following form to contact us.');
    }
//Perguntar ao Stor
//    public function checkMusics(FunctionalTester $I)
//    {
//        $I->amOnPage('site/index');
//        $I->see('Welcome to beatBunny');
//        $I->seeLink('Music');
//        $I->click('Music');
//        $I->see('Musics');
//    }

}