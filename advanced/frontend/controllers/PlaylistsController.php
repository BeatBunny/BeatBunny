<?php

namespace frontend\controllers;

use Faker\Provider\Base;
use common\models\Musics;
use Yii;
use common\models\User;
use common\models\Profile;
use common\models\Playlists;
use common\models\Genres;
use common\models\SearchPlaylists;
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
        $playlistsUserLogado = $this->getPlaylistsDoUser();

//        $generos = $this->getGenerosDasPlaylists();
        // fazer um foreach para cada uma das playlsits
        //para cada ciclo chamar funcao getgenerodasplaylists;

        foreach ($playlistsUserLogado as $cadaUmaDasPlaylists) {
            //BaseVarDumper::dump($cadaUmaDasPlaylists);
            $cadaUmaDasPlaylists = $this->getGenerosDasPlaylists($cadaUmaDasPlaylists);

            //BaseVarDumper::dump($cadaUmaDasPlaylists);
        }
        $currentUser = $this->getCurrentUser();
        $searchModel = new SearchPlaylists();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'currentUser' => $currentUser,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Playlists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Playlists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Playlists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Playlists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
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
        $profileProvider = Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
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
        $currentProfile = $this->getCurrentProfile();

        $genresDasMusicas = [];

        //die();

        foreach ($cadaUmaDasPlaylists->musics as $musicaDaPlaylist) {
            //BaseVarDumper::dump($musicaDaPlaylist->genres->nome);

            if(!in_array($musicaDaPlaylist->genres->nome, $cadaUmaDasPlaylists->generosDaPlaylist)){
                array_push($cadaUmaDasPlaylists->generosDaPlaylist, $musicaDaPlaylist->genres->nome);
            }
            
        }


        return $cadaUmaDasPlaylists;
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
