<?php

namespace backend\modules\v1\controllers;
use common\models\phpMQTT;
use common\models\User;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;

class PlaylistsController extends ActiveController
{
	public $modelClass = 'common\models\Playlists';
    public $modelMusic = 'common\models\Musics';
    public $userProvider = 'common\models\User';
    public $profileProvider = 'common\models\Profile';
    public $modelPHM = 'common\models\PlaylistsHasMusics';
    public $modelPHP = 'common\models\ProfileHasPlaylists';
    public $genresProvider = 'common\models\Genres';
    public $user = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }




    public function fields()
    {
        return ['id','nome'];
    } 


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

    public function actionMusic($id, $idmusic){
        $models = new $this->modelMusic;
        $musicsFromPlaylist = $models::findOne($id);
        return $musicsFromPlaylist->musics;
        
    }


    public function actionNomeplaylist($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->nome;
    }

    public function actionCreationdateplaylist($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->creationdate;
    }
    public function actionMusicsplaylist($id){
        $models = new $this->modelClass;
        $model = $models::findOne($id);
        return $model->musics;
    }

    public function actionSearch($id, $txcode){
        $models = new $this->modelMusic;
        $model = $models::find()->all();
        $request = $model::find()->where("lower(title) LIKE '%".strtolower($txcode)."%'")->all();
        return $request;
    }
    public function actionTitlemusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return $model->title;
    }
    public function actionLaunchdatemusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return $model->launchdate;
    }
    public function actionLyricsmusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return $model->lyrics;
    }
    public function actionPvpmusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return $model->pvp;
    }
    public function actionMusicpathmusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return $model->musicpath;
    }
    public function actionGenremusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return $model->genres->nome;
    }
    public function actionCountmusic(){
        $models = new $this->modelMusic;
        $model = $models::find()->all();
        return count($model);
    }

    public function actionMp3filemusic($id, $idmusic){
        $models = new $this->modelMusic;
        $model = $models::findOne($idmusic);
        return Yii::getAlias('@web').'frontend/'.$model->musicpath.'music_'.$model->id.'_'.$model->title.'.mp3"';
    }

    public function actionPlaylistcreate(){

        //CENAS DA TABELA PLAYLISTS
        $model = new $this->modelClass;
        $model->nome = Yii::$app->request->post('nome');
        $model->creationdate = date("Y-m-d"); //Yii::$app->request->post('creationdate');
        $model->ispublica = 'N'; //Yii::$app->request->post('ispublica');

        //IR BUSCAR O PROFILE DO USER
        $userid = Yii::$app->request->post('idUser'); //USER ID
        $modelProfile = new $this->profileProvider;
        $profileQueCriou = $modelProfile::find()->where(['user_id' => $userid])->one();

        //return $profileQueCriou;
        //CRIAR A PLAYLIST E O PROFILE_HAS_PLAYLISTS
        if($model->save()){
            $modelProfileHasPlaylists = new $this->modelPHP;
            $modelProfileHasPlaylists->profile_id = $profileQueCriou->id;
            $modelProfileHasPlaylists->playlists_id = $model->id;
            if($modelProfileHasPlaylists->save()){
                return true;
            }
            else{
                return false;
            }
        }
        return false;
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
        $modelPlaylistHasMusics = new $this->modelPHM;
        $modelProfileHasPlaylists = new $this->modelPHP;

        $ret3 = $modelProfileHasPlaylists->deleteAll(['playlists_id' => $id]);
        $ret2 = $modelPlaylistHasMusics->deleteAll(['playlists_id' => $id]);
        $ret = $model->deleteAll(['id' => $id]);

        if($ret)
            return ['SaveError' => true];
        
        return ['SaveError' => false];
    }

    public function actionPlaylistputsong(){

        $modelPHM = new $this->modelPHM;
        $model = new $this->modelClass;
        $modelmusica = new $this->modelMusic;

        $id = Yii::$app->request->post('idPlaylist');
        $playlistParaInserir = $model::findOne($id);
        
        if(is_null($playlistParaInserir))
            return ['SaveError' => false];
        
        $idmusic = Yii::$app->request->post('idMusic');        
        $musicaParaInserirNaPlaylist = $modelmusica::findOne($idmusic);

        if(is_null($musicaParaInserirNaPlaylist))
            return ['SaveError' => false];

        $modelPHM->playlists_id = $playlistParaInserir->id;
        $modelPHM->musics_id = $musicaParaInserirNaPlaylist->id;

        $ret = $modelPHM->save();
        return ['SaveError' => $ret];
    }

    public function actionPlaylistremovesong(){
        
        $modelPlaylistHasMusics = new $this->modelPHM;
        $model = new $this->modelClass;
        $modelmusica = new $this->modelMusic;

        $idPlaylist = Yii::$app->request->post('idPlaylist');
        $playlistParaRetirarMusica = $model::findOne($idPlaylist);

        if(is_null($playlistParaRetirarMusica))
            return false;
        
        $idMusic = Yii::$app->request->post('idMusic');
        $musicaParaRetirarDaPlaylist = $modelmusica::findOne($idMusic);

        if(is_null($musicaParaRetirarDaPlaylist))
            return false;

        return $modelPlaylistHasMusics->deleteAll('playlists_id="'.$idPlaylist.'" AND musics_id="'.$idMusic.'"');

    }

}
