<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\BaseVarDumper;

/* @var $this yii\web\View */
/* @var $model app\models\Musics */

$this->title = 'Purchase Song: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Musics', 'url' => ['musics/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title];
$this->params['breadcrumbs'][] = 'Purchase';
    

    // BaseVarDumper::dump($model->title);
    // die();


?>

<div class="musics-update">
	<div class="row">
        <div class="col-lg-12">  
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        
    </div>
    <div class="col-lg-12 ">&nbsp;</div>
    <div class="row borderTopBlack marginTop2Percent">
    	<div class="col-lg-12">
    		<br>
            <div class="row">
                <div class="col-lg-4 userImageProfile textAlignCenter">
                    <?= Html::img('@web/'.$model->musicpath .'image_'.$model->id.'.png', ['alt'=>'Music Image']); ?>
                </div>
                <div class="col-lg-4 borderLeftBlack borderRightBlack">
                    <div class="row">
                        <div class="col-lg-12 textAlignCenter"><h3><?= $model->title; ?></h3></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Genre: </p></div><div class="col-lg-8"><p><?= $model->genres->nome; ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Launch Date: </p></div><div class="col-lg-8"><p><?= $model->launchdate; ?></p></div>
                    </div>
                    <div class="row" style="display: none;">
                        <div class="col-lg-4 textAlignRight"><p>Price: </p></div><div class="col-lg-8"><?php if (!Yii::$app->user->isGuest) { ?><p><?= $model->pvp.'€'; ?></p> <?php } else { ?><button class="btn btn-default"><?php echo Html::a('Login to see prices', Url::toRoute(['/site/login']))?></button> <?php } ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 textAlignRight"><p>Producer: </p></div><div class="col-lg-8">
                            <p class="overflowThatBi" title="<?= $model->profile->user->username; ?>"><?= $model->profile->user->username; ?></p>
                        </div>
                    </div>
                    <div class="row"><div class="col-lg-4">&nbsp;</div><div class="col-lg-8"></div></div>
                </div>
                <?php 

                $modelaCompradaQuestionMark = false;
                if(isset($modelasCompradasPeloUser)){

                    foreach ($modelasCompradasPeloUser as $modelaComprada) {
                        if($modelaComprada->id === $model->id)
                            $modelaCompradaQuestionMark = true;
                    }

                }
                ?>
                <div class="col-lg-4">
                    <div class="col-lg-12 textAlignCenter"><h2>&nbsp;</h2></div>
                    <audio id="player" controls <?php 
                    if(!Yii::$app->user->isGuest){ 
                        $uploadFolder = Yii::getAlias('@web');
                        echo 'src="'.Yii::getAlias('@web').'/'.$model->musicpath.'/music_'.$model->id.'_'.$model->title.'.mp3"';
                    } ?> style="width: 100%"></audio>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
            </div>
            <div class="row">
	            <div class="col-lg-4">
	            	&nbsp;
	            </div>
	            <div class="col-lg-4">
	                <div class="col-lg-6 textAlignRight">
	                	<p>Price: </p>
	                </div>
	                <div class="col-lg-6">
	            		<p><?= $model->pvp.'€'; ?></p>
					</div>
	            </div>
	            <div class="col-lg-4">
	            	&nbsp;
	            </div>
            </div>
            <div class="row">
            	<div class="col-lg-4">
	            	&nbsp;
	            </div>
	            <div class="col-lg-4">
	            	<?php if($currentProfile->saldo >= $model->pvp){ ?>
	            		<?= Html::a('Purchase', ['/musics/finishpayment', 'id' => $model->id], ['class' => 'btn btn-default width100']) ?>
					<?php }else { ?>
						<p class="width100 textAlignCenter">Your balance isn't enough to buy this track...</p>
       			 		<?= Html::a('Add Funds?', Url::toRoute(['/profile/wallet', 'link' => Yii::$app->request->url]), ['class' => 'btn btn-default width100 textAlignCenter'])?>
					<?php } ?>
	            </div>
	            <div class="col-lg-4">
	            	&nbsp;
	            </div>
            </div>
    	</div>
    </div>
   	

</div>
