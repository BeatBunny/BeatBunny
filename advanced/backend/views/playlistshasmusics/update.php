<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PlaylistsHasMusics */

$this->title = 'Update Playlists Has Musics: ' . $model->playlists_id;
$this->params['breadcrumbs'][] = ['label' => 'Playlists Has Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->playlists_id, 'url' => ['view', 'playlists_id' => $model->playlists_id, 'musics_id' => $model->musics_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="playlists-has-musics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
