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
    <div class="row">
        <div class="col-lg-12">  
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

    </div>

    <div class="row borderTopBlack">
        <div class="col-lg-12">
            <br>
            <div class="row">
                <div class="col-lg-4 userImageProfile textAlignCenter">
                    <h2 class="textAlignCenter">You</h2>
                    <?php
                    if(is_null($profileProvider->profileimage))
                        echo Html::img('@web/images/user.png', ['alt'=>"User"],[ "id"=>"userImage"]);
                    else
                        echo Html::img( "@web/uploads/".$userProvider->id."/profileimage_".$userProvider->id.'.png', ['alt'=>"User"]);

                    ?>    
                </div>
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
                        <div class="col-lg-4 textAlignRight"><?php echo Html::a('Add funds', Url::toRoute(['/profile/wallet']), ['class' => 'btn btn-default'])?></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">&nbsp;</div>
                        <div class="col-lg-8">
                            <?php echo Html::a('Change Settings', Url::toRoute(['/user/settings']), ['class' => 'btn btn-default'])?>
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
                                    <p>You are a producer! But you dont have any songs to create an album.<br><br><br>Want to upload some?</p><?php echo Html::a('Upload Song', Url::toRoute(['/musics/create']), ['class' => 'btn btn-default'])?>
                                </div>

                            <?php
                            }
                            else{
                                ?>

                                <div class="col-lg-12 ">
                                    <p>You are a producer! But you dont have any albums...<br><br><br>Want to create one?</p>
                                    <?php echo Html::a('Create Album', Url::toRoute(['/albums/create']), ['class' => 'btn btn-default'])?>
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
                        <p class="textAlignCenter">You're not a Producer... Yet! Want to be one? Contact-us!</p>
                        <?php echo Html::a('Let\'s Go!', Url::toRoute(['/site/contact']), ['class' => 'btn btn-default'])?>
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
                        echo Html::a('Upload Song!', Url::toRoute(['/musics/create']), ['class' => 'btn btn-default marginLeft2Percent']);
                    } ?> 
                </h2> 
                <?php 
      
                    if ($profileProvider->isprodutor == 'S')
                    {
                        if($numberOfSongsYouHave > 0) {
                            foreach ($musicsFromProducerWithUsername as $musica) { ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 userImageProfile textAlignCenter">
                                                <div class="row">
                                                    <div class="col-lg-12 userImageProfile">
                                                        <?= Html::img('@web/uploads/'.$userProvider->id ."/image_".$musica->id.'.png', ['alt'=>"User"]); ?>
                                                    </div>
                                                </div>
                                                <div class="row marginTop2Percent">
                                                    <div class="col-lg-12 "><?php echo Html::a('Edit Music', Url::toRoute(['/musics/update', 'id' => $musica->id]), ['class' => 'btn btn-default'])?>
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
                                                    <div class="col-lg-6 textAlignRight"><p>Price: </p></div><div class="col-lg-6 textAlignLeft"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $musica->pvp ?>€</p> <?php } else { ?><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']), ['class' => 'btn btn-default'])?><?php } ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">&nbsp;</div>
                                                    <div class="col-lg-8">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                                                <audio id="player" controls  <?php echo 'src="'.Yii::getAlias('@web').'/'.$musica->musicpath.'/music_'.$musica->id.'_'.$musica->title.'.mp3"';?> style="width: 100%"></audio>
                                                <!-- controlsList="nodownload" -->
                                                <div class="col-lg-12">&nbsp;</div>
                                                <div class="col-lg-12 textAlignCenter">
                                                    <?= Html::a('Add to one of your playlists', Url::toRoute(['/playlists/addsong', 'id' => $musica->id]), ['class' => 'btn btn-default'])?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php
                                    if(count($profileProvider->musics) >= 1)
                                        echo "<div class=\"col-lg-12 marginTop2Percent borderTopBlack\">&nbsp;</div>";
                                    ?>
                                </div>

                            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                            <?php
                            }
                            echo '<div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>';
                        }
                        else{
                            ?>
                            <div class="row textAlignCenter">
                                <br>
                                <div class="col-lg-12">
                                    <p>You are a producer! But you dont have any songs for sale...<br><br><br>Want to upload some?</p><?php echo Html::a('Upload Song', Url::toRoute(['/musics/create']), ['class' => 'btn btn-default'])?>
                                </div>
                            </div>

                        <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                            <?php
                        } ?>

            <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                        <?php
                    } 
                    else
                    {
                ?>
                    <div class="textAlignCenter">
                        <p class="textAlignCenter">You're not a Producer... Yet! Want to be one? Contact-us!</p>
                        <?php echo Html::a('Let\'s Go!', Url::toRoute(['/site/contact']), ['class' => 'btn btn-default'])?>
                    </div>
                    <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                <?php
                    }
                ?>
            </div>
            
            <div class="col-lg-6  borderRightBlack textAlignCenter">

                <h2 class="textAlignCenter">Your Purchases</h2>

                <br>
                <?php if(isset($musicasCompradas)){ ?>
                <button class="btn btn-default marginBottom2Percent" type="button" data-toggle="collapse" data-target="#collapsePurchases" aria-expanded="false" aria-controls="collapseExample">View All</button>
                <div class="collapse" id="collapsePurchases">
                    <?php
                    foreach ($musicasCompradas as $musicaComprada) { ?>
                        <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>
                        <div class="row marginBottom2Percent">
                            <div class="col-lg-6 ">
                                <div class="row">
                                    <div class="col-lg-12 textAlignCenter"><h3><?= $musicaComprada->title ?></h3></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?= $musicaComprada->genres ?></p></div>
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
                                <?= Html::img("@web/".$musicaComprada->musicpath ."/image_".$musicaComprada->id.'.png', ['alt'=>"User"]); ?> 
                                <div class="row">
                                    <div class="col-lg-12 textAlignCenter marginTop2Percent">

                                        <audio id="player" controls <?php echo 'src="'.Yii::getAlias('@web').'/'.$musicaComprada->musicpath.'/music_'.$musicaComprada->id.'_'.$musicaComprada->title.'.mp3"';?> style="width: 100%"></audio>
                                   </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 marginTop2Percent">
                                            <?= Html::a('Add to one of your playlists', Url::toRoute(['/playlists/addsong'/*, 'id' => $musica->id*/]), ['class' => 'btn btn-default'])?>
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
                        <?php echo Html::a('Take me there!', Url::toRoute(['/musics/index']), ['class' => 'btn btn-default'])?>
                    </div>
                <?php
            } ?>
<div class="col-lg-12  borderBottomBlack">&nbsp;</div>
            </div>


            <div class="col-lg-6 ">

                <h2 class="textAlignCenter">Your Playlists</h2>
                <?php
                if (isset($playlist)) {
                    foreach ($playlistsUserLogado as $playlist) {
                        ?>
                        <?php
                        /*BaseVarDumper::dump($playlistsUserLogado);
                        die();*/
                        ?>
                        <div class="row borderTopBlack">
                            <div class="col-lg-12 ">
                                <div class="row">
                                    <div class="col-lg-8 textAlignLeft"><h2><?php echo $playlist->nome ?></h2></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Creation Date:<br></p></div>
                                    <div class="col-lg-8"><p><?php echo $playlist->creationdate ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Genres:<br></p></div>
                                    <div class="col-lg-8"><p>
                                            <?php


                                            foreach ($generos as $genre) {

                                                echo $genre;
                                                echo " ";
                                            }
                                            ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">&nbsp;</div>
                                <div class="col-lg-8"></div>
                            </div>
                        </div>

                    <?php }
                }?>


                <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>




            </div>


        </div>
    </div>


</div>
