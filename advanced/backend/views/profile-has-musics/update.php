<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileHasMusics */

$this->title = 'Update Profile Has Musics: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Musics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'musics_id' => $model->musics_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-has-musics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
