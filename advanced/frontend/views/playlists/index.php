<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
use yii\grid\GridView;
use yii\helpers\BaseVarDumper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPlaylists */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Playlists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlists-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p style="display: none;">
        <?= Html::a('Return to Profile', ['user/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $counter = 0;
    foreach ($playlistsUserLogado as $playlist) {
        $counter++;
        ?>
    <?php
    /*BaseVarDumper::dump($playlistsUserLogado);
    die();*/
    ?>
    <div class="row borderTopBlack">
        <div class="col-lg-12 ">
            <div class="row">
                <div class="col-lg-8 textAlignLeft"><h2><?php echo $playlist->nome?></h2></div>
            </div>
            <div class="row">
                <div class="col-lg-4 textAlignRight"><p>Creation Date:<br> </p></div><div class="col-lg-8"><p><?php echo $playlist->creationdate ?></p></div>
            </div>
            <div class="row">
                <div class="col-lg-4 textAlignRight"><p>Genres:<br> </p></div><div class="col-lg-8"><p>
                    <?php
<<<<<<< HEAD
//                    foreach ( $generos as $genre ){
//
//                            echo $genre;
//                            echo " ";
//                    }
                            foreach ($playlist->generosDaPlaylist as $listar) {
                                echo $listar;
                            }
=======
                        if(empty($playlist->generosDaPlaylist))
                            echo "None defined yet";
                        else{
                            foreach ($playlist->generosDaPlaylist as $listar) {
                                echo $listar;
                            }
                        }
>>>>>>> b3c5225b71f5a21fe919e4385d870a0cf8d550f7
                        ?></p>
                </div>
            </div>
        </div>
        <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
    </div>
    <?php
    if(empty($playlist->musics)) {
        echo Html::a('Go add songs to your playlist', Url::toRoute(['/musics/index']), ['class' => 'btn btn-default']);
        echo '<br><br>';
        }
    else { ?>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsePlaylist<?php echo $counter ?>" aria-expanded="false" aria-controls="collapseExample">
        Open playlist
    </button>
    <br>
    <div class="collapse" id="collapsePlaylist<?php echo $counter; ?>">
        <?php foreach ($playlist->musics as $music) { ?>
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
<?php } ?>