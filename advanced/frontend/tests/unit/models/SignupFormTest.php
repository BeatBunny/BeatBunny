<?php
namespace frontend\tests\unit\models;

use common\models\SignupForm;
use common\fixtures\UserFixture as UserFixture;
use common\fixtures\ProfileFixture as ProfileFixture;


class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'profile' => [
                'class' => ProfileFixture::className(),
                'dataFile' => codecept_data_dir() . 'profile.php'
            ],
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'BeatBunnyAdmin2',
            'email' => 'beatbunnyg062@gmail.com',
            'password' => 'BeatBunnyAdmin2',
            'nome' => 'BeatBunnyAdmin2',
            'nif' => '123456789',
        ]);
        $model->signup();
        $this->tester->seeRecord('common\models\User', [
            'username' => 'BeatBunnyAdmin2',
            'email' => 'beatbunnyg062@gmail.com',
            'status' => \common\models\User::STATUS_ACTIVE
        ]);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'BeatBunnyAdmin2',
            'email' => 'beatbunnyg062@gmail.com',
            'password' => 'BeatBunnyAdmin2',
            'nome' => 'BeatBunnyAdmin2',
            'nif' => '123456789',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));
        expect($model->getFirstError('username'))
            ->equals('This username has already been taken.');
        expect($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }

    public function testNotCorrectUsername()
    {
        $model = new SignupForm([
            'username' => '$$###',
            'email' => 'beatbunnyg062@gmail.com',
            'password' => 'BeatBunnyAdmin2',
            'nome' => 'BeatBunnyAdmin2',
            'nif' => '123456789',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect($model->getFirstError('username'))
            ->equals('Username is invalid.');
    }

    public function testNotCorrectNifLetters()
    {
        $model = new SignupForm([
            'username' => '$$###',
            'email' => 'beatbunnyg062@gmail.com',
            'password' => 'BeatBunnyAdmin2',
            'nome' => 'BeatBunnyAdmin2',
            'nif' => 'sdsdsdds',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('nif'));
        expect($model->getFirstError('nif'))
            ->equals('Nif must be a number.');
    }

    public function testNotCorrectNifToManyNumbers()
    {
        $model = new SignupForm([
            'username' => '$$###',
            'email' => 'beatbunnyg062@gmail.com',
            'password' => 'BeatBunnyAdmin2',
            'nome' => 'BeatBunnyAdmin2',
            'nif' => '3433656734343',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('nif'));
        expect($model->getFirstError('nif'))
            ->equals('Nif should contain at most 9 characters.');
    }
}
