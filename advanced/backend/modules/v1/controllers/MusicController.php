<?php

namespace backend\modules\v1\controllers;

use yii\helpers\BaseUrl;


/**
 * Default controller for the `v1` module
 */
class MusicController extends \yii\rest\ActiveController
{
	public $modelClass = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $genresProvider = 'common\models\Genres';
    public $user = null;


    private function putProducerInMusic($model){
        foreach ($model->profiles as $profile) {
            $userAux = $this->userProvider::find()->where(['id' => $profile->id_user])->one();
            $this->user = $userAux;
            $model->producerOfThisSong = $userAux->username;
        }
        return $model;
    }

    private function putProducerInMusics($models){
        foreach ($models as $music) {
            foreach ($music->profiles as $profile) {
                $user = $this->userProvider::find()->where(['id' => $profile->id_user])->one();
                $music->producerOfThisSong = $user->username;
            }
        }
        return $models;
    }

    /*
    'GET musicswithproducer' => 'musicswithproducer',
    'GET {id}/title' => 'title', // 'x' é 'actionX'
    'GET {id}/launchdate' => 'launchdate', // 'x' é 'actionX'
    'GET {id}/lyrics' => 'lyrics', // 'x' é 'actionX'
    'GET {id}/pvp' => 'pvp', // 'x' é 'actionX'
    'GET {id}/musicpath' => 'musicpath', // 'x' é 'actionX'
    'GET {id}/genre' => 'genre', // 'x' é 'actionX'
    'GET {id}/producer' => 'producer', // 'xxxx' é 'actionXxxx'
    'GET count' => 'count',
    */

    public function actionSearch($txcode){
        $models = $this->modelClass::find()->all();
        $request = $this->modelClass::find()->where("lower(title) LIKE '%".strtolower($txcode)."%'")->all();
        return $request;
    }
    public function actionMusicswithproducer(){
        $models = $this->modelClass::find()->all();
        $models = $this->putProducerInMusics($models);
        return $models;
    }
    public function actionTitlemusic($id){
        $model = $this->modelClass::findOne($id);
        return $model->title;
    }
    public function actionLaunchdatemusic($id){
        $model = $this->modelClass::findOne($id);
        return $model->launchdate;
    }
    public function actionLyricsmusic($id){
        $model = $this->modelClass::findOne($id);
        return $model->lyrics;
    }
    public function actionPvpmusic($id){
        $model = $this->modelClass::findOne($id);
        return $model->pvp;
    }
    public function actionMusicpathmusic($id){
        $model = $this->modelClass::findOne($id);
        return $model->musicpath;
    }
    public function actionGenremusic($id){
        $model = $this->modelClass::findOne($id);
        return $model->genres->nome;
    }
    public function actionProducermusic($id){
        $model = $this->modelClass::findOne($id);
        $model = $this->putProducerInMusic($model);
        return $model->producerOfThisSong;
    }
    public function actionCountmusic(){
        $models = $this->modelClass::find()->all();
        return count($models);
    }

    public function actionMp3filemusic($id){
        $model = $this->modelClass::findOne($id);
        $model = $this->putProducerInMusic($model);
        return 'BeatBunny/advanced/frontend/web/uploads/'.$this->user->id.'/music_'.$model->id.'_'.$model->title.'.mp3';
    }

    public function actionNewtest(){
        $nome = \Yii::$app->request->post('nome');
        return $nome;
        $model = new $this->modelClass;
        $model->nome = $nome;
        $model->morada = $morada;
        $model->peso = 0;
        $ret = $model->save();
        return ['SaveError' => $ret];
    }

}
