<?php

namespace backend\models;

use Yii;
use common\models\ProfileHasMusics;
use common\models\SearchProfileHasMusics;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileHasMusicsController implements the CRUD actions for ProfileHasMusics model.
 */
class ProfileHasMusicsController extends Controller
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
     * Lists all ProfileHasMusics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProfileHasMusics();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProfileHasMusics model.
     * @param integer $profile_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $musics_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $musics_id),
        ]);
    }

    /**
     * Creates a new ProfileHasMusics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfileHasMusics();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'musics_id' => $model->musics_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProfileHasMusics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $profile_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $musics_id)
    {
        $model = $this->findModel($profile_id, $musics_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'musics_id' => $model->musics_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProfileHasMusics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $profile_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $musics_id)
    {
        $this->findModel($profile_id, $musics_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProfileHasMusics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $profile_id
     * @param integer $musics_id
     * @return ProfileHasMusics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $musics_id)
    {
        if (($model = ProfileHasMusics::findOne(['profile_id' => $profile_id, 'musics_id' => $musics_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
