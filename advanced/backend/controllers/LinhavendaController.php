<?php

namespace backend\controllers;

use Yii;
use common\models\Linhavenda;
use common\models\LinhavendaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhavendaController implements the CRUD actions for Linhavenda model.
 */
class LinhavendaController extends Controller
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
     * Lists all Linhavenda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LinhavendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Linhavenda model.
     * @param integer $id
     * @param integer $venda_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $venda_id, $musics_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $venda_id, $musics_id),
        ]);
    }

    /**
     * Creates a new Linhavenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Linhavenda();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'venda_id' => $model->venda_id, 'musics_id' => $model->musics_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Linhavenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $venda_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $venda_id, $musics_id)
    {
        $model = $this->findModel($id, $venda_id, $musics_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'venda_id' => $model->venda_id, 'musics_id' => $model->musics_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Linhavenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $venda_id
     * @param integer $musics_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $venda_id, $musics_id)
    {
        $this->findModel($id, $venda_id, $musics_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Linhavenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $venda_id
     * @param integer $musics_id
     * @return Linhavenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $venda_id, $musics_id)
    {
        if (($model = Linhavenda::findOne(['id' => $id, 'venda_id' => $venda_id, 'musics_id' => $musics_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
