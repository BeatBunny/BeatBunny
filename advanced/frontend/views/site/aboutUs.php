<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-4 centerThemBitches">
            <span class="userImage"><?= Html::img('@web/images/user.png', ['alt'=>"User"],[ "id"=>"userImage"]); ?></span>
            <h2>
                Oleksandr Oliynyk
            </h2>
            <p>
                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
            </p>
        </div>
        <div class="col-md-4 centerThemBitches">
            <span class="userImage"><?= Html::img('@web/images/user.png', ['alt'=>"User"],[ "id"=>"userImage"]); ?></span>
            <h2>
                Ricardo Duarte
            </h2>
            <p>
                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
            </p>
        </div>
        <div class="col-md-4 centerThemBitches">
            <span class="userImage"><?= Html::img('@web/images/user.png', ['alt'=>"User"],[ "id"=>"userImage"]); ?></span>
            <h2>
                Rui Pereira
            </h2>
            <p>
                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
            </p>
        </div>
    </div>
</div>
