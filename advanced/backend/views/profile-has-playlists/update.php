<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasPlaylists */

$this->title = 'Update Profile Has Playlists: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Playlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'playlists_id' => $model->playlists_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-has-playlists-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
