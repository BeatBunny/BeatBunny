<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasAlbums */

$this->title = 'Create Profile Has Albums';
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-has-albums-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
