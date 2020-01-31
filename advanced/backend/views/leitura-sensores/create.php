<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LeituraSensores */

$this->title = 'Create Leitura Sensores';
$this->params['breadcrumbs'][] = ['label' => 'Leitura Sensores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leitura-sensores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
