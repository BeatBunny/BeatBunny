<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\BaseVarDumper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchMusics */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Musics';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
        

?>
<div class="musics-index">
    <div class="row">
        <div class="col-lg-6">  
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-6 textAlignRight h1mf">  
            
            <?= $this->render('_search', [
                'searchModel' => $searchModel,
            ]) ?>
        </div>
    </div>
    <?php
    $i = 0;
    if(empty($searchModel->title)){

      foreach ($allMusics as $music) {
          $i++;
        ?>

        <!-- Modal com os Lyrics -->
            <div class="modal fade" id="exampleModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <div class="col-lg-12 ">&nbsp;</div>
        <div class="row borderTopBlack marginTop2Percent">
                
            <div class="col-lg-12">
                <br>
                <div class="row">
                    <div class="col-lg-4 userImageProfile textAlignCenter">
                        <?= Html::img( "@web/".$music->musicpath ."/image_".$music->id.'.png', ['alt'=>"User"]); ?>
                        <div class="row">
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal<?=$i?>">
                                    See Lyrics
                                </button>
                            </div>
                        </div>
                    </div>

                        <div class="col-lg-4 borderLeftBlack borderRightBlack">
                            <div class="row">
                                <div class="col-lg-12 textAlignCenter"><h3><?= $music->title; ?></h3></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?php echo $music->genres->nome ?></p></div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $music->launchdate; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $music->pvp.'€'; ?></p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Producer: </p></div><div class="col-lg-8">
                                    <?php
                                        $titleToStuff = $music->profile->user->username;
                                        if (!Yii::$app->user->isGuest) {
                                            if($userProvider->username === $music->profile->user->username){
                                                $titleToStuff = $music->profile->user->username ." (Hey that's you!)";
                                            }
                                        }
                                    ?>
                                    <p class="overflowThatBi marginTop2Percent" title="<?= $titleToStuff; ?>"><?= $titleToStuff; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">&nbsp;</div>
                                <div class="col-lg-8">
                                    
                                </div>
                            </div>
                        </div>
                        <?php 

                        $musicaCompradaQuestionMark = false;
                        if(isset($musicasCompradasPeloUser)) {

                            foreach ($musicasCompradasPeloUser as $musicaComprada) {
                                if ($musicaComprada->id === $music->id)
                                    $musicaCompradaQuestionMark = true;
                            }
                        }

                        ?>
                        <div class="col-lg-4">
                            <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                            <audio id="player" controls <?php 
                            if(!Yii::$app->user->isGuest){ 
                                echo 'src="'.Yii::getAlias('@web').'/'.$music->musicpath.'/music_'.$music->id.'_'.$music->title.'.mp3"';
                            } ?> style="width: 100%"></audio>
                            
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 textAlignCenter">
                        <?php   if (!Yii::$app->user->isGuest) { 
                                    if($musicaCompradaQuestionMark == true || $music->profile->user->username === $userProvider->username)
                                    {
                                ?>
                                        <div class="col-lg-12 textAlignCenter">
                                            <button type="button" class="btn btn-default " data-toggle="modal" data-target="#exampleModalPlaylist<?=$i?>">
                                                Add to one of your playlists
                                            </button>
                                        </div>
                                        <div class="modal fade textAlignCenter" id="exampleModalPlaylist<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="<?= "../playlists/addsong" ?>">
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
                                        </div>
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <button class="btn btn-default"><?php echo Html::a('Buy this song!', Url::toRoute(['/musics/buymusic', 'id'=> $music->id]))?></button>
                                    <?php
                                    }
                                    ?>
                        <?php   }
                                else { ?>
                                    <button class="btn btn-default"><?php echo Html::a('Login to buy song', Url::toRoute(['/site/login']))?></button>
                        <?php   } ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>

        <?php
        $i++;
        } 
    }
    else{
        $i = 0;
        foreach ($searchedMusics as $music) {
            $i++;
            ?>
            

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title floatLeft" id="exampleModalLabel"><?= $music->title ?></h4>
                    <button type="button" class="close floatRight" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php echo $music->lyrics; ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 ">&nbsp;</div>
            <div class="row borderTopBlack marginTop2Percent">
                    
                <div class="col-lg-12">
                    <br>
                    <div class="row">
                        <div class="col-lg-4 userImageProfile textAlignCenter">
                            <?= Html::img( "../".$music->musicpath ."/image_".$music->id.'.png', ['alt'=>"User"]); ?>
                            <div class="row">
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal">
                                        See Lyrics
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 borderLeftBlack borderRightBlack">
                            <div class="row">
                                <div class="col-lg-12 textAlignCenter"><h3><?= $music->title; ?></h3></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?= $music->genres->nome; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $music->launchdate; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $music->pvp.'€'; ?></p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Producer: </p></div><div class="col-lg-8">
                                    <?php
                                    $titleToStuff = $music->profile->user->username;
                                        if (!Yii::$app->user->isGuest) {
                                            if($userProvider->username === $music->profile->user->username){
                                                $titleToStuff = $music->profile->user->username ." (Hey that's you!)";  
                                            }
                                        }
                                    ?>
                                    <p class="overflowThatBi marginTop2Percent" title="<?= $titleToStuff; ?>"><?= $titleToStuff; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">&nbsp;</div>
                                <div class="col-lg-8">
                                    
                                </div>
                            </div>
                        </div>
                        <?php 

                        $musicaCompradaQuestionMark = false;
                        if(isset($musicasCompradasPeloUser))
                            
                                foreach ($musicasCompradasPeloUser as $musicaComprada) {
                                    if($musicaComprada->id === $music->id)
                                        $musicaCompradaQuestionMark = true;
                                }
                            
                        ?>
                        <div class="col-lg-4">
                            <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                            <audio id="player" controls <?php 
                            if(!Yii::$app->user->isGuest){ 
                                 echo 'src="'.Yii::getAlias('@web').'/'.$music->musicpath.'/music_'.$music->id.'_'.$music->title.'.mp3"';
                            } ?> style="width: 100%"></audio>
                            
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 textAlignCenter">
                        <?php   if (!Yii::$app->user->isGuest) { 
                                    if($musicaCompradaQuestionMark == true || $music->profile->user->username === $userProvider->username)
                                    {
                                ?>
                                        <div class="col-lg-12 textAlignCenter">
                                            <button type="button" class="btn btn-default " data-toggle="modal" data-target="#exampleModal<?=$i?>">
                                                Add to one of your playlists
                                            </button>
                                        </div>
                                        <div class="modal fade" id="exampleModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="<?= "../playlists/addsong" ?>">
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
                                        </div>
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <button class="btn btn-default"><?php echo Html::a('Buy this song!', Url::toRoute(['/musics/buymusic', 'id'=> $music->id, 'producerOfThisSong' => $music->producerOfThisSong]))?></button>
                                    <?php
                                    }
                                    ?>
                        <?php   }
                                else { ?>
                                    <button class="btn btn-default"><?php echo Html::a('Login to buy song', Url::toRoute(['/site/login']))?></button>
                        <?php   } ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>

        <?php 
        $i++;
        } 
    }


    ?>

</div>
