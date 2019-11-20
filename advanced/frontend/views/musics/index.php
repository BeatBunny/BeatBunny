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

    if(empty($searchModel->title)){


        
      foreach ($allTheMusicsWithProducer as $music) { ?>
        <!-- Modal com os Lyrics -->
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
                                <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $music->launchdate; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $music->pvp.'€'; ?></p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Producer: </p></div><div class="col-lg-8">
                                    <p class="overflowThatBi" title="<?= $music->producerOfThisSong; ?>"><?= $music->producerOfThisSong; ?>
                                        <?php 
                                        if (!Yii::$app->user->isGuest) {
                                            if($currentUser->username === $music->producerOfThisSong){
                                                echo "(Hey that's you!)";
                                            }
                                        }
                                        ?>
                                    </p>
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
                                echo 'src="'."../".$music->musicpath.'/music_'.$music->id.'_'.$music->title.'.mp3"';
                            } ?> style="width: 100%"></audio>
                            
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 textAlignCenter">
                        <?php   if (!Yii::$app->user->isGuest) { 
                                    if($musicaCompradaQuestionMark == true || $music->producerOfThisSong === $currentUser->username)
                                    {
                                ?>
                                        <button class="btn btn-default"><a href="#">Add to one of your playlists</a></button>
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

        <?php } 
    }
    else{
        foreach ($searchedMusics as $music) { ?>
            

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
                                    <p class="overflowThatBi" title="<?= $music->producerOfThisSong; ?>"><?= $music->producerOfThisSong; ?>
                                        <?php 
                                        if (!Yii::$app->user->isGuest) {
                                            if($currentUser->username === $music->producerOfThisSong){
                                                echo "(Hey that's you!)";
                                            }
                                        }
                                        ?>
                                    </p>
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
                                echo 'src="'."../".$music->musicpath.'/music_'.$music->id.'_'.$music->title.'.mp3"';
                            } ?> style="width: 100%"></audio>
                            
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 textAlignCenter">
                        <?php   if (!Yii::$app->user->isGuest) { 
                                    if($musicaCompradaQuestionMark == true || $music->producerOfThisSong === $currentUser->username)
                                    {
                                ?>
                                        <button class="btn btn-default"><a href="#">Add to one of your playlists</a></button>
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

        <?php } 
    }


    ?>

</div>
