<?php

namespace backend\models;

use Yii;
use common\models\ProfileHasAlbums;
use common\models\SearchProfileHasAlbums;
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
     * @param integer $albums_id
     * @param integer $profile_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($albums_id, $profile_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($albums_id, $profile_id),
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
            return $this->redirect(['view', 'albums_id' => $model->albums_id, 'profile_id' => $model->profile_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProfileHasAlbums model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $albums_id
     * @param integer $profile_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($albums_id, $profile_id)
    {
        $model = $this->findModel($albums_id, $profile_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'albums_id' => $model->albums_id, 'profile_id' => $model->profile_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProfileHasAlbums model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $albums_id
     * @param integer $profile_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($albums_id, $profile_id)
    {
        $this->findModel($albums_id, $profile_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProfileHasAlbums model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $albums_id
     * @param integer $profile_id
     * @return ProfileHasAlbums the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($albums_id, $profile_id)
    {
        if (($model = ProfileHasAlbums::findOne(['albums_id' => $albums_id, 'profile_id' => $profile_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
