<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LeituraSensores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leitura-sensores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'temperatura')->textInput() ?>

    <?= $form->field($model, 'humidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'luminosidade')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
