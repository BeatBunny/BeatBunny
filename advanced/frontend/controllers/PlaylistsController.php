<?php

namespace frontend\controllers;

use common\models\PlaylistsHasMusics;
use common\models\ProfileHasPlaylists;
use Faker\Provider\Base;
use common\models\Musics;
use Yii;
use common\models\User;
use common\models\Profile;
use common\models\Playlists;
use common\models\Genres;
use common\models\SearchPlaylists;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseVarDumper;

/**
 * PlaylistsController implements the CRUD actions for Playlists model.
 */
class PlaylistsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete','musicdel','addsong'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Playlists models.
     * @return mixed
     */
    public function actionIndex()
    {
        $currentProfile= $this->getCurrentProfile();
        $currentUser= $this->getCurrentUser();

        $playlistsUserLogado = $this->getPlaylistsDoUser();

        $playlistHasMusics = new PlaylistsHasMusics();

        foreach ($playlistsUserLogado as $cadaUmaDasPlaylists) {

            $this->getGenerosDasPlaylists($cadaUmaDasPlaylists);
        }
        $searchModel = new SearchPlaylists();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'currentUser' => $currentUser,
            'playlistHasMusics' => $playlistHasMusics,
            'playlistsUserLogado' => $playlistsUserLogado,
        ]);
    }

    /**
     * Displays a single Playlists model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $currentUser= $this->getCurrentUser();
        
        $model = $this->findModel($id);

        $model = $this->getGenerosDasPlaylists($model);

        return $this->render('view', [
            'currentUser' => $currentUser,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Playlists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $currentProfile = $this->getCurrentProfile();
        $model = new Playlists();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $profileHasPlaylists = new ProfileHasPlaylists();
            $profileHasPlaylists->playlists_id = $model->id;
            $profileHasPlaylists->profile_id = $currentProfile->id;
            $profileHasPlaylists->save();
            return $this->redirect(['playlists/index']);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Playlists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Playlists model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $currentUser= $this->getCurrentUser();
        $currentPlaylist = $this->findModel($id)->id;
        if(!is_null(PlaylistsHasMusics::find()->where(['playlists_id' => $id])->one()))
            $songsToDeleteFromPlaylist = PlaylistsHasMusics::find()->where(['playlists_id' => $id])->one()->delete();
        if(!is_null(ProfileHasPlaylists::find()->where(['playlists_id' => $id])->one()))
            $deletePlaylistFromProfileHasPlaylists = ProfileHasPlaylists::find()->where(['playlists_id' => $id])->one()->delete();
        //$playlistToDelete->unlink();
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Playlists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Playlists the loaded model
     * @throws NotFoundHttpException if the model cannot be founds
     */
    protected function findModel($id)
    {
        if (($model = Playlists::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function getCurrentUser(){
        $userProvider = User::find()->where(['id'=>Yii::$app->user->id])->one();

        return $userProvider;
    }

    private function getCurrentProfile(){
        $profileProvider = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        return $profileProvider;
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

    public function getGenerosDasPlaylists($cadaUmaDasPlaylists)
    {
        foreach ($cadaUmaDasPlaylists->musics as $musicaDaPlaylist) {
            //BaseVarDumper::dump($musicaDaPlaylist->genres->nome);

            if(!in_array($musicaDaPlaylist->genres->nome, $cadaUmaDasPlaylists->generosDaPlaylist)){
                array_push($cadaUmaDasPlaylists->generosDaPlaylist, $musicaDaPlaylist->genres->nome);
            }

        }
        return $cadaUmaDasPlaylists;
    }

    public function actionAddsong($musics_id, $playlists_id) {
        $currentUser= $this->getCurrentUser();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'client'|| $role->name === 'producer') {
                break;
            } else {
                return $this->redirect(['index']);
            }
        }
        $modelMusics = Musics::find()->where(['id' => $musics_id])->one();

        $modelPlaylists = Playlists::find()->where(['id' => $playlists_id])->one();

        $playlistsHasMusics = new PlaylistsHasMusics();

        $playlistsHasMusics->playlists_id = $modelPlaylists->id;

        $playlistsHasMusics->musics_id = $modelMusics->id;

        $playlistsHasMusics->save();

        return $this->redirect(['musics/index']);
    }

    public function actionMusicdel($musics_id, $playlists_id)
    {
        $modelMusics = Musics::find()->where(['id' => $musics_id])->one();
        $modelPlaylists = Playlists::find()->where(['id' => $playlists_id])->one();
        PlaylistsHasMusics::find($modelMusics)->where(['playlists_id' => $modelPlaylists])->one()->delete();
//        $deleteMusic=$modelMusics->unlink('musics',$currentMusic, $delete=true);

        return $this->redirect(['index']);
    }


    




        /*die();


        $idsDasPlaylistsDoUserLoggado = $this->getPlaylistsDoUserLogado();

        foreach ($idsDasPlaylistsDoUserLoggado as $idDaPlaylist) {
            $playlistHasMusics = PlaylistsHasMusics::find()->where(['playlists_id' => $idDaPlaylist])->all();

            $musicIds [] = null;
            foreach ($playlistHasMusics as $music) {
                array_push($musicIds, $music->musics_id);
            }

        }

        return $musicIds;

    }

    public function getMusicsList(){
        $arrayDeMusicIds = $this->getMusicasDasPlaylists();


        $arrayDeMusicas = null;
        foreach ($arrayDeMusicIds as $idDaMusica) {
            $arrayDeMusicas = Musics::find()->where(['id' => $idDaMusica])->all();
        }

        return $arrayDeMusicas;
    }
*/
   /* public function getPlaylistsDesteProfileReturnsArray(){
        $profileHasPlaylists = ProfileHasPlaylists::find()->all();
        $arrayComTodasAsPlaylists = [];
        $criadorDestaPlaylist = null;
        $playlistDesteProfile = null;
        array_filter($arrayComTodasAsPlaylists);
        foreach ($profileHasPlaylists as $php) {
            $criadorDestaPlaylist = User::find()->where(['id' => $php->profile_id])->one();
            $playlistDesteProfile = Playlists::find()->where(['id' => $php->playlists_id])->one();

            //BaseVarDumper::dump($criadorDestaMusica);
            $musicaDesteProfile->producerOfThisSong = $criadorDestaMusica->username;
            //BaseVarDumper::dump($musicaDesteProfile);
            array_push($arrayComTodasAsMusicas, $musicaDesteProfile);
            //BaseVarDumper::dump($arrayComTodasAsMusicas);
            //echo "<br><br><br>";
        }
        return $arrayComTodasAsMusicas;
    }


    public function converterPlaylistsDoUserArrayParaObject(){
        $todasAsPlaylists = Playlists::find()->all();

        $todasAsPlaylistsArray = $this->getPlaylistsDesteProfileReturnsArray();



        for ($i=0; $i < count($todasAsPlaylistsArray); $i++) {
            if($todasAsPlaylists[$i]->id == $todasAsPlaylistsArray[$i]->id){
                $todasAsPlaylists[$i]->producerOfThisSong = $todasAsPlaylistsArray[$i]->producerOfThisSong;
            }
        }

        return $todasAsPlaylists;
    }
*/
    //FAZER GET DAS MUSICAS DAS PLAYLISTS
}
