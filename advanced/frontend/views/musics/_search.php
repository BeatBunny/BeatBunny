<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchMusics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="musics-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'launchdate') ?>

    <?= $form->field($model, 'rating') ?>

    <?= $form->field($model, 'lyrics') ?>

    <?php // echo $form->field($model, 'pvp') ?>

    <?php // echo $form->field($model, 'genres_id') ?>

    <?php // echo $form->field($model, 'albums_id') ?>

    <?php // echo $form->field($model, 'iva_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>