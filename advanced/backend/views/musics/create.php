<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Musics */

$this->title = 'Create Musics';
$this->params['breadcrumbs'][] = ['label' => 'Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="musics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
