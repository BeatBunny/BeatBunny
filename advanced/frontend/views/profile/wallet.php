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
        <div class="col-lg-4 userImageProfile textAligncenter paymentmethod">
            <?= Html::img('@web/images/multibanco.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
            <div class="textAligncenter marginTop2Percent">
                <input type="radio" name="optradio" id="optradio1" checked>
            </div>
        </div>

        <div class="col-lg-4 userImageProfile textAligncenter paymentmethod">
            <?= Html::img('@web/images/visa.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
            <div class="textAligncenter marginTop2Percent">
                <input type="radio" name="optradio" id="optradio2">
            </div>
        </div>
        <div class="col-lg-4 userImageProfile textAligncenter paymentmethod">
            <?= Html::img('@web/images/paypal.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
            <div class="textAligncenter marginTop2Percent">
                <input type="radio" name="optradio" id="optradio3">
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