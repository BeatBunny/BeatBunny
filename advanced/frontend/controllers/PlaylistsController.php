<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\Playlists;
use frontend\models\ProfileHasPlaylists;
use frontend\models\PlaylistsHasMusics;
use frontend\models\SearchPlaylists;
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
        $allThePlaylistsFromCurrentUser = $this->getPlaylistsList();

        $currentUser = $this->getCurrentUser();

        $searchModel = new SearchPlaylists();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'allThePlaylistsFromCurrentUser' => $allThePlaylistsFromCurrentUser,
            'currentUser' => $currentUser,
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

    public function getPlaylistsDoUserLogado(){
        $profile = $this->getCurrentProfile()->id;
        $profileHasPlaylists = ProfileHasPlaylists::find()->where(['profile_id' => $profile])->all();

        $playlistsIds[] = null;
        foreach ($profileHasPlaylists as $playlist ) {
            array_push($playlistsIds, $playlist->playlists_id);
        }

        return $playlistsIds;
    }

    public function getPlaylistsList(){
        $arrayDePlaylistIds[] = $this->getPlaylistsDoUserLogado();


        $arrayDePlaylists = null;
        foreach ($arrayDePlaylistIds as $idDaPlaylist) {
            $arrayDePlaylists = Playlists::find()->where(['id' => $idDaPlaylist])->all();
        }

        return $arrayDePlaylists;
    }

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
