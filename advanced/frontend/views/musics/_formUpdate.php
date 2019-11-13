<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="musics-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); 

    $genresList=ArrayHelper::map($modelGenres,'id','nome'); 

    $yourAlbumsList = ArrayHelper::map($modelYourAlbums, 'id','title'); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'launchdate')->textInput(['readonly' => true, 'value' => date("Y/m/d")]) ?>

    <?= $form->field($model, 'lyrics')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pvp')->textInput([ 'type' => 'number' ]) ?>

    <?= $form->field($model, 'imageFile')->fileInput()->label("Music Cover (.png)"); ?>
    
    <?= $form->field($model, 'genres_id')->dropDownList( $genresList ); ?>

    <?= $form->field($model, 'albums_id')->dropDownList( $yourAlbumsList ); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
