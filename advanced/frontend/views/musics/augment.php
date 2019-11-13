<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */

$this->title = 'ERROR: ';

?>
<div class="musics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Seems like your Server doesn't let you upload songs or images with more than 2MB</h3>
    <h4>The Server provider needs to change the <b><i>php.ini</i></b> to more than 20MB. </h4>

    <p>Using <b><i>WAMP</i></b> just <b>LEFT CLICK</b> in the WAMP icon in the <b>lower right</b> area of your screen and then choose PHP and then <b>php.ini</b></p>
    <p>Search for <b>upload_max_filesize</b> and change the value</p>

</div>
