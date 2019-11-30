<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Playlists */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Playlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="playlists-view">
    <h1><?= Html::encode($this->title) ?></h1>
        <div class="row borderTopBlack">
            <div class="col-lg-12 ">
                <div class="row">
                    <div class="col-lg-8 textAlignLeft"><h2><?php echo $model->nome?></h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Creation Date:<br> </p></div><div class="col-lg-8"><p><?php echo $model->creationdate ?></p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genres:<br> </p></div><div class="col-lg-8"><p>
                            <?php

                            if(empty($model->generosDaPlaylist))
                                echo "None defined yet";
                            else{
                                foreach ($model->generosDaPlaylist as $listar) {
                                    echo $listar;
                                }
                            }
                            ?></p>
                    </div>
                </div>
            </div>
            <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
            </div>
            <?php
            if(empty($model->musics)) {
                echo Html::a('Go add songs to your playlist', Url::toRoute(['/musics/index']), ['class' => 'btn btn-default']);
                echo '<br><br>';
            }
            else { ?>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsePlaylist" aria-expanded="false" aria-controls="collapseExample">
                Open playlist
            </button>
            <br>
            <div class="collapse" id="collapsePlaylist">
                <?php foreach ($model->musics as $music) { ?>
                    <div class="row borderTopBlack">
                        <div class="col-lg-12">
                            <br>
                            <div class="row">
                                <div class="col-lg-4 userImageProfile textAlignCenter">
                                    <?= Html::img( "@web/".$music->musicpath ."/image_".$music->id.'.png', ['alt'=>"User"]); ?>
                                </div>
                                <div class="col-lg-4 borderLeftBlack borderRightBlack">
                                    <div class="row">
                                        <div class="col-lg-12 textAlignCenter"><h2><?= $music->title ?></h2></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?= $music->genres->nome ?></p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $music->launchdate ?></p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><?php if (!Yii::$app->user->isGuest) { ?><p>XX€</p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">&nbsp;</div>
                                        <div class="col-lg-8">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                                    <audio id="player" controls src="sound.mp3" style="width: 100%"></audio>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12 textAlignCenter">
                                        <?php if (!Yii::$app->user->isGuest) { ?>
                                            <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Remove from this playlist</a></button>
                                        <?php }else { ?>
                                            <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <br>
                <?php } ?>
                </div>
            <br>
        <?php } ?>
</div>

