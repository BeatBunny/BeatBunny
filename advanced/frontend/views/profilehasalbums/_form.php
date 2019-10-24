<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileHasAlbums */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-has-albums-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'albums_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
