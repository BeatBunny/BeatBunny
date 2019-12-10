<?php

namespace backend\modules\v1\controllers;
use yii\rest\ActiveController;
use yii\web\Request;
use Yii;

class PlaylistsController extends ActiveController
{
	public $modelClass = 'common\models\Playlists';
    public $modelMusic = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $profileProvider = 'common\models\Profile';
    public $modelPHM = 'common\models\PlaylistsHasMusics';
    public $genresProvider = 'common\models\Genres';
    public $user = null;

    protected function verbs() {
        //$verbs = parent::verbs();
        $verbs =  [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
        return $verbs;
    }

    private function putProducerInMusic($model){
        foreach ($model->profiles as $profile) {
            $userAux = $this->userProvider::find()->where(['id' => $profile->user_id])->one();
            $this->user = $userAux;
            $model->producerOfThisSong = $userAux->username;
        }
        return $model;
    }

    private function putProducerInMusics($models){
        foreach ($models as $music) {
            foreach ($music->profiles as $profile) {
                $user = $this->userProvider::find()->where(['id' => $profile->user_id])->one();
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

    public function actionNomeplaylist($id){
        $model = $this->modelClass::findOne($id);
        return $model->nome;
    }

    public function actionCreationdateplaylist($id){
        $model = $this->modelClass::findOne($id);
        return $model->creationdate;
    }
    public function actionMusicsplaylist($id){
        $model = $this->modelClass::findOne($id);
        return $model->musics;
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

    public function actionPlaylistcreate(){
        $model = new $this->modelClass;
        $model->nome = Yii::$app->request->post('nome');
        $model->creationdate = date("Y-m-d"); //Yii::$app->request->post('creationdate');
        $model->ispublica = 'N'; //Yii::$app->request->post('ispublica');
        if($model->save())
            return ['SaveError' => 'YEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEESSSSSSSSSSSSSSSSSSS'];
        return ['SaveError' => 'NOOOOOO'];
        
    }

    public function actionPlaylistupdate($id){
        $nome = Yii::$app->request->post('nome');
        $model = new $this->modelClass;
        $rec = $model->findOne($id);
        if(count($rec) > 0){
            $rec->nome = $nome;
            $ret = $rec->save();
            return ['SaveError' => $ret];
        }
        throw new \yii\web\NotFountHttpException("Não existe essa playlist");
    }

    public function actionPlaylistdelete($id){
        $model = new $this->modelClass;
        $ret = $model->deleteAll(['id' => $id]);
        if($ret){
            \Yii::$app->response->statusCode = 200;
            return ['code' => 'ok'];
        }
        \Yii::$app->response->statusCode = 404;
        return ['code' => 'error'];
    }

    public function actionPlaylistputsong(){

        $modelPHM = new $this->modelPHM;
        $model = new $this->modelClass;
        $modelmusica = new $this->modelMusic;
        
        $id = Yii::$app->request->post('id');
        $playlistParaInserir = $model::findOne($id);
        $idmusic = Yii::$app->request->post('idmusic');        
        $musicaParaInserirNaPlaylist = $modelmusica::findOne($idmusic);

        $modelPHM->playlists_id = $playlistParaInserir->id;
        $modelPHM->musics_id = $musicaParaInserirNaPlaylist->id;
        $ret = $modelPHM->save();
        return ['SaveError' => $ret];
    }

    public function actionCreatorplaylist($id){
        $modelPlaylist = new $this->modelClass;
        $playlistEmQuestao = $modelPlaylist::findOne($id);
        $modelProfiles = new $this->profileProvider;
        $modelUser = new $this->userProvider;
        $profiles = $this->profileProvider::find()->all();
        foreach ($profiles as $profile) {
            $user = $this->userProvider::find()->where(['id' => $profile->user_id])->one();
            foreach ($profile->playlists as $playlist) {
                if($playlist->id == $playlistEmQuestao->id){
                    return $user->username;
                }
            }
        }
        return 0;
    }



}
