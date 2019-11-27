<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row" style="margin-top: 5%;">
        <div class="col-md-4 centerThemBitches">
            <span class="userImage"><?= Html::img('@web/images/about-us/olex.png', ['alt'=>"User"],[ "id"=>"userImage"]); ?></span>
            <h2>
                Oleksandr Oliynyk
            </h2>
            <p>
                Hey! I'm Oleksandr Oliynyk currently a finalist in Leiria's Polytechnic Institute (IPL).
            </p>
            <p>
                I’m the Slav member of this group, that enjoys sports and listening to some good music, that was one of reasons that made me take part of this project.
            </p><p>

            </p>
        </div>
        <div class="col-md-4 centerThemBitches">
            <span class="userImage"><?= Html::img('@web/images/about-us/ricardo.png', ['alt'=>"User"],[ "id"=>"userImage"]); ?></span>
            <h2>
                Ricardo Duarte
            </h2>
            <p>
                Hey! I'm Ricardo Duarte, currently a finalist in Leiria's Polytechnic Institute (IPL).
            </p>
            <p>
                I enjoy my free time as much as the next guy, although I usually spend it playing FPS games like Apex Legends. Besides playing videogames whenever I have the chance, my love for music is overwhelming. Currently my favourite artists are: <i>Slipknot</i> and <i>Unlike Pluto</i>.
            </p>
            <p>
                Let's put in this way, working with Yii2 has been somewhat of a passive/agressive relationship whether we hate and we love eachother. 
            </p>
        </div>
        <div class="col-md-4 centerThemBitches">
            <span class="userImage"><?= Html::img('@web/images/about-us/rui.png', ['alt'=>"User"],[ "id"=>"userImage"]); ?></span>
            <h2>
                Rui Pereira
            </h2>
            <p>
                Hey! I'm Rui Pereira, currently a finalist in Leiria's Polytechnic Institute (IPL).
            </p>
            <p>
                I love my free time, playing games alongside to listening to music is just the way to go, so developing the BeatBunny has been a fun and easily enjoyable work assignment.
            </p>
            <p>
                Working in Yii2 is being a truly worthy experience, the feeling when everything clicks is what keeps me inspired to learn.
            </p>
        </div>
    </div>
</div>
