<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $profileProvider frontend\models\User */

?>

<div class="user-form">
    <div class="row">
        <div class="col-lg-4 userImage textAlignRight">
            <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?></div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-5 borderLeftBlack borderRightBlack">
    <?= $form->field($profileProvider, 'username')->textInput() ?>

    <?= $form->field($profileProvider, 'email')->textInput() ?>

    <?= $form->field($profileProvider, 'password_reset_token')->passwordInput()?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
