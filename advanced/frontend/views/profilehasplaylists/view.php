<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileHasPlaylists */

$this->title = $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Playlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-has-playlists-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'profile_id' => $model->profile_id, 'playlists_id' => $model->playlists_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'profile_id' => $model->profile_id, 'playlists_id' => $model->playlists_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'profile_id',
            'playlists_id',
        ],
    ]) ?>

</div>
