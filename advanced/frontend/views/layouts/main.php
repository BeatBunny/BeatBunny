<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>


        <!-- FAVICON -->

            <link rel="apple-touch-icon" sizes="180x180" href="../web/images/favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="../web/images/favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="../web/images/favicon/favicon-16x16.png">
            <link rel="manifest" href="../web/images/favicon/site.webmanifest">
            <link rel="mask-icon" href="../web/images/favicon/safari-pinned-tab.svg" color="#000000">
            <meta name="apple-mobile-web-app-title" content="beatBunny">
            <meta name="application-name" content="beatBunny">
            <meta name="msapplication-TileColor" content="#000000">
            <meta name="theme-color" content="#000000">

        <!-- /FAVICON -->

        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo_only_words.png', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        /*'brandImage' => */
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Music', 'url' => ['/musics/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'Albums', 'url' => ['/albums/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {/*
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link logout']). Html::endForm(). '</li>';*/
        $menuItems[] = '<div class="dropdown"><a href="'.Url::toRoute(['/user/index']).'">
                            <button class="dropbtn">Profile</button></a>
                            <ul class="dropdown-content">
                                <li><a href="'.Url::toRoute(['/user/settings']).'">Settings</a></li>
                                
                                <li><a href="'.Url::toRoute(['/playlists/index']).'">Playlists</a></li>
                                
                                <li><a href="'. Url::toRoute(['/site/logout']) .'">Logout</a></li>
                            </ul>
                        </div>';
        $menuItems[] = ['label' => 'My Stuff', 'url' => ['/user/index']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
<!-- /*'<li>'. Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link logout']). Html::endForm(). '</li>'*/ -->
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
