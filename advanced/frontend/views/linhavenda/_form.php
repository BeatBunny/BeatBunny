<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Linhavenda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="linhavenda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'precoVenda')->textInput() ?>

    <?= $form->field($model, 'venda_id')->textInput() ?>

    <?= $form->field($model, 'musics_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
