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
        /*$this->tester->haveFixtures([
            'profile' => [
                'class' => ProfileFixture::className(),
                'dataFile' => codecept_data_dir() . 'profile.php'
            ],
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);*/
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

        /*$user = $model->signup();
        expect($user)->true();

        /** @var \common\models\User $user */
        /*$user = $this->tester->grabRecord('common\models\User', [
            'username' => 'BeatBunnyAdmin',
            'email' => 'beatbunnyg06@gmail.com',
            'status' => \common\models\User::STATUS_ACTIVE
        ]);*/

        //$this->tester->seeEmailIsSent();

        /*$mail = $this->tester->grabLastSentEmail();

        expect($mail)->isInstanceOf('yii\mail\MessageInterface');
        expect($mail->getTo())->hasKey('beatbunnyg06@gmail.com');
        expect($mail->getFrom())->hasKey(\Yii::$app->params['supportEmail']);
        expect($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        expect($mail->toString())->stringContainsString($user->verification_token);*/
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
}
