<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Albuns;
use yii\helpers\Url;
use yii\helpers\BaseVarDumper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Your Profile';
$this->params['breadcrumbs'][] = $this->title;
if(isset($popup)){
    if($popup==true){
        echo'<script>alert("Music has been already sold. You cannot delete it")</script>';
    }
}
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
                <div class="col-lg-4 userImage textAlignCenter">
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


                    <h2 class="">Your Albums</h2>
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
                            ?>

                        <button class="btn btn-default marginBottom2Percent" type="button" data-toggle="collapse" data-target="#collapseAlbums" aria-expanded="false" aria-controls="collapseExample">View All</button>
                    
                        <div class="collapse" id="collapseAlbums">
                            <div class="col-lg-12 ">
                            <?php
                            foreach ($profileProvider->albums as $album) {
                                ?>

                                    <div class="row borderTopBlack">
                                        <div class="col-lg-12 userImageProfile marginTop2Percent ">
                                            <?php
                                            if(is_null($album->albumcover)){
                                                echo Html::img('@web/images/user.png', ['alt'=>"User"],[ "id"=>"userImage"]);
                                            }
                                            else{
                                                echo Html::img('@web/images/'.$album->albumcover.'.png', ['alt'=>"Album Image"]); 
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <p>
                                                <?= $album->title; ?>
                                            </p>
                                            <p>
                                                <?= $album->launchdate; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row marginBottom2Percent">
                                        <div class="col-lg-12"> 
                                            <?php echo Html::a('View Album', Url::toRoute(['/albums/index#'.$album->id]), ['class' => 'btn btn-default'])?>
                                        </div>
                                    </div>

                                <?php
                            }
?>
                                </div>
                        </div>
                        <?php
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

            <div class="col-lg-12 " >

                <h2 class="textAlignCenter ">Your Creations
                <?php 
                    if($profileProvider->isprodutor == 'S' && $numberOfSongsYouHave > 0) {
                        echo Html::a('Upload Song!', Url::toRoute(['/musics/create']), ['class' => 'btn btn-default marginLeft2Percent']);
                    } ?> 
                </h2> 
                
                <?php
                $i = 0;
                    if ($profileProvider->isprodutor == 'S')
                    {
                        if($numberOfSongsYouHave > 0) {
                            foreach ($musicsFromProducerWithUsername as $musica) {
                                $i++;?>
                                
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
                                                    <div class="col-lg-12 "><?= Html::a('Edit Music', Url::toRoute(['/musics/update', 'id' => $musica->id]), ['class' => 'btn btn-default'])?>
                                                        <?= Html::a('Delete Music', ['/user/musicdelete', 'id'=>$musica->id], ['class' => 'btn btn-default', 'data-method'=>'delete']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 borderLeftBlack borderRightBlack">
                                                <div class="row">
                                                    <div class="col-lg-12 textAlignCenter"><h3><?= $musica->title ?></h3></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 textAlignRight"><p>Genre: </p></div><div class="col-lg-6"><p><?php echo $musica->genres->nome; ?></p></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-6 textAlignLeft"><p><?= $musica->launchdate; ?></p></div>
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
                                                <div class="col-lg-12 textAlignCenter">
                                                    <button type="button" class="btn btn-default " data-toggle="modal" data-target="#exampleModal<?=$i?>">
                                                        Add to one of your playlists
                                                    </button>
                                                </div>
                                                <div class="modal fade textAlignCenter" id="exampleModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="<?= "../playlists/addsong" ?>">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title floatLeft" id="exampleModalLabel"><?= $musica->title ?></h4>
                                                                <button type="button" class="close floatRight" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                    <input type="hidden" id="musics_id" name="musics_id" value="<?= $musica->id ?>">
                                                                    <select name="playlists_id" id="playlists_id">
                                                                        <?php
                                                                        foreach($playlistsUserLogado as $playlist) { ?>
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
                                                </div>

                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php
                            }
                        }
                        else{
                            ?>
                            <div class="row textAlignCenter">
                                <br>
                                <div class="col-lg-12">
                                    <p>You are a producer! But you dont have any songs for sale...<br><br><br>Want to upload some?</p><?php echo Html::a('Upload Song', Url::toRoute(['/musics/create']), ['class' => 'btn btn-default'])?>
                                </div>
                            </div>

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
                                    <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?php echo $musicaComprada->genres->nome ?></p></div>
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

                <br>
                <?php
                if (!isset($playlistsUserLogado)) {
                    foreach ($playlistsUserLogado as $playlist) {
                        ?>
                        <?php
                        /*BaseVarDumper::dump($playlistsUserLogado);
                        die();*/
                        ?>
                        <div class="row borderTopBlack">
                            <div class="col-lg-12 ">
                                <div class="row">
                                    <div class="col-lg-12 textAlignCenter"><h2><?php echo $playlist->nome ?></h2></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Creation Date:<br></p></div>
                                    <div class="col-lg-8"><p><?php echo $playlist->creationdate ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 textAlignRight"><p>Genres:<br></p></div>
                                    <div class="col-lg-8"><p>
                                            <?php
                                                if(empty($playlist->generosDaPlaylist))
                                                    echo "None defined yet";
                                                else{
                                                    foreach ($playlist->generosDaPlaylist as $listar) {
                                                        echo $listar;
                                                    }
                                                }

                                            ?></p>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-12 textAlignCenter"><p><?php echo Html::a('Take me there!', Url::toRoute(['/playlists/view/'.$playlist->id.'/']), ['class' => 'btn btn-default'])?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">&nbsp;</div>
                                <div class="col-lg-8"></div>
                            </div>
                        </div>

                    <?php }
                } else{?>
                <div class="textAlignCenter">
                    <p class="textAlignCenter">You haven't created a playlist yet? You can do it here!</p>
                    <?php echo Html::a('Create a playlist!', Url::toRoute(['/playlists/create']), ['class' => 'btn btn-default'])?>
                </div>
                <?php
                } ?>


                <div class="col-lg-12 marginTop2Percent borderTopBlack">&nbsp;</div>




            </div>


        </div>
    </div>


</div>
