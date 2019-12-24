<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Musics */

$this->title = 'Update Musics: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'profile_id' => $model->profile_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="musics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
