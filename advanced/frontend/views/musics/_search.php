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
    <span class="formFieldTitle">
        <?= $form->field($searchModel, 'title')->input('title', ['placeholder' => "Title"])->label(false)?>
    </span>
    <span class="formFieldButton">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </span>

    <?php ActiveForm::end(); ?>

</div>
