<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#form-signup';


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Signup', 'h1');
        $I->see('Please fill out the following fields to signup:');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
        $I->seeValidationError('Nome cannot be blank.');
        $I->seeValidationError('Nif cannot be blank.');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignupForm[username]'  => 'tester',
                'SignupForm[email]'     => 'ttttt',
                'SignupForm[password]'  => 'tester_password',
                'SignupForm[nome]' => 'olex',
                'SignupForm[nif]' => '123456789',
            ]
        );
        $I->dontSee('Username cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->dontSee('Nome cannot be blank.', '.help-block');
        $I->dontSee('Nif cannot be blank.', '.help-block');
        $I->see('Email is not a valid email address.', '.help-block');
    }

    public function signupWithWrongUsername(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignupForm[username]'  => 'olex$?',
                'SignupForm[email]'     => 'teste.r@gmail.com',
                'SignupForm[password]'  => 'testePass',
                'SignupForm[nome]' => 'Teste',
                'SignupForm[nif]' => '123456789',
            ]
        );
        $I->see('Username is invalid.','.help-block');
        $I->dontSee('Email cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->dontSee('Nome cannot be blank.', '.help-block');
        $I->dontSee('Nif cannot be blank.', '.help-block');
    }

    public function signupWithNifNotNumber(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignupForm[username]'  => 'olex',
                'SignupForm[email]'     => 'teste.r@gmail.com',
                'SignupForm[password]'  => 'testePass',
                'SignupForm[nome]' => 'Teste',
                'SignupForm[nif]' => '123456sdsds9',
            ]
        );
        $I->see('Nif must be a number.', '.help-block');
        $I->dontSee('Username is invalid.','.help-block');
        $I->dontSee('Email cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->dontSee('Nome cannot be blank.', '.help-block');
    }

    public function signupWithNifTooLong(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignupForm[username]'  => 'olex',
                'SignupForm[email]'     => 'teste.r@gmail.com',
                'SignupForm[password]'  => 'testePass',
                'SignupForm[nome]' => 'Teste',
                'SignupForm[nif]' => '1234567891',
            ]
        );
        $I->see('Nif should contain at most 9 characters.', '.help-block');
        $I->dontSee('Username is invalid.','.help-block');
        $I->dontSee('Email cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->dontSee('Nome cannot be blank.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'olex004',
            'SignupForm[email]' => 'olex.ol.004@gmail.com',
            'SignupForm[password]' => 'dnister04',
            'SignupForm[nome]' => 'testes',
            'SignupForm[nif]' => '123456789',
        ]);

        $I->seeRecord('\common\models\User',
            [
                'username' => 'olex004',
                'email' => 'olex.ol.004@gmail.com',
                'status' => \common\models\User::STATUS_ACTIVE
            ]);
        $I->see('Thank you for registration. Please check your inbox for verification email.');
    }
}
