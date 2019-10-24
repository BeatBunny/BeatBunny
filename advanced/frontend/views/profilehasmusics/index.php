<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchProfileHasMusics */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profile Has Musics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-has-musics-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Profile Has Musics', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'profile_id',
            'musics_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
