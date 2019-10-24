<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileHasPlaylists */

$this->title = 'Create Profile Has Playlists';
$this->params['breadcrumbs'][] = ['label' => 'Profile Has Playlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-has-playlists-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
