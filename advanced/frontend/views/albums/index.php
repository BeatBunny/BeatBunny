<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchAlbums */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Albums';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    var playerSong = document.getElementById('player');
    $(document).ready(function(){
        $('.pauseSong').hide();
    });
    function playThatShit(/*id*/){
        $('.playSong').hide();
        $('.pauseSong').show();
        playerSong.play();
    }
    function pauseThatShit(/*id*/){
        $('.playSong').show();
        $('.pauseSong').hide();
        playerSong.pause();
    }
    function stopThatShit(/*id*/){
        $('.playSong').show();
        $('.pauseSong').hide();
        playerSong.stop();
    }
</script>
    <p>
        <?php //Html::a('Create Albums', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="row borderTopBlack">
    <div class="col-lg-12">
        <br>
        <div class="row">
            <div class="col-lg-4 albumCover textAlignCenter">
                <?= Html::img('@web/images/albumImage/al1.jpg'); ?>
            </div>
            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                <div class="row">
                    <div class="col-lg-12 textAlignCenter"><h2>TITLE</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p>Metal</p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
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
                    <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                    <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                    <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                    <?php }else { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <br>
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                <div class="row">
                    <div class="col-lg-12 textAlignCenter"><h2>TITLE</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p>Metal</p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
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
                    <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                    <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                    <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                    <?php }else { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <br>
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                <div class="row">
                    <div class="col-lg-12 textAlignCenter"><h2>TITLE</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p>Metal</p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
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
                    <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                    <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                    <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                    <?php }else { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row borderTopBlack">
    <div class="col-lg-12">
        <br>
        <div class="row">
            <div class="col-lg-4 albumCover textAlignCenter">
                <?= Html::img('@web/images/albumImage/al2.jpg'); ?>
            </div>
            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                <div class="row">
                    <div class="col-lg-12 textAlignCenter"><h2>TITLE</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p>Metal</p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
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
                    <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                    <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                    <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                    <?php }else { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <br>
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                <div class="row">
                    <div class="col-lg-12 textAlignCenter"><h2>TITLE</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p>Metal</p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
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
                    <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                    <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                    <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                    <?php }else { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <br>
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                <div class="row">
                    <div class="col-lg-12 textAlignCenter"><h2>TITLE</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p>Metal</p></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
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
                    <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                    <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                    <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                    <?php }else { ?>
                        <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
