<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Playlists;
use frontend\models\SearchPlaylists;
use frontend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $currentUser = $this->getCurrentUser();

        $searchModel = new SearchPlaylists();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $profileHasPlaylists = ProfileHasPlaylists::find()->where(['profile_id' => Yii::$app->user->id])->all();
        $playlistsIds[] = null;
        foreach ($profileHasPlaylists as $playlist ) {
            array_push($playlists, $playlist->playlists_id);
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
}
