<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchProfileHasPlaylists */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profile Has Playlists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-has-playlists-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Profile Has Playlists', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'profile_id',
            'playlists_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?> 

    <?php Pjax::end(); ?>

</div>
