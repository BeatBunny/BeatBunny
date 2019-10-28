<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'beatBunny';
?>
<div class="backgroundTeste"></div>
<div class="site-index ">
    <div class="jumbotron">
        <h1>Welcome to <strong>beatBunny</strong></h1>

        <p class="lead" style="visibility: hidden;">Welcome to beatBunny</p>

        <p><a class="btn btn-lg getTheAppClass" href="#" style="width: 100%"><?= Html::img('@web/images/logo_horizontal_white.png', ['alt'=>""],[ "id"=>"userImage"]); ?>Get the App<?= Html::img('@web/images/logo_horizontal_white.png', ['alt'=>""],[ "id"=>"userImage"]); ?></a></p>
    </div>

    <div class="body-content" style="display: block;">

        <div class="row">
            <div class="col-lg-4">
                <div class="col-lg-12">
                    <h2>About the App</h2>

                    <p style="display: none;">This App has only one purpose, our team needed to get a 20 mark in 4 different courses and we will get it.</p>
                    <p>
                        This App was created as University Project!
                        <br><br>It's a project similar to other mass production Apps like <i>Spotify</i> or <i>SoundCloud</i>.
                        <br><br>You have the ability to buy musics that <i>Indie Producers</i> upload to our app.<br>Not only the ability to buy those songs but you can also be a Producer yourself!
                    </p>
                    <br>
                </div>
                <div class="col-lg-12">
                    <p><?php echo Html::a('I want to know more!', Url::toRoute(['site/about']), ['class' => 'btn btn-default width100 padding5'] )?></p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-lg-12">
                <h2>Explore our stuff</h2>

                <p>Our team, with the help of <i>Indie Producers</i>, is now able to bring you the music you actually deserve.<br><br>Feel free to scroll through our music database and enjoy.</p>

                <br>
                </div>
                <div class="col-lg-12">
                    <p><?php echo Html::a('Yes, show me your music list!', Url::toRoute(['musics/index']), ['class' => 'btn btn-default width100 padding5'] )?></p>
                </div>
            </div>
            <div class="col-lg-4">
                <h2>Get to know us</h2>

                <p>We are a group of friends from <i>Instituto Politécnico de Leiria</i> - <i>Escola de Tecnologia e Gestão</i> from the course <i>Programação de Sistemas de Informação</i></p>

                <br>
                <p><?php echo Html::a('Know more about you? Yes please!', Url::toRoute(['site/about-us']), ['class' => 'btn btn-default width100 padding5'] )?></p>
            </div>
        </div>
        <div class="row">
            
            <div>
                
            </div>

        </div>

    </div>
</div>
