<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'saldoAdd')->textInput([ 'type' => 'number', 'placeholder' => 'Amount' ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Add funds', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
