<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;


class ContactCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('site/contact');
    }

    public function checkContact(FunctionalTester $I)
    {
        $I->see('Contact', 'h1');
    }

    public function checkContactSubmitNoData(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', []);
        $I->see('Contact', 'h1');
        $I->seeValidationError('Name cannot be blank');
        $I->seeValidationError('Email cannot be blank');
        $I->seeValidationError('Subject cannot be blank');
        $I->seeValidationError('Body cannot be blank');
        $I->seeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitNoName(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => '',
            'ContactForm[email]' => 'tester@gmail.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->submitForm('#contact-form', []);
        $I->see('Contact', 'h1');
        $I->seeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Email cannot be blank');
        $I->dontSeeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitNoSubject(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'Teste',
            'ContactForm[email]' => 'tester@gmail.com',
            'ContactForm[subject]' => '',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->submitForm('#contact-form', []);
        $I->see('Contact', 'h1');
        $I->seeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Email cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitNoBody(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'Teste',
            'ContactForm[email]' => 'tester@gmail.com',
            'ContactForm[subject]' => 'Teste Sub',
            'ContactForm[body]' => '',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->submitForm('#contact-form', []);
        $I->see('Contact', 'h1');
        $I->SeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Email cannot be blank');
        $I->dontseeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitNotCorrectEmail(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeValidationError('Email is not a valid email address.');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitCorrectData(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'olex04',
            'ContactForm[email]' => 'olex.ol.04@gmail.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
