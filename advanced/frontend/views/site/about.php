<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row" style="margin-top: 5%;">
        <div class="col-md-12">
            <p>
                This App was created as University Project!
            </p>
            <p> 
                It's a project similar to other mass production Apps like <i>Spotify</i> or <i>SoundCloud</i>.
            </p>
            <p>
                You have the ability to buy musics that <i>Indie Producers</i> upload to our app.
            </p>
            <br>
            <p>
                Not only the ability to buy those songs but you can also be a Producer yourself, all you have to do is email-us and send us some songs of yours to become one.
            </p>
            <br>
            <p>
                <?php echo Html::a('Be a Producer!', Url::toRoute(['']), ['class' => 'btn btn-default'] )?>
            </p>
        </div>
    </div>
    

    <code style="display: none;"><?= __FILE__ ?></code>
</div>
