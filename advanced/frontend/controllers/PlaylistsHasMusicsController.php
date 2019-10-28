<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PlaylistsHasMusics;
use frontend\models\SearchPlaylistsHasMusics;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlaylistsHasMusicsController implements the CRUD actions for PlaylistsHasMusics model.
 */
class PlaylistsHasMusicsController extends Controller
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
     * Lists all PlaylistsHasMusics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPlaylistsHasMusics();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlaylistsHasMusics model.
     * @param integer $playlists_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($playlists_id, $musics_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($playlists_id, $musics_id),
        ]);
    }

    /**
     * Creates a new PlaylistsHasMusics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlaylistsHasMusics();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'playlists_id' => $model->playlists_id, 'musics_id' => $model->musics_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PlaylistsHasMusics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $playlists_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($playlists_id, $musics_id)
    {
        $model = $this->findModel($playlists_id, $musics_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'playlists_id' => $model->playlists_id, 'musics_id' => $model->musics_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PlaylistsHasMusics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $playlists_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($playlists_id, $musics_id)
    {
        $this->findModel($playlists_id, $musics_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlaylistsHasMusics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $playlists_id
     * @param integer $musics_id
     * @return PlaylistsHasMusics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($playlists_id, $musics_id)
    {
        if (($model = PlaylistsHasMusics::findOne(['playlists_id' => $playlists_id, 'musics_id' => $musics_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
