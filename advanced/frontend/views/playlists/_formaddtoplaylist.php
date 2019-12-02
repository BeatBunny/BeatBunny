<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="playlists-addsong">

    <?php $form = ActiveForm::begin();

    $playlists= ArrayHelper::map($playlistsUserLogado,'id','nome'); ?>

    <?= $form->field($playlistHasMusics, 'playlists_id')->dropDownList( $playlists )->label("Playlists"); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
