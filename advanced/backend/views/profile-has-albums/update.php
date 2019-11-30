<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasAlbums */

$this->title = 'Update Profile Has Albums: ' . $model->albums_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->albums_id, 'url' => ['view', 'albums_id' => $model->albums_id, 'profile_id' => $model->profile_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-has-albums-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
