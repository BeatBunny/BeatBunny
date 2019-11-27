<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Linhavenda */

$this->title = 'Update Linhavenda: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linhavendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'venda_id' => $model->venda_id, 'musics_id' => $model->musics_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linhavenda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
