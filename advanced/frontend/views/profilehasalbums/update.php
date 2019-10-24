<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileHasAlbums */

$this->title = 'Update Profile Has Albums: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'albums_id' => $model->albums_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-has-albums-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
