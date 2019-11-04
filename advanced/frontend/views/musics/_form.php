<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="musics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($searchModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($searchModel, 'launchdate')->textInput() ?>

    <?= $form->field($searchModel, 'rating')->textInput(['maxlength' => true]) ?>

   <!--  <?= $form->field($searchModel, 'lyrics')->textarea(['rows' => 6]) ?>

    <?= $form->field($searchModel, 'pvp')->textInput() ?>

    <?= $form->field($searchModel, 'genres_id')->textInput() ?>

    <?= $form->field($searchModel, 'albums_id')->textInput() ?>

    <?= $form->field($searchModel, 'iva_id')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
