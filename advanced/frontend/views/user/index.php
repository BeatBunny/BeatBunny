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


<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row borderTopBlack">
        <div class="col-lg-12">
            <br>
            <div class="row">
                <div class="col-lg-4 userImageProfile textAlignCenter">
                    <h2 class="textAlignCenter">You</h2>
                    <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?></div>
                <div class="col-lg-4 borderLeftBlack borderRightBlack">
                    <h2 class="textAlignCenter">Your Info</h2>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Username: </p></div><div class="col-lg-8"><p><?= $userProvider->username; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Email: </p></div><div class="col-lg-8"><p class="overflowThatBi" title="<?= $userProvider->email; ?>"><?= $userProvider->email; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Name: </p></div><div class="col-lg-8"><p><?= $profileProvider->nome; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>NIF: </p></div><div class="col-lg-8"><p><?= $profileProvider->nif; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Balance: </p></div>
                        <div class="col-lg-4">
                            <p><?php $newSaldo = substr($profileProvider->saldo,0,4); echo $newSaldo; ?> €</p>
                        </div>
                        <div class="col-lg-4 textAlignRight"><button class="btn btn-default ">Add funds</button></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">&nbsp;</div>
                        <div class="col-lg-8">
                            <button class="btn btn-default" href="<?='Url::toRoute([/user/settings])'?>">Change Settings</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                    <h2 class="textAlignCenter">Your Albuns</h2>

                    <?php 
                    if ($profileProvider->isprodutor == 'S')
                    {
                        foreach ($profileProvider->albums as $album) {
                            echo $album->title;
                            echo $album->launchdate;
                            echo $album->review;
                        }
                    } 
                    else
                    {
                ?>
                    <div class="textAlignCenter">
                        <p class="textAlignCenter">You're not a Producer... Yet! Want to be one? Send us some of your songs!</p>
                        <button class="btn btn-default">Let's Go!</button>
                    </div>
                <?php
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
                    <div class="textAlignCenter">
                        <p class="textAlignCenter">You're not a Producer... Yet! Want to be one? Send us some of your songs!</p>
                        <button class="btn btn-default">Let's Go!</button>
                    </div>
                <?php
                    }
                ?>
            </div>
            
            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
            <div class="col-lg-6  borderRightBlack">

                <h2 class="textAlignCenter">Your Purchases</h2>
                <?php
                    foreach ($profileProvider->vendas as $vendas) {
                        //echo $vendas;
                    }
                ?>
                <div class="row">
                    <div class="col-lg-6 borderRightBlack">
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


                    <div class="col-lg-6 userImageProfile textAlignCenter">
                        <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
                        <div class="row">
                            <div class="col-lg-12 textAlignCenter marginTop2Percent">

                                <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                                <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                                <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 marginTop2Percent">
                                <?php if (!Yii::$app->user->isGuest) { ?>
                                    <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                                <?php }else { ?>
                                    <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="display: none;">
                        <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                        <audio id="player" controls src="sound.mp3" style="width: 100%; display: none;"></audio>
                        
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12 textAlignCenter">

                            <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                            <button class="btn btn-default pauseSong" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                            <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <button class="btn btn-default marginTop2Percent" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                            <?php }else { ?>
                                <button class="btn btn-default marginTop2Percent" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>

                <div class="row">
                    <div class="col-lg-6 borderRightBlack">
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


                    <div class="col-lg-6 userImageProfile textAlignCenter">
                        <?= Html::img('@web/images/user.png', ['alt'=>"User"],[ 'id'=>"userImage"]); ?>
                        <div class="row">
                            <div class="col-lg-12 textAlignCenter marginTop2Percent">

                                <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                                <button class="btn btn-default pauseSong displayNone" onclick="pauseThatShit(/*THIS SONG ID*/)" style="display: none;"><i class="fa fa-pause-circle"></i></button>
                                <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 marginTop2Percent">
                                <?php if (!Yii::$app->user->isGuest) { ?>
                                    <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                                <?php }else { ?>
                                    <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="display: none;">
                        <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                        <audio id="player" controls src="sound.mp3" style="width: 100%; display: none;"></audio>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12 textAlignCenter">
                            <button class="btn btn-default playSong" onclick="playThatShit(/*THIS SONG ID*/)"><i class="fa fa-play-circle"></i></button>
                            <button class="btn btn-default pauseSong displayNone" onclick="pauseThatShit(/*THIS SONG ID*/)"><i class="fa fa-pause-circle"></i></button>
                            <button class="btn btn-default stopSong" onclick="stopThatShit(/*THIS SONG ID*/)"><i class="fa fa-stop-circle"></i></button>
                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <button class="btn btn-default marginTop2Percent" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Add to one of your playlists</a></button>
                            <?php }else { ?>
                                <button class="btn btn-default marginTop2Percent" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Buy this song!</a></button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 ">

                <h2 class="textAlignCenter">Your Playlists</h2>
                <?php
                    
                    foreach ($profileProvider->playlists as $playlist) {
                        //echo $playlist->nome;
                    }

                ?>
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="row">
                            <div class="col-lg-12 textAlignCenter"><h2>PLAYLIST</h2></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Genres: </p></div><div class="col-lg-8"><p class="overflowThatBi" title="Metal, Pop, Rock, Death Metal, Metal is love Metal is Life">Metal, Pop, Rock, Death Metal, Metal is love Metal is Life</p></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Creation Date:<br> </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
                        </div>
                        <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
                        <div class="row">
                            <div class="col-lg-3 textAlignCenter">&nbsp;</div> 
                            <div class="col-lg-6 textAlignCenter">                                  
                                <button class="btn btn-default Percent100" ><a>View Playlist</a></button>
                            </div> 
                        </div>

                        <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
                    </div>
                </div>


                <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>

                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="row">
                            <div class="col-lg-12 textAlignCenter"><h2>PLAYLIST</h2></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Genres: </p></div><div class="col-lg-8"><p class="overflowThatBi" title="Metal, Pop, Rock, Death Metal, Metal is love Metal is Life">Metal, Pop, Rock, Death Metal, Metal is love Metal is Life</p></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Creation Date:<br> </p></div><div class="col-lg-8"><p>XX/XX/XXXX</p></div>
                        </div>
                        <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
                        <div class="row">
                            <div class="col-lg-3 textAlignCenter">&nbsp;</div> 
                            <div class="col-lg-6 textAlignCenter">                                  
                                <button class="btn btn-default Percent100" ><a>View Playlist</a></button>
                            </div> 
                        </div>

                        <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
        </div>
    </div>
</div>
