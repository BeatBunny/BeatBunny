<?php

namespace backend\modules\v1\controllers;

use yii\helpers\BaseUrl;


/**
 * Default controller for the `v1` module
 */
class AlbumsController extends \yii\rest\ActiveController  
{
	public $modelClass = 'common\models\Albums';
    public $modelMusic = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $genresProvider = 'common\models\Genres';
    public $user = null;
    
    /*
    'GET {id}/musics' => 'musics', // 'xxxx' é 'actionXxxx'
    'GET {id}/title' => 'titlealbum', // 'xxxx' é 'actionXxxx'
    'GET {id}/launchdate' => 'launchdatealbum', // 'xxxx' é 'actionXxxx'
    'GET {id}/genre' => 'genrealbum', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}' => 'music', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/titlemusic' => 'titlemusic', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/launchdatemusic' => 'launchdatemusic', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/lyricsmusic' => 'lyricsmusic', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/pvpmusic' => 'pvpmusic', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/musicpathmusic' => 'musicpathmusic', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/producermusic' => 'producermusic', // 'xxxx' é 'actionXxxx'
    'GET {id}/music/{idmusic}/mp3filemusic' => 'mp3filemusic', // 'xxxx' é 'actionXxxx'
    */

    public function actionMusics($id){
        $model = $this->modelClass::findOne($id);
        return $model->musics;
    }

    public function actionTitlealbum($id){
        $model = $this->modelClass::findOne($id);
        return $model->title;
    }

    public function actionGenrealbum($id){
        $model = $this->modelClass::findOne($id);
        return $model->genres->nome;
    }

    public function actionLaunchdatealbum($id){
        $model = $this->modelClass::findOne($id);
        return $model->launchdate;
    }

    public function actionMusic($id, $idmusic){
        $modelMusic = $this->modelMusic::findOne($idmusic);
        return $modelMusic;
    }

    public function actionTitlemusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        return $model->title;
    }
    public function actionLaunchdatemusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        return $model->launchdate;
    }
    public function actionLyricsmusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        return $model->lyrics;
    }
    public function actionPvpmusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        return $model->pvp;
    }
    public function actionMusicpathmusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        return $model->musicpath;
    }
    public function actionGenremusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        return $model->genres->nome;
    }
    public function actionProducermusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        $model = $this->putProducerInMusic($model);
        return $model->producerOfThisSong;
    }
    public function actionMp3filemusic($id, $idmusic){
        $model = $this->modelMusic::findOne($idmusic);
        $model = $this->putProducerInMusic($model);
        return 'BeatBunny/advanced/frontend/web/uploads/'.$this->user->id.'/music_'.$model->id.'_'.$model->title.'.mp3';
    }

    private function putProducerInMusic($model){
        foreach ($model->profiles as $profile) {
            $userAux = $this->userProvider::find()->where(['id' => $profile->id_user])->one();
            $this->user = $userAux;
            $model->producerOfThisSong = $userAux->username;
        }
        return $model;
    }

}
