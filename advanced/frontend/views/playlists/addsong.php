<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Playlists */

$this->title = 'Create Playlists';
$this->params['breadcrumbs'][] = ['label' => 'Playlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlists-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
