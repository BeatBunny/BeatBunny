<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasAlbums */

$this->title = $model->albums_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-has-albums-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'albums_id' => $model->albums_id, 'profile_id' => $model->profile_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'albums_id' => $model->albums_id, 'profile_id' => $model->profile_id], [
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
            'albums_id',
            'profile_id',
        ],
    ]) ?>

</div>
