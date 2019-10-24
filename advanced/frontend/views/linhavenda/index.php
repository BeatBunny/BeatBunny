<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchLinhavenda */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Linhavendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhavenda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Linhavenda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'precoVenda',
            'venda_id',
            'musics_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
