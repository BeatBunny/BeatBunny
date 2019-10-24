<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPlaylistsHasMusics */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Playlists Has Musics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlists-has-musics-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Playlists Has Musics', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'playlists_id',
            'musics_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
