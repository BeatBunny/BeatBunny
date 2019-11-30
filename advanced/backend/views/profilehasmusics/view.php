<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasMusics */

$this->title = $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-has-musics-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'profile_id' => $model->profile_id, 'musics_id' => $model->musics_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'profile_id' => $model->profile_id, 'musics_id' => $model->musics_id], [
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
            'musics_id',
        ],
    ]) ?>

</div>
