<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Albums;
use frontend\models\SearchAlbums;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\ProfileHasMusics;
use frontend\models\ProfileHasAlbums;
use frontend\models\Genres;
use frontend\models\Musics;


/**
 * AlbumsController implements the CRUD actions for Albums model.
 */
class AlbumsController extends Controller
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
     * Lists all Albums models.
     * @return mixed
     */
    public function actionIndex()
    {
        $currentAlbum = $this->getAlbumTestando();
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        $modelGenres = $this->getGenres();
        $searchModel = new SearchAlbums();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'currentAlbum'=> $currentAlbum,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'genres' =>$modelGenres,
            'currentUser' =>$currentUser,
            'currentProfile' =>$currentProfile,
        ]);
    }
public function getAlbuns(){
        return Albums::find()->where(['id' => Yii::$app->user->id])->all();
}
    public function getGenres(){
        return Genres::find()->where(['id'=>Yii::$app->user->id])->one();

    }

    public function converterAlbunsArrayParaObject(){
        $todosAlbuns = Albums::find()->all();
        $todosAlbunsArrayProdutores = $this->getProducerAlbums();
        for ($i=0; $i < count($todosAlbuns); $i++) {
            if($todosAlbuns[$i]->id == $todosAlbunsArrayProdutores[$i]->id){
                $todosAlbuns[$i]->producerOfThisAlbum = $todosAlbunsArrayProdutores[$i]->producerOfThisAlbum;
            }
        }
        return $todosAlbuns;
    }
    private function getProducerAlbumsIds(){
        $profile = $this->getCurrentProfile();
        $ProfileHasAlbums = ProfileHasAlbums::find()->where(['profile_id' => Yii::$app->user->id])->all();
        $albums[] = null;
        foreach ($ProfileHasAlbums as $album ) {
            array_push($albums, $album->albums_id);
        }
        return $albums;
    }
    public function getProducerAlbums(){
        $arrayDeAlbumsIds[] = $this->getProducerAlbumsIds();
        $arrayDeAlbums = null;
        foreach ($arrayDeAlbumsIds as $idDoAlbum) {
            $arrayDeAlbums = Albums::find()->where(['id' => $idDoAlbum])->all();
        }
        return $arrayDeAlbums;
    }
    /**
     * Displays a single Albums model.
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
     * Creates a new Albums model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        $model = new Albums();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Albums model.
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
     * Deletes an existing Albums model.
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
     * Finds the Albums model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Albums the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Albums::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
    ****************************************************************************************
     **/
    private function getCurrentUser(){
        return User::find()->where(['id'=>Yii::$app->user->id])->one();
    }

    private function getCurrentProfile(){
        return Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
    }
}
