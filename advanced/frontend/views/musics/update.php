<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */

$this->title = 'Update Musics: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title/*, 'url' => ['view', 'id' => $model->id]*/];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="musics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
        'modelGenres' => $modelGenres,
        'modelYourAlbums' => $modelYourAlbums,
    ]) ?>

</div>
