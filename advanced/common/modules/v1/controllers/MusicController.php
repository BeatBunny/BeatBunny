<?php

namespace common\modules\v1\controllers;



/**
 * Default controller for the `v1` module
 */
class MusicController extends \yii\rest\ActiveController
{
	public $modelClass = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $genresProvider = 'common\models\Genres';


    private function putProducerInMusic($model){
        foreach ($model->profiles as $profile) {
            $user = $this->userProvider::find()->where(['id' => $profile->id_user])->one();
            $model->producerOfThisSong = $user->username;
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

    public function actionMusicswithproducer(){
        $models = $this->modelClass::find()->all();
        $models = $this->putProducerInMusics($models);
        return $models;
    }
    public function actionTitle($id){
        $model = $this->modelClass::findOne($id);
        return $model->title;
    }
    public function actionLaunchdate($id){
        $model = $this->modelClass::findOne($id);
        return $model->launchdate;
    }
    public function actionLyrics($id){
        $model = $this->modelClass::findOne($id);
        return $model->lyrics;
    }
    public function actionPvp($id){
        $model = $this->modelClass::findOne($id);
        return $model->pvp;
    }
    public function actionMusicpath($id){
        $model = $this->modelClass::findOne($id);
        return $model->musicpath;
    }
    public function actionGenre($id){
        $model = $this->modelClass::findOne($id);
        return $model->genres->nome;
    }
    public function actionProducer($id){
        $model = $this->modelClass::findOne($id);
        $model = $this->putProducerInMusic($model);
        return $model->producerOfThisSong;
    }
    public function actionCount(){
        $models = $this->modelClass::find()->all();
        return count($models);
    }

}
