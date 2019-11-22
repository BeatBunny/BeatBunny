<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form" >
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-4 userImage textAlignRight">
            <?php
                if(is_null($profileProvider->profileimage))
                    echo Html::img('@web/images/user.png', ['alt'=>"User"],[ "id"=>"userImage"]);
                else
                    echo Html::img( "@web/uploads/".$userProvider->id."/profileimage_".$userProvider->id.'.png', ['alt'=>"User"]);
            ?>
        </div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-lg-5 borderLeftBlack borderRightBlack">
            <?= $form->field($userProvider, 'username')->textInput() ?>
            <?= $form->field($profileProvider, 'nome')->textInput() ?>
            <?= $form->field($userProvider, 'email')->textInput() ?>
            <?= $form->field($profileProvider, 'nif')->textInput() ?>
            <?= $form ->field($profileProvider, 'profileFile')->fileInput()->label("Profile Picture (.png)")?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>