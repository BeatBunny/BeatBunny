<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use frontend\models\Albuns;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Your Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row borderTopBlack">
        <div class="col-lg-12">
            <br>
            <div class="row">
                <div class="col-lg-4 userImageProfile userProfileCol textAlignCenter">
                    <h2 class="textAlignCenter">You</h2>
                    <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?></div>
                <div class="col-lg-4 userProfileCol">
                    <h2 class="textAlignCenter">Your Info</h2>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Name: </p></div><div class="col-lg-8"><p><?= $profileProvider->nome; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>NIF: </p></div><div class="col-lg-8"><p><?= $profileProvider->nif; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Wallet: </p></div><div class="col-lg-8"><p><?= $profileProvider->saldo; ?> €</p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">&nbsp;</div>
                        <div class="col-lg-8">
                            <button class="btn btn-default">Change Settings</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                    <h2 class="textAlignCenter">Your Albuns</h2>
                    <?php
                        
                        foreach ($profileProvider->albums as $album) {
                            echo $album->title;
                            echo $album->launchdate;
                            echo $album->review;
                        }

                    ?>
                </div>
            </div>

            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>

            <div class="col-lg-12 textAlignCenter">

                <h2 class="textAlignCenter ">Your Creations</h2>
                <?php 
                    if ($profileProvider->isprodutor == 'S')
                    {
                        foreach ($profileProvider->musics as $music) {
                            echo $music->title;
                        }
                    } 
                    else
                    {
                ?>
                        <p>You are not a Producer... Yet! Want to be one? Send us some of your songs!</p>
                        <button class="btn btn-default textAlignCenter">Let's Go!</button>
                <?php
                    }
                ?>
            </div>
            
            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
            <div class="col-lg-6 userProfileCol">

                <h2 class="textAlignCenter">Your Purchases</h2>
                <?php
                    
                    foreach ($profileProvider->vendas as $vendas) {
                        echo $vendas;
                    }

                ?>
            </div>


            <div class="col-lg-6">

                <h2 class="textAlignCenter">Your Playlists</h2>
                <?php
                    
                    foreach ($profileProvider->playlists as $playlist) {
                        echo $playlist->nome;
                    }

                ?>
            </div>


        </div>
    </div>


</div>
