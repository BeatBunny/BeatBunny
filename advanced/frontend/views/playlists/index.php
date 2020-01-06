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
<script type="text/javascript">
    function toggleTextOpenClosePlaylist($toggke) {
    var toggle = document.getElementById($toggke);
        if (toggle.innerHTML === "Open Playlist") {
            toggle.innerHTML = "Close Playlist";
        } else {
            toggle.innerHTML = "Open Playlist";
        }
    }
</script>
<div class="playlists-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p style="display: none;">
        <?= Html::a('Return to Profile', ['user/index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $counter = 0;
    $i = 0;
    foreach ($playlistsUserLogado as $playlist) {
        $counter++;
    ?>
    <div class="row borderTopBlack">

        <div class="col-lg-12 ">

            <div class="row">
                <div class="col-lg-5 textAlignLeft"><h2><?php echo $playlist->nome?></h2></div>
                <div class="col-lg-3 marginTop2Percent"><p>Creation Date: <span class="marginLeft2Percent"> <?php echo $playlist->creationdate ?> </span> </p>
                <p>Genres: <span class="marginLeft2Percent">
                        <?php
                        if(empty($playlist->generosDaPlaylist))
                            echo "None defined yet";
                        else
                            foreach ($playlist->generosDaPlaylist as $listar)
                                echo $listar;
                        ?>   
                        </span> 
                    </p>
                </div></div>
                <div class="col-lg-4 marginTop2Percent">
                    
            </div>
        </div>
        <div class="row"> <div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div> </div>
    </div>
    <?php
    if(empty($playlist->musics)) {
        echo Html::a('Go add songs to your playlist', Url::toRoute(['/musics/index']), ['class' => 'btn btn-default']);
        echo Html::a('Delete playlist', ['/playlists/delete', 'id' =>$playlist->id], ['class' => 'btn btn-danger', 'data-method'=>'post']);
        echo '<br><br>';
        }
    else { ?>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsePlaylist<?php echo $counter ?>" aria-expanded="false" aria-controls="collapseExample" onclick="toggleTextOpenClosePlaylist(<?php echo $counter ?>);">
        <span id="<?php echo $counter ?>">Open Playlist</span>
    </button>
    <?php echo Html::a('Delete playlist', ['/playlists/delete', 'id' =>$playlist->id], ['class' => 'btn btn-danger', 'data-method'=>'post']) ?>
    <br>
    <div class="collapse marginTop2Percent" id="collapsePlaylist<?php echo $counter; ?>">
        <?php foreach ($playlist->musics as $music) {
            $i++; ?>
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
        <div class="row borderTopBlack">
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
                            <div class="col-lg-12 textAlignCenter"><h2><?= $music->title ?></h2></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?= $music->genres->nome ?></p></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $music->launchdate ?></p></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $music->pvp.'€'; ?></p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                        </div>
                        <div class="row">
                                <div class="col-lg-4 textAlignRight"><p>Producer: </p></div><div class="col-lg-8">
                                    <?php
                                        $titleToStuff = $music->profile->user->username;
                                        if (!Yii::$app->user->isGuest) {
                                            if($currentUser->username === $music->profile->user->username){
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
                    <div class="col-lg-4">
                        <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                        <audio id="player" controls <?php
                            if(!Yii::$app->user->isGuest){
                                echo 'src="'.Yii::getAlias('@web').'/'.$music->musicpath.'/music_'.$music->id.'_'.$music->title.'.mp3"';
                            } ?> style="width: 100%"></audio>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12 textAlignCenter">
                        <?php if (!Yii::$app->user->isGuest) {
                             echo Html::a('Remove from this Playlist', ['/playlists/musicdel', 'playlists_id' =>$playlist->id, 'musics_id'=>$music->id], ['class' => 'btn btn-default marginTop2Percent', 'data-method'=>'delete']);
                            ?>

<!--                            <button class="btn btn-default" onclick="stopThatShit(/*THIS SONG ID*/)"><a href="#">Remove from this playlist</a></button>-->
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

    <div class="row">
        <?php echo Html::a('Create a playlist!', Url::toRoute(['/playlists/create']), ['class' => 'btn btn-info', 'name' =>'Create a playlist!'])?>
    </div>
</div>