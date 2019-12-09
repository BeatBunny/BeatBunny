<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseVarDumper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchAlbums */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Albums';
$this->params['breadcrumbs'][] = $this->title;
if($currentProfile->isprodutor=="S") {
    $produtor=true;
    $addAlbum= Html::a('Create Album', Url::toRoute(['albums/create']), ['class' => 'btn btn-default']);
}else{
    $addAlbum="";
    $produtor=false;
}

?>
<div class="musics-index">
    <div class="row">
        <div class="col-lg-6">  
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-6 textAlignRight h1mf">
        </div>
    </div>
    <div class="row borderTopBlack">
            <?php 
                $counterAlbum = 0;
                $counterLyrics = 0;
                if (!isset($albumsFromCurrentProfile)) {
                    if($produtor==true) {
                        echo '<h4>You have no albums available, do you want to create?</h4>';
                        echo $addAlbum;
                    }else{
                        echo '<h4>You have no albums available</h4>';
                    }
                }else{
                    foreach( $albumsFromCurrentProfile as $album ){
                        ?>
                        <div class="col-lg-12">
                            <div class="row marginTop2Percent" id="<?= $album->id ?>">
                                <div class="col-lg-2 userImage textAlignCenter borderRightBlack">
                                    <?= Html::img( "@web/uploads/". $currentUser->id ."/albumcover_". $album->id. '.png'); ?>
                                    <div class="col-lg-12"><?= $album->title ?></div>
                                    <div class="col-lg-12"><?= $album->launchdate ?></div>
                                    <div class="row  buttonAlignCenter">
                                        <div class="col-lg-12">
                                        <?php if (count($album->musics)!=null)
                                            echo '<span class="glyphicon glyphicon-eye-open eyeColorBlue" type="button" data-toggle="collapse" data-target="#collapseAlbum'.$counterAlbum.'" aria-expanded="false" aria-controls="collapseExample">
                                           </span>';?>
                                        <?= Html::a(null, Url::toRoute(['albums/update', 'id'=>$album->id]), ['class' => 'glyphicon glyphicon-pencil']); ?>
                                      <?= Html::a(null, ['/albums/delete', 'id'=>$album->id], ['class' => 'glyphicon glyphicon-trash', 'data-method'=>'post']) ?>
<!--                                        --><?php //if (count($album->musics)!=null)
//                                        echo Html::a('Delete All Musics', ['/albums/deleteallmusic', 'album' =>$album->id], ['class' => 'btn btn-default marginTop2Percent', 'data-method'=>'delete']) ?>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 collapse" id="collapseAlbum<?= $counterAlbum ?>">
                                    <?php
                                    foreach ($album->musics as $music) {
                                        $counterLyrics++;
                                        ?>
                                        <div class="col-lg-12">
                                            <!-- Modal com os Lyrics -->
                                            <div class="modal fade" id="exampleModal<?=$counterLyrics?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title floatLeft" id="exampleModalLabel"><?= $music->title ?></h4>
                                                            <button type="button" class="close floatRight" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $music->lyrics ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-4 userImageProfile textAlignCenter">
                                                        <?= Html::img( "@web/".$music->musicpath ."/image_".$music->id.'.png', ['alt'=>"User"]); ?>
                                                        <div class="row">
                                                            <div class="col-lg-12">&nbsp;</div>
                                                            <div class="col-lg-12">
                                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal<?=$counterLyrics?>">
                                                                    See Lyrics
                                                                </button>
                                                                <?= Html::a('Delete', ['/albums/musicdel', 'album' =>$album->id, 'music' =>$music->id], ['class' => 'btn btn-default', 'data-method'=>'delete']) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 borderLeftBlack borderRightBlack">
                                                        <div class="row">
                                                            <div class="col-lg-12 textAlignCenter"><h3><?= $music->title; ?></h3></div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p></p></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $music->launchdate; ?></p></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 textAlignRight">
                                                                <p>Price: </p>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <p><?= $music->pvp.'€'; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 textAlignRight">
                                                                <p>Producer: </p>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <?php
                                                                $titleToStuff = $music->producerOfThisSong;
                                                                if($currentUser->username === $music->producerOfThisSong){
                                                                    $titleToStuff = $music->producerOfThisSong ." (Hey that's you!)";
                                                                }
                                                                ?>
                                                                <p class="overflowThatBi" title="<?= $titleToStuff; ?>"><?= $titleToStuff; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">&nbsp;</div>
                                                            <div class="col-lg-8">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                                                        <audio id="player" controls <?php
                                                        echo 'src="'.Yii::getAlias('@web').'/'.$music->musicpath.'/music_'.$music->id.'_'.$music->title.'.mp3"';
                                                        ?> style="width: 100%"></audio>
                                                        <div class="col-lg-12">&nbsp;</div>
                                                        <div class="col-lg-12 textAlignCenter">
                                                            <button class="btn btn-default"><a href="#">Add to one of your playlists</a></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php  } ?>
                                </div>
                                <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                            </div>
                        </div>
                        <?php
                        $counterAlbum++;
                    }
                    echo $addAlbum;
                } ?>
        </div>
    </div>
</div>