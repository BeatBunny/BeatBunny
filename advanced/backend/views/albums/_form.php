<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Albums */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="albums-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'launchdate')->textInput() ?>

    <?= $form->field($model, 'review')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'albumcover')->textInput() ?>

    <?= $form->field($model, 'genres_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
