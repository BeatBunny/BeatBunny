<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Albuns;
use yii\helpers\Url;
use yii\helpers\BaseVarDumper;

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
                            <p><?= $profileProvider->saldo; ?> €</p>
                        </div>
                        <div class="col-lg-4 textAlignRight"><button class="btn btn-default "><?php echo Html::a('Add funds', Url::toRoute(['/profile/wallet']))?><a></a></button></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">&nbsp;</div>
                        <div class="col-lg-8">
                            <button class="btn btn-default"><?php echo Html::a('Change Settings', Url::toRoute(['/user/settings']))?></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 textAlignCenter">

                    <h2 class="">Your Albuns</h2>

                    <?php 
                    if ($profileProvider->isprodutor == 'S')
                    {
                        if(count($profileProvider->albums) == 0){ 
                            if($numberOfSongsYouHave == 0){?>


                                <div class="col-lg-12 ">
                                    <p>You are a producer! But you dont have any songs to create an album.<br><br><br>Want to upload some?</p>
                                    <button class="btn btn-default"><?php echo Html::a('Upload Song', Url::toRoute(['/musics/create']))?></button>
                                </div>

                            <?php
                            }
                            else{
                                ?>

                                <div class="col-lg-12 ">
                                    <p>You are a producer! But you dont have any albums...<br><br><br>Want to create one?</p>
                                    <button class="btn btn-default"><?php echo Html::a('Create Album', Url::toRoute(['/albums/create']))?></button>
                                </div>
                            <?php
                            }
                        }
                        else{
                            foreach ($profileProvider->albums as $album) {
                                echo $album->title;
                                echo $album->launchdate;
                                echo $album->review;
                            }
                        }
                    } 
                    else
                    {
                ?>
                    <div class="textAlignCenter">
                        <p class="textAlignCenter">You're not a Producer... Yet! Want to be one? Send us some of your songs!</p>
                        <button class="btn btn-default"><?php echo Html::a('Let\'s Go!', Url::toRoute(['/site/contact']))?></button>
                    </div>
                <?php
                    }
                ?>
                </div>
            </div>

            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>

            <div class="col-lg-12">

                <h2 class="textAlignCenter ">Your Creations
                <?php 
                    if($profileProvider->isprodutor == 'S' && $numberOfSongsYouHave > 0) {
                            echo '<button class="btn btn-default marginLeft2Percent">';
                            echo '<a href="'.Url::toRoute(['/musics/create']).'">'.'Upload Song'.'</a>'; 
                            echo '</button>';  
                    } ?> 
                </h2> 
                <?php 
      
                    if ($profileProvider->isprodutor == 'S')
                    {
                        if($numberOfSongsYouHave > 0) {
                            foreach ($arrayComAsTuasMusicas as $musica) { ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 userImageProfile textAlignCenter">
                                                <div class="row">
                                                    <div class="col-lg-12 userImageProfile">
                                                        <?= Html::img('uploads/'.$userProvider->id ."/image_".$musica->id.'.png', ['alt'=>"User"]); ?>
                                                    </div>
                                                </div>
                                                <div class="row marginTop2Percent">
                                                    <div class="col-lg-12 ">
                                                        <button class="btn btn-default"><?php echo Html::a('Edit Music', Url::toRoute(['/musics/update', 'id' => $musica->id]))?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                                                <div class="row">
                                                    <div class="col-lg-12 textAlignCenter"><h3><?= $musica->title ?></h3></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 textAlignRight"><p>Genre: </p></div><div class="col-lg-6"><p><?= $musica->genres->nome; ?></p></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-6 textAlignLeft"><p><?= $musica->launchdate ?></p></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 textAlignRight"><p>Price: </p></div><div class="col-lg-6 textAlignLeft"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $musica->pvp ?>€</p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">&nbsp;</div>
                                                    <div class="col-lg-8">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                                                <audio id="player" controls  src="<?= "uploads/".$userProvider->id."/music_".$musica->id."_".$musica->title.".mp3" ?>" style="width: 100%"></audio>
                                                <!-- controlsList="nodownload" -->
                                                <div class="col-lg-12">&nbsp;</div>
                                                <div class="col-lg-12 textAlignCenter">

                                                    
                                                    <?php if (!Yii::$app->user->isGuest) { ?>
                                                        <button class="btn btn-default"><a href="#">Add to one of your playlists</a></button>
                                                    <?php }else { ?>
                                                        <button class="btn btn-default"><a href="#">Buy this song!</a></button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php
                                    if(count($profileProvider->musics) > 1)
                                        echo "<div class=\"col-lg-12 marginTop2Percent borderTopBlack\">&nbsp;</div>";
                                    ?>
                                </div>

                            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                            <?php
                            }
                        }
                        else{
                            ?>
                            <div class="row textAlignCenter">
                                <br>
                                <div class="col-lg-12">
                                    <p>You are a producer! But you dont have any songs for sale...<br><br><br>Want to upload some?</p>
                                    <button class="btn btn-default playSong"><?php echo Html::a('Upload Song', Url::toRoute(['/musics/create']))?></button>
                                </div>
                            </div>

                        <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                            <?php
                        }
                    } 
                    else
                    {
                ?>
                    <div class="textAlignCenter">
                        <p class="textAlignCenter">You're not a Producer... Yet! Want to be one? Send us some of your songs!</p>
                        <button class="btn btn-default"><?php echo Html::a('Let\'s Go!', Url::toRoute(['/site/contact']))?></button>
                    </div>
                    <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                <?php
                    }
                ?>
            </div>
            
            <div class="col-lg-6  borderRightBlack textAlignCenter">

                <h2 class="textAlignCenter">Your Purchases</h2>
                <?php
                    foreach ($profileProvider->vendas as $vendas) {
                        //echo $vendas;
                    }
                ?>
                <br>
                <?php if(isset($musicasCompradasPeloUserObjeto_UsarEmForeach)){ ?>
                <button class="btn btn-default marginBottom2Percent" type="button" data-toggle="collapse" data-target="#collapsePurchases" aria-expanded="false" aria-controls="collapseExample">View All</button>
                <div class="collapse" id="collapsePurchases">
                    <?php
                    foreach ($musicasCompradasPeloUserObjeto_UsarEmForeach as $musicaComprada) { ?>
                        <div class="row marginBottom2Percent">
                            <div class="col-lg-6 ">
                                <div class="row">
                                    <div class="col-lg-12 textAlignCenter"><h3><?= $musicaComprada->title ?></h3></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?= $musicaComprada->genres->nome ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $musicaComprada->launchdate ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><p><?= $musicaComprada->pvp ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Producer: </p></div><div class="col-lg-8"><p><?= $musicaComprada->producerOfThisSong; ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">&nbsp;</div>
                                    <div class="col-lg-8">
                                        
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 userImageProfile textAlignCenter borderLeftBlack">
                                <?= Html::img($musicaComprada->musicpath ."/image_".$musicaComprada->id.'.png', ['alt'=>"User"]); ?> 
                                <div class="row">
                                    <div class="col-lg-12 textAlignCenter marginTop2Percent">

                                        <audio id="player" controls src="<?= $musicaComprada->musicpath."/music_".$musicaComprada->id."_".$musicaComprada->title.".mp3" ?>" style="width: 100%"></audio>
                                   </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 marginTop2Percent">
                                            <button class="btn btn-default"><a href="#">Add to one of your playlists</a></button>
       
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php }else{
                ?>
                    <div class="textAlignCenter">
                        <p class="textAlignCenter">You still down own any of our songs! Want to buy some?</p>
                        <button class="btn btn-default"><?php echo Html::a('Take me there!', Url::toRoute(['/musics/index']))?></button>
                    </div>
                <?php
            } ?>

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
