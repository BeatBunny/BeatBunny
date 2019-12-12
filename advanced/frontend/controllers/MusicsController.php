<?php

namespace frontend\controllers;

use Behat\Gherkin\Exception\Exception;
use common\models\PlaylistsHasMusics;
use Yii;
use common\models\User;
use common\models\Profile;
use common\models\ProfileHasMusics;
use common\models\ProfileHasAlbums;
use common\models\Genres;
use common\models\Albums;
use common\models\Musics;
use common\models\Iva;
use common\models\SearchMusics;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseVarDumper;
use yii\web\UploadedFile;
use common\models\Venda;
use common\models\Linhavenda;
use yii\helpers\BaseUrl;


/**
 * MusicsController implements the CRUD actions for Musics model.
 */
class MusicsController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function behaviors(){
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Musics models.
     * @return mixed
     */
    public function actionIndex()
    {

        //$allTheMusicsWithProducer = $this->converterMusicasComProducerArrayParaObject();

        $searchModel = new SearchMusics();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $userProvider = $this->getCurrentUser();
        $profileProvider = $this->getCurrentProfile();

        $allMusics = Musics::find()->all();
        $searchedMusics = null;

        if(!is_null($searchModel->title) && !empty($searchModel->title)){
            $searchedMusics = Musics::find()->where("lower(title) LIKE '%".strtolower($searchModel->title)."%'")->all();
        }

        if(!is_null($searchedMusics)){

            if(!is_null($userProvider)){

                $albums = null;
                $musics = null;
                $playlists = null;
                $vendas = null;

                //se tem albums
                if(!is_null($profileProvider->albums) || !empty($profileProvider->albums))
                    $albums = $profileProvider->albums;
                
                //se tem musicas
                if(!is_null($profileProvider->musics) || !empty($profileProvider->musics))
                    $musics = $profileProvider->musics;
                
                //se tem playlists
                if(!is_null($profileProvider->playlists) || !empty($profileProvider->playlists))
                    $playlists = $profileProvider->playlists;
                
                //se tem vendas
                if(!is_null($profileProvider->vendas) || !empty($profileProvider->vendas))
                    $vendas = $profileProvider->vendas;

                return $this->render('index', [
                    'searchedMusics' => $searchedMusics,
                    'albums' => $albums,
                    'musics' => $musics,
                    'playlists' => $playlists,
                    'vendas' => $vendas,
                    'searchModel' => $searchModel,
                    'allMusics' => $allMusics,
                    'userProvider' => $userProvider,
                ]);

            }
            else{
                return $this->render('index', [
                    'searchedMusics' => $searchedMusics,
                    'searchModel' => $searchModel,
                    'allMusics' => $allMusics,
                ]);
            }
        }

        if(!is_null($userProvider)){

            $albums = null;
            $musics = null;
            $playlists = null;
            $vendas = null;

            //se tem albums
            if(!is_null($profileProvider->albums) || !empty($profileProvider->albums))
                $albums = $profileProvider->albums;
            
            //se tem musicas
            if(!is_null($profileProvider->musics) || !empty($profileProvider->musics))
                $musics = $profileProvider->musics;
            
            //se tem playlists
            if(!is_null($profileProvider->playlists) || !empty($profileProvider->playlists))
                $playlists = $profileProvider->playlists;
            
            //se tem vendas
            if(!is_null($profileProvider->vendas) || !empty($profileProvider->vendas))
                $vendas = $profileProvider->vendas;

            return $this->render('index', [
                'searchedMusics' => $searchedMusics,
                'albums' => $albums,
                'musics' => $musics,
                'playlists' => $playlists,
                'vendas' => $vendas,
                'searchModel' => $searchModel,
                'allMusics' => $allMusics,
                'userProvider' => $userProvider,
            ]);

        }
        else{
            return $this->render('index', [
                'searchedMusics' => $searchedMusics,
                'searchModel' => $searchModel,
                'allMusics' => $allMusics,
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'allMusics' => $allMusics,
        ]);

        
    }


    public function getPlaylistsDoUser()
    {
        $currentProfile = $this->getCurrentProfile();

        $playlistsDoUser = [];

        foreach ($currentProfile->playlists as $musicInPlaylist) {
            array_push($playlistsDoUser, $musicInPlaylist);
        }

        return $playlistsDoUser;
    }

    /**
     * Displays a single Musics model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->redirect(['musics/index']);
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
    }

    

    public function actionBuymusic($id){


        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        }

        $currentUser = $this->getCurrentUser();
        $currentProfile = $this->getCurrentProfile();

        if($this->checkIfMusicIsBought($model->id))
            return $this->goBack();
        

        $musicasCompradasPeloUser = $currentProfile->vendas; //$this->getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica();


        if(is_null($musicasCompradasPeloUser)){

            return $this->render('buymusic', [
                'model' => $model,
                'currentUser' => $currentUser,
                'currentProfile' => $currentProfile,
            ]);
        }
        else{
            return $this->render('buymusic', [
                'model' => $model,
                'currentUser' => $currentUser,
                'currentProfile' => $currentProfile,
                'musicasCompradasPeloUser' => $musicasCompradasPeloUser,
            ]);
        }
    }

    public function actionFinishpayment($id){
        $model = $this->findModel($id);
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        

        if($this->checkIfMusicIsBought($model->id))
            return $this->goBack();

        $currentProfile->saldo = $currentProfile->saldo-$model->pvp;

        $newVenda = new Venda();
        $newVenda->data = date("Y/m/d");
        $newVenda->valorTotal = $model->pvp;
        $newVenda->profile_id = $currentProfile->id;
        $newVenda->musics_id = $model->id;
        
        $newVenda->save();

        $currentProfile->save();

        return $this->redirect(['/user/index']);
    }

    /**
     * Creates a new Musics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionAugment(){
        return $this->render('augment');
    }

    public function actionCreate()
    {

        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        $modelYourAlbums = $currentProfile->albums;

        if($currentProfile->isprodutor == 'N' || is_null($currentProfile->isprodutor || $this->checkIfCurrentUserIsProducer() === false)){
            return $this->redirect(['index']);
        }


        $model = new Musics();
        $modelGenres = Genres::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            
            $path = "uploads/";
            if(!file_exists($path))
                mkdir($path, 0777, true);

            $getMusicFile = \yii\web\UploadedFile::getInstance($model, 'musicFile');//Get the uploaded file
            $getImageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');

            if (!empty($getMusicFile))
                $model->musicFile = $getMusicFile;
            else
                return $this->render('augment');
            if(!empty($getImageFile))
                $model->imageFile = $getImageFile;
            else
                return $this->render('augment');

            if (!file_exists($path.$currentUser->id)) 
                    mkdir($path.$currentUser->id, 0777, true);
                
            $pathToSong = $path.$currentUser->id."/";
            $model->musicpath = $pathToSong;
            $model->musiccover = $pathToSong;
            $model->launchdate = date("Y/m/d");
            $model->profile_id = $currentProfile->id;
            if($model->save())
            {
                if (!empty($getMusicFile))
                    $getMusicFile->saveAs( $pathToSong . "music_" .$model->id . "_" . $model->title ."." . $getMusicFile->extension);
                if (!empty($getImageFile))
                    $getImageFile->saveAs( $pathToSong . "image_" .$model->id . "." . $getImageFile->extension);
            }

            return $this->redirect(['user/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'modelGenres' => $modelGenres,
            'modelYourAlbums' => $modelYourAlbums,
        ]);
    }



    private function getCurrentUser(){
        $userProvider = User::find()->where(['id'=>Yii::$app->user->id])->one();
        return $userProvider;
    }

    private function getCurrentProfile(){
        $profileProvider = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        return $profileProvider;
    }

    public function checkIfMusicIsBought($id){
        $currentProfile = $this->getCurrentProfile();
        foreach ($currentProfile->vendas as $venda) 
            if($venda->musics_id === $id)
                return true;
        return false;
    }


    public function checkIfCurrentUserIsProducer(){
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        foreach ($roles as $role) {
            if($role->name === 'producer' || $role->name === 'admin'){
                return true;
            }
        }
        return false;
    }




    /**
     * Updates an existing Musics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        $modelYourAlbums = $currentProfile->albums;


        $model = $this->findModel($id);
        $modelGenres = Genres::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {


            $path = "uploads/";

            $getImageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');

            if(is_null($getImageFile)){
                $model->save();
                return $this->redirect(['user/index']);
            }
            
            if(!empty($getImageFile))
                $model->imageFile = $getImageFile;
            else
                return $this->render('augment');



            $pathToSong = $path.$currentUser->id."/";
            $model->musiccover = $pathToSong;

            $model->save(false);
            
            if (!empty($getImageFile))
                $getImageFile->saveAs( $pathToSong . "image_" .$model->id . "." . $getImageFile->extension);
            
            return $this->redirect(['user/index']);
        }

        return $this->render('update', [
            'model' => $model,
            'modelGenres' => $modelGenres,
            'modelYourAlbums' => $modelYourAlbums,
        ]);
    }

    /**
     * Deletes an existing Musics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        //$this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Musics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Musics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Musics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




    public $modelClass = 'common\models\Musics';
    public $playlistsProvider = 'common\models\Playlists';
    public $userProvider = 'common\models\User';
    public $profileProvider = 'common\models\Profile';


    // TESTES PARA A API
    public function actionMusicswithproducer(){
        $models = $this->modelClass::find()->all();
        foreach ($models as $music) {
            foreach ($music->profiles as $profile) {
                $user = $this->userProvider::find()->where(['id' => $profile->user_id])->one();
                $music->producerOfThisSong = $user->username;
            }
        }
        
        BaseVarDumper::dump(BaseUrl::base());
        die();
    }

    public function actionCreatorplaylist($id){
        $playlistEmQuestao = new $this->playlistsProvider;
        $modelPlaylist = $playlistEmQuestao::findOne($id);
        $modelProfiles = new $this->profileProvider;
        $modelUser = new $this->userProvider;
        $profiles = $this->profileProvider::find()->all();
        foreach ($profiles as $profile) {
            
            $user = $this->userProvider::find()->where(['id' => $profile->user_id])->one();
            foreach ($profile->playlists as $playlist) {
                BaseVarDumper::dump($playlist);
                BaseVarDumper::dump($modelPlaylist);
                if($playlist->id == $modelPlaylist->id){
                    BaseVarDumper::dump($user->username);
                }
            }
        }
        die();
        //BaseVarDumper::dump($modelPlaylist);
        //die();

    }

}
