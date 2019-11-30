<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PlaylistsHasMusics */

$this->title = 'Create Playlists Has Musics';
$this->params['breadcrumbs'][] = ['label' => 'Playlists Has Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlists-has-musics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
