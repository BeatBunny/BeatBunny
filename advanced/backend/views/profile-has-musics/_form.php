<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasMusics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-has-musics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'musics_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
