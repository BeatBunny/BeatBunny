<?php

namespace backend\modules\v1\controllers;
use yii\rest\ActiveController;

class MusicsController extends ActiveController
{
	public $modelClass = 'common\models\Musics';
    public $modelMusic = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $genresProvider = 'common\models\Genres';


    public function actionIndex($id){
        $models = new $this->modelMusic;
        $req = $models::find()->where(['id' => $id])->one();
        return $req;
    }

    public function actionSearch($txcode){
        $models = new $this->modelMusic;
        $request = $models::find()->where("lower(title) LIKE '%".strtolower($txcode)."%'")->all();
        return $request;
    }
    public function actionTitlemusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return $model->title;
    }
    public function actionLaunchdatemusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return $model->launchdate;
    }
    public function actionLyricsmusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return $model->lyrics;
    }
    public function actionPvpmusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return $model->pvp;
    }
    public function actionMusicpathmusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return $model->musicpath;
    }
    public function actionGenremusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return $model->genres->nome;
    }
    public function actionCountmusic(){
        $models = new $this->modelMusic;
        $model = $models::find()->all();
        return count($model);
    }

    public function actionMp3filemusic($id){
        $models = new $this->modelMusic;
        $model = $models::findOne($id);
        return 'BeatBunny/advanced/frontend/web/uploads/'.$this->user->id.'/music_'.$model->id.'_'.$model->title.'.mp3';
    }


}
