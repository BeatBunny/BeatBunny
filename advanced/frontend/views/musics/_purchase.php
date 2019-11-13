<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="width100">

    <?php $form = ActiveForm::begin(); ?>

    
        <div class="form-group">
            <?= Html::submitButton('Purchase', ['class' => 'btn btn-default width100']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
