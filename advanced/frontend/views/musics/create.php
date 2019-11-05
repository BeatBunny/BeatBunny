<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */

$this->title = 'Upload your own Music';
$this->params['breadcrumbs'][] = ['label' => 'Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="musics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelGenres' => $modelGenres,
    ]) ?>

</div>
