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

        <p><a class="btn btn-lg btn-success" href="#">Get the App</a></p>
    </div>

    <div class="body-content" style="display: block;">

        <div class="row">
            <div class="col-lg-4">
                <h2>About the App</h2>

                <p style="display: none;">This App has only one purpose, our team needed to get a 20 mark in 4 different courses and we will get it.</p>
                <p>
                    This App was created as University Project!
                    <br><br>It's a project similar to other mass production Apps like <i>Spotify</i> or <i>SoundCloud</i>.
                    <br><br>You have the ability to buy musics that <i>Indie Producers</i> upload to our app.<br>Not only the ability to buy those songs but you can also be a Producer yourself!
                </p>
                <br>
                <p style="display: none;"><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
                <p><?php echo Html::a('I want to know more!', Url::toRoute(['site/about']), ['class' => 'btn btn-default'] )?></p>
            </div>
            <div class="col-lg-4">
                <h2>Explore our stuff</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><?php echo Html::a('Yes, show me your music list!', Url::toRoute(['', '']), ['class' => 'btn btn-default'] )?></p>
            </div>
            <div class="col-lg-4">
                <h2>Get to know us</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><?php echo Html::a('I want to know more!', Url::toRoute(['site/about-us']), ['class' => 'btn btn-default'] )?></p>
            </div>
        </div>
        <div class="row">
            
            <div>
                
            </div>

        </div>

    </div>
</div>
