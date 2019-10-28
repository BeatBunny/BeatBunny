<?php

namespace frontend\controllers;

use Yii;
use app\models\ProfileHasPlaylists;
use app\models\SearchProfileHasPlaylists;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileHasPlaylistsController implements the CRUD actions for ProfileHasPlaylists model.
 */
class ProfileHasPlaylistsController extends Controller
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
     * Lists all ProfileHasPlaylists models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProfileHasPlaylists();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProfileHasPlaylists model.
     * @param integer $profile_id
     * @param integer $playlists_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $playlists_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $playlists_id),
        ]);
    }

    /**
     * Creates a new ProfileHasPlaylists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfileHasPlaylists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'playlists_id' => $model->playlists_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProfileHasPlaylists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $profile_id
     * @param integer $playlists_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $playlists_id)
    {
        $model = $this->findModel($profile_id, $playlists_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'playlists_id' => $model->playlists_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProfileHasPlaylists model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $profile_id
     * @param integer $playlists_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $playlists_id)
    {
        $this->findModel($profile_id, $playlists_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProfileHasPlaylists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $profile_id
     * @param integer $playlists_id
     * @return ProfileHasPlaylists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $playlists_id)
    {
        if (($model = ProfileHasPlaylists::findOne(['profile_id' => $profile_id, 'playlists_id' => $playlists_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
