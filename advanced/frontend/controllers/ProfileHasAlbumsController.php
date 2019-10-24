<?php

namespace app\controllers;

use Yii;
use app\models\ProfileHasAlbums;
use app\models\SearchProfileHasAlbums;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileHasAlbumsController implements the CRUD actions for ProfileHasAlbums model.
 */
class ProfileHasAlbumsController extends Controller
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
     * Lists all ProfileHasAlbums models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProfileHasAlbums();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProfileHasAlbums model.
     * @param integer $profile_id
     * @param integer $albums_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $albums_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $albums_id),
        ]);
    }

    /**
     * Creates a new ProfileHasAlbums model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfileHasAlbums();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'albums_id' => $model->albums_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProfileHasAlbums model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $profile_id
     * @param integer $albums_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $albums_id)
    {
        $model = $this->findModel($profile_id, $albums_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'albums_id' => $model->albums_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProfileHasAlbums model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $profile_id
     * @param integer $albums_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $albums_id)
    {
        $this->findModel($profile_id, $albums_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProfileHasAlbums model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $profile_id
     * @param integer $albums_id
     * @return ProfileHasAlbums the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $albums_id)
    {
        if (($model = ProfileHasAlbums::findOne(['profile_id' => $profile_id, 'albums_id' => $albums_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
