<?php

namespace backend\modules\v1\controllers;
use Yii;
use common\models\phpMQTT;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\BaseVarDumper;
use yii\rest\ActiveController;

/**
 * @property mixed profileProvider
 */
class MusicController extends ActiveController
{
    public $modelClass = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $genresProvider = 'common\models\Genres';
    public $profileProvider = 'common\models\Profile';
    public $user = null;

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => QueryParamAuth::className(),
//        ];
//        return $behaviors;
//    }
//
//     protected function verbs() {
//         //$verbs = parent::verbs();
//         $verbs =  [
//             'index' => ['GET', 'HEAD'],
//             'view' => ['GET', 'HEAD'],
//             'create' => ['POST'],
//             'update' => ['PUT', 'PATCH'],
//             'delete' => ['DELETE'],
//         ];
//         return $verbs;
//     }

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

//    public function actionMusiccreate(){
//
//        //CENAS DA TABELA PLAYLISTS
//        $model = new $this->modelClass;
//        $model->title = Yii::$app->request->post('title');
//        $model->launchdate = date("Y-m-d"); //Yii::$app->request->post('creationdate');
//        $model->rating= Yii::$app->request->post('rating');
//        $model->lyrics= Yii::$app->request->post('lyrics');
//        $model->pvp = Yii::$app->request->post('pvp');
//        $model->musiccover = Yii::$app->request->post('musiccover');
//        $model->musicpath = Yii::$app->request->post('musicpath');
//        $model->genres_id = Yii::$app->request->post('genres_id');
//        $model->albums_id = Yii::$app->request->post('albums_id');
//        $model->iva_id = Yii::$app->request->post('iva_id');
//        $model->profile_id = Yii::$app->request->post('profile_id');
//
//        //IR BUSCAR O PROFILE DO USER
//        $userid = Yii::$app->request->post('idUser'); //USER ID
//        $modelProfile = Yii::$app->request->post('profile_id');
//        $profileQueCriou = $modelProfile::find()->where(['user_id' => $userid])->one();
//
//        //return $profileQueCriou;
//        //CRIAR A PLAYLIST E O PROFILE_HAS_PLAYLISTS
//
//        if($model->save()) {
//            return true;
//        }
//            else{
//                return false;
//            }
//    }

}
