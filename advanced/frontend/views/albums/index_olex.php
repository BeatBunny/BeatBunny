<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchAlbums */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Albums';
$this->params['breadcrumbs'][] = $this->title;

?>


<h1><?= Html::encode($this->title); ?></h1>
<div class="row borderTopBlack">
    <div class="col-lg-12">
        <br>
        <div class="row">
            <?php foreach ($albumsFromCurrentProfile as $album ) { ?>
            <div class="col-lg-3 albumCover textAlignCenter">
                    <?= Html::img('@web/images/albumImage/al5-.png') ?>
            </div>
                <div class="row">
                    <div class="col-lg-4">&nbsp;</div>
                    <div class="col-lg-8"></div>
                </div>
                <div class="col-lg-4 borderLeftBlack borderTopBlack">
                    <div class="row">
                        <div class="col-lg-12 textAlignCenter"><h2><?= $album->title ?></h2></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div>
                        <div class="col-lg-8"><p><?= $album->launchdate ?></p></div>
                    </div>
                    <div class="row borderBottomBlack buttonAlignCenter">
                        <button class="align-content-center searchButton " type="button" data-toggle="collapse"
                                data-target="#collapseMusica" aria-expanded="false"
                                aria-controls="collapseExample"> Si vai!
                        </button>
                    </div>
                </div>
                    <div class="col-lg-4 borderRightBlack borderBottomBlack borderLeftBlack collapse"
                         id="collapseMusica">
                       
                        <?php foreach ($album as $music) { ?>
                            <div class="row borderTopBlack">
                                <div class="col-lg-4 textAlignRight "><p>Title </p></div>
                                <div class="col-lg-8"><p><?= $music->title ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div>
                                <div class="col-lg-8"><p><?= $music->launchdate ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Rating: </p></div>
                                <div class="col-lg-8"><p>
                                        <?php for ($i = 0; $i < $music->rating; $i++) {
                                            echo '<span class="fa fa-star checked colorYellow"></span>';
                                        }?>
                                            
                                        </p></div>
                            </div>
                        } 
                    } ?>
                    </div>
                    <div class="row collapse" id="collapseMusica">
                        <div class="col-lg-4">
                            <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                            <audio id="player" controls src="sound.mp3" style="width: 100%"></audio>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 textAlignCenter">
                                <button class="btn btn-default playSong"><i
                                            class="fa fa-play-circle"></i></button>
                                <button class="btn btn-default pauseSong" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                                <button class="btn btn-default stopSong"><i class="fa fa-stop-circle"></i></button>
                                <button class="btn btn-default"><a href="#">Add to
                                        one of your playlists</a></button>
                                <button class="btn btn-default"><a href="#">Buy
                                        this song!</a></button>
                                
                            </div>
                        </div>
                </div>
        </div>
    </div>
</div>
