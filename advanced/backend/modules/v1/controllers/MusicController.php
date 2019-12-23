<?php

namespace backend\modules\v1\controllers;
use yii\rest\ActiveController;

class MusicController extends ActiveController
{
    public $modelClass = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $genresProvider = 'common\models\Genres';


    // protected function verbs() {
    //     //$verbs = parent::verbs();
    //     $verbs =  [
    //         'index' => ['GET', 'HEAD'],
    //         'view' => ['GET', 'HEAD'],
    //         'create' => ['POST'],
    //         'update' => ['PUT', 'PATCH'],
    //         'delete' => ['DELETE'],
    //     ];
    //     return $verbs;
    // }

    public function actionIndexmusic($id){
        $models = new $this->modelClass;
        return $models->findOne($id);
    }

    public function actionSearch($txcode){
        $models = new $this->modelClass;
        $request = $models::find()->where("lower(title) LIKE '%".strtolower($txcode)."%'")->all();
        return $request;
    }
    public function actionTitlemusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->title;
    }
    public function actionLaunchdatemusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->launchdate;
    }
    public function actionLyricsmusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->lyrics;
    }
    public function actionPvpmusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->pvp;
    }
    public function actionMusicpathmusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->musicpath;
    }


    public function actionCovermusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return '/frontend/web/'.$model->musicpath.'image_'.$model->id.'.png';
    }

    public function actionGenremusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->genres->nome;
    }
    public function actionCountmusic(){
        $models = new $this->modelClass;
        $model = $models::find()->all();
        return count($model);
    }

    public function actionMp3filemusic($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return '/frontend/web/'.$model->musicpath.'music_'.$model->id.'_'.$model->title.'.mp3';
    }


}
