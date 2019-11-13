<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Choose Payment Option';
$this->params['breadcrumbs'][] = ['label'=> 'Your Profile', 'url' => ['/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form" >
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row form-group borderTopBlack">
        <div class="col-lg-4 userImage textAligncenter">
            <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
            <div class="radio">
                <label><input type="radio" name="optradio" id="optradio1" checked>Option 1</label>
            </div>
        </div>

        <div class="col-lg-4 userImage textAligncenter">
            <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
            <div class="radio">
                <label><input type="radio" name="optradio" id="optradio2">Option 2</label>
            </div>
        </div>
        <div class="col-lg-4 userImage textAligncenter">
            <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
            <div class="radio">
                <label><input type="radio" name="optradio" id="optradio3">Option 3</label>
            </div>
        </div>

        <?= 
            $this->render('_formWallet', ['model' => $model]);
        ?>
        <div class="col-lg-2" style="display: none;">
            <label for="amount">Amount: </label>
            <input type="text" class="form-control" id="amount">
            <br>
            <button class="btn btn-primary" type="button">Add funds</button>
        </div>
        <div class="col-lg-2" style="display: none;">
            <h1>€</h1>
        </div>

    </div>
</div>