<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchAlbums */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Albums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Albums', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'launchdate',
            'review',
            'genres_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
