<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Playlists */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="playlists-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ispublica')->dropDownList([ 'S' => 'S', 'N' => 'N', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'creationdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
