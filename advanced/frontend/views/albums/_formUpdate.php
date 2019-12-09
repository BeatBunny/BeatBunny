<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Albums */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="albums-form">
    <?php $form = ActiveForm::begin();
    $genresList = ArrayHelper::map($modelGenres,'id','nome');  ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form ->field($model, 'albumcover')->fileInput()->label("Album Cover (.png)")?>
    <?= $form->field($model, 'genres_id')->dropDownList( $genresList )->label("Genre"); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
