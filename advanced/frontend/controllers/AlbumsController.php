<?php

namespace frontend\controllers;

use Yii;

use yii\helpers\BaseVarDumper;
use common\models\Albums;
use common\models\SearchAlbums;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Profile;
use common\models\ProfileHasMusics;
use common\models\ProfileHasAlbums;
use common\models\Genres;
use common\models\Musics;


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
        $allalbum=$this->getAlbuns();
        $currentAlbumMusic = $this->getMusicFromAlbum();
        $modelGenresMusic = $this->getMusicGenre();
        return $this->render('index', [
            'currentAlbumMusic' => $currentAlbumMusic,
            'modelGenresMusic' => $modelGenresMusic,
            'allalbum'=>$allalbum,
        ]);
    }

    public function getMusicasComProdutorReturnsArray(){
        $profileHasMusics = ProfileHasMusics::find()->all();
        $arrayComTodasAsMusicas = [];
        $musicaDesteProfile = null;
        array_filter($arrayComTodasAsMusicas);
        foreach ($profileHasMusics as $phm) {
            return $musicaDesteProfile = Musics::find()->where(['id' => $phm->musics_id])->one();
        }
    }

    public function getAlbuns(){
        $currentUser= $this->getCurrentProfile();
        $ArrayAlbuns = [];
        foreach ($currentUser->albums as $AlbunsDoPerfil){
            array_push($ArrayAlbuns, $AlbunsDoPerfil);
        }
        return $ArrayAlbuns;
    }
    public function getMusicFromAlbum(){
        $currentUser= $this->getCurrentProfile();
        $ArrayMusicasDoAlbum =[];
        foreach ($currentUser->musics as $MusicasDoAlbum){
            array_push($ArrayMusicasDoAlbum, $MusicasDoAlbum);
        }
        return $ArrayMusicasDoAlbum;

    }


    private function getProfileHasAlbumsIds(){
        $profile = $this->getCurrentProfile();
        $albums[] = null;
        foreach ($profile->albums as $album ) {
            array_push($albums, $album);
        }
        return $albums;
    }

    public function getMusicGenre(){
        $music= Musics::find()->one();
        return Genres::find()->where(['id'=>$music])->one();
    }
    public function getMusicAlbum(){
        $album=Albums::find()->one();
        return Musics::find()->where(['albums_id'=>$album])->one();
    }

//    public function converterAlbunsArrayParaObject(){
//        $todosAlbuns = Albums::find()->all();
//        $todosAlbunsArrayProdutores = $this->getProducerAlbums();
//        for ($i=0; $i < count($todosAlbuns); $i++) {
//            if($todosAlbuns[$i]->id == $todosAlbunsArrayProdutores[$i]->id){
//                $todosAlbuns[$i]->producerOfThisAlbum = $todosAlbunsArrayProdutores[$i]->producerOfThisAlbum;
//            }
//        }
//        return $todosAlbuns;
//    }
//
//    private function getProducerAlbumsIds(){
//        $profile = $this->getCurrentProfile();
//        $ProfileHasAlbums = ProfileHasAlbums::find()->where(['profile_id' => Yii::$app->user->id])->all();
//        $albums[] = null;
//        foreach ($ProfileHasAlbums as $album ) {
//            array_push($albums, $album->albums_id);
//        }
//        return $albums;
//    }
//
//    public function getProducerAlbums(){
//        $arrayDeAlbumsIds[] = $this->getProducerAlbumsIds();
//        $arrayDeAlbums = null;
//        foreach ($arrayDeAlbumsIds as $idDoAlbum) {
//            $arrayDeAlbums = Albums::find()->where(['id' => $idDoAlbum])->all();
//        }
//        return $arrayDeAlbums;
//    }
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
