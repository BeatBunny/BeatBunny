<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Settings';
?>
<div class="user-form" >
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-4 userImage textAlignRight">
            <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?></div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-lg-5 borderLeftBlack borderRightBlack">
            <?= $form->field($userProvider, 'username')->textInput() ?>
            <?= $form->field($profileProvider, 'nome')->textInput() ?>
            <?= $form->field($userProvider, 'email')->textInput() ?>
            <?= $form->field($userProvider, 'password_reset_token')->textInput() ?>
            <?= $form->field($profileProvider, 'nif')->textInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>