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
if ($currentProfile->isprodutor == 'S') {
    $addAlbum = Html::a('Create Album', Url::toRoute(['albums/create']), ['class' => 'btn btn-default']);
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
        $counterMusic = 0;
        if(count($albums) > 0) {
            foreach ($albums as $album) {
                ?>
                <div class="col-lg-12">
                    <div class="row marginTop2Percent" id="<?= $album->id ?>">
                        <div class="col-lg-2 userImage textAlignCenter borderRightBlack">
                            <?= Html::img("@web/uploads/" . $currentUser->id . "/albumcover_" . $album->id . '.png'); ?>
                            <div class="col-lg-12"><?= $album->title ?></div>
                            <div class="col-lg-12"><?= $album->launchdate ?></div>
                            <div class="row  buttonAlignCenter">
                                <div class="col-lg-12">
                                    <?php if (count($albums) != null)
                                        echo '<span class="glyphicon glyphicon-eye-open eyeColorBlue" type="button" data-toggle="collapse" data-target="#collapseAlbum' . $counterAlbum . '" aria-expanded="false" aria-controls="collapseExample">
                                           </span>'; ?>
                                    <?= Html::a(null, Url::toRoute(['albums/update', 'id' => $album->id]), ['class' => 'glyphicon glyphicon-pencil']); ?>
                                    <?= Html::a(null, ['/albums/delete', 'id' => $album->id], ['class' => 'glyphicon glyphicon-trash', 'data-method' => 'post']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 collapse" id="collapseAlbum<?= $counterAlbum ?>">
                            <?php
                            foreach ($album->musics as $music) {
                                $counterMusic++;
                                ?>
                                <div class="col-lg-12">
                                    <!-- Modal com os Lyrics -->
                                    <div class="modal fade" id="exampleModal<?= $counterMusic ?>" tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title floatLeft"
                                                        id="exampleModalLabel"><?= $music->title ?></h4>
                                                    <button type="button" class="close floatRight"
                                                            data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?= $music->lyrics ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 userImageProfile textAlignCenter">
                                                <?= Html::img("@web/" . $music->musicpath . "/image_" . $music->id . '.png', ['alt' => "User"]); ?>
                                                <div class="row">
                                                    <div class="col-lg-12">&nbsp;</div>
                                                    <div class="col-lg-12">
                                                        <button type="button" class="btn btn-default"
                                                                data-toggle="modal"
                                                                data-target="#exampleModal<?= $counterMusic ?>">
                                                            See Lyrics
                                                        </button>
                                                        <?= Html::a('Delete', ['/albums/musicdel', 'album' => $album->id, 'music' => $music->id], ['class' => 'btn btn-default', 'data-method' => 'delete']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                                                <div class="row">
                                                    <div class="col-lg-12 textAlignCenter">
                                                        <h3><?= $music->title; ?></h3></div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div>
                                                    <div class="col-lg-8"><p></p></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p>
                                                    </div>
                                                    <div class="col-lg-8"><p><?= $music->launchdate; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 textAlignRight">
                                                        <p>Price: </p>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p><?= $music->pvp . '€'; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 textAlignRight">
                                                        <p>Producer: </p>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <?php
                                                        $titleToStuff = $music->profile->user->username;
                                                        if (!Yii::$app->user->isGuest) {
                                                            if ($currentUser->username === $music->profile->user->username) {
                                                                $titleToStuff = $music->profile->user->username . " (Hey that's you!)";
                                                            }
                                                        }
                                                        ?>
                                                        <p class="overflowThatBi"
                                                           title="<?= $titleToStuff; ?>"><?= $titleToStuff; ?></p>
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
                                                echo 'src="' . Yii::getAlias('@web') . '/' . $music->musicpath . '/music_' . $music->id . '_' . $music->title . '.mp3"';
                                                ?> style="width: 100%"></audio>
                                                <div class="col-lg-12">&nbsp;</div>
                                                <div class="col-lg-12 textAlignCenter">
                                                    <?php if (count($currentProfile->playlists)){?>
                                                    <button type="button" class="btn btn-default " data-toggle="modal" data-target="#exampleModalPlaylist<?=$counterMusic?>">Add to one of
                                                            your
                                                            playlists
                                                    </button>
                                                </div>
                                                <div class="modal fade textAlignCenter" id="exampleModalPlaylist<?=$counterMusic?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="<?= "../albums/addtoplaylist" ?>">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title floatLeft" id="exampleModalLabel"><?= $music->title ?></h4>
                                                                    <button type="button" class="close floatRight" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" id="musics_id" name="musics_id" value="<?= $music->id ?>">
                                                                    <select name="playlists_id" id="playlists_id">
                                                                        <?php
                                                                        foreach($playlists as $playlist) { ?>
                                                                            <option value="<?= $playlist->id ?>"><?= $playlist['nome'] ?></option>
                                                                            <?php
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer textAlignRight">
                                                                    <input class="btn btn-primary" type="submit" value="Add to this playlist">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php }else{?>
                                                        <button class="btn btn-default"">
                                                        <?php echo Html::a('Create playlist!', Url::toRoute(['/playlists/create']));
                                                    }?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                    </div>
                </div>
                <?php
                $counterAlbum++;
            }
        }
        else
            echo '<h4>You dont have any album, want to create some?</h4>';
        echo $addAlbum;
        ?>
    </div>
</div>
</div>