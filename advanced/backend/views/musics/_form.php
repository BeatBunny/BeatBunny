<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Musics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="musics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'launchdate')->textInput() ?>

    <?= $form->field($model, 'rating')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lyrics')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pvp')->textInput() ?>

    <?= $form->field($model, 'musiccover')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'musicpath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'genres_id')->textInput() ?>

    <?= $form->field($model, 'albums_id')->textInput() ?>

    <?= $form->field($model, 'iva_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
