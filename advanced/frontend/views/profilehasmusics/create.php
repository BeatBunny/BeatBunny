<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileHasMusics */

$this->title = 'Create Profile Has Musics';
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-has-musics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
