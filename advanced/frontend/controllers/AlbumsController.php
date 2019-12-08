<?php

namespace frontend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\BaseVarDumper;
use yii\web\UploadedFile;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'musicdel','deleteallmusic'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $currentUser= $this->getCurrentUser();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'producer') {
                break;
            } else {
                return $this->redirect(['site/index']);
            }
        }
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        if(empty($currentProfile->albums)){
            return $this->render('index', [
                'currentProfile' => $currentProfile,
                'currentUser' => $currentUser,
            ]);
        }
        $albums = $currentProfile->albums;
        $albumsFromCurrentProfile = $this->putProducerInEveryMusicInTheAlbums($albums);
        $currentAlbumMusic = $this->getMusicFromAlbum();
        $modelGenresMusic = $this->getMusicGenre();
        return $this->render('index', [
            'currentProfile' => $currentProfile,
            'currentUser' => $currentUser,
            'albumsFromCurrentProfile'=>$albumsFromCurrentProfile,
        ]);
    }

    public function putProducerInEveryMusicInTheAlbums($albumsFromCurrentProfile){
        $currentUser = $this->getCurrentUser();
        foreach ($albumsFromCurrentProfile as $album) {
            foreach ($album->musics as $music) {
                $music->producerOfThisSong = $currentUser->username;
            }
        }
        return $albumsFromCurrentProfile;
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
        $music = Musics::find()->one();
        return Genres::find()->where(['id'=>$music])->one();
    }

    public function getMusicAlbum(){
        $album = Albums::find()->one();
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
            $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
            foreach ($roles as $role) {
                if ($role->name === 'producer') {
                    break;
                } else {
                    return $this->redirect(['index']);
                }
            }
            $model = new Albums();
            $allgenres = Genres::find()->all();

            if ($model->load(Yii::$app->request->post())) {

                $path = "uploads/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                $getImageFile = \yii\web\UploadedFile::getInstance($model, 'albumcover');

                if (!empty($getImageFile))
                    $model->albumcover = $getImageFile;
                else
                    return $this->render('augment');

                if (!file_exists($path . $currentUser->id))
                    mkdir($path . $currentUser->id, 0777, true);

                $pathToAlbumCover = $path . $currentUser->id . "/";
                $model->albumcover = $pathToAlbumCover;

                $model->launchdate = date("Y/m/d");
                if ($model->save()) {
                    if (!empty($getImageFile)) {
                        $getImageFile->saveAs($pathToAlbumCover . "albumcover_" . $model->id . "." . $getImageFile->extension);
                    }
                    $profileHasAlbums = new ProfileHasAlbums();
                    $profileHasAlbums->albums_id = $model->id;
                    $profileHasAlbums->profile_id = $currentProfile->id;
                    $profileHasAlbums->save();
                }

                return $this->redirect(['albums/index']);
            }

            return $this->render('create', [
                'allgenres' => $allgenres,
                'currentProfile' => $currentProfile,
                'model' => $model,
            ]);
    }

    public function actionEdit(){
        $currentUser= $this->getCurrentUser();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'producer') {
                break;
            } else {
                return $this->redirect(['index']);
            }
        }
        $currentProfile= $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        $model = $currentProfile->albums();
        return $this->render('edit', ['userProvider' => $currentUser, 'profileProvider' => $currentProfile, 'model'=> $model]);
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
        $currentUser = $this->getCurrentUser();
        $currentProfile= $this->getCurrentProfile();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'producer') {
                break;
            } else {
                $this->redirect(['index']);
            }
        }
        $albumsFromCurrentProfile = $currentProfile->albums;
        $modelGenres = Genres::find()->all();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $path = "uploads/";
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $getImageFile = \yii\web\UploadedFile::getInstance($model, 'albumcover');
            if (!empty($getImageFile)){
                $model->albumcover = $getImageFile;
        }else {
                return $this->render('augment');
            }
                $pathToAlbumCover = $path . $currentUser->id ."/";
                $model->albumcover = $pathToAlbumCover;
            if(!empty($getImageFile)) {
                $getImageFile->saveAs($pathToAlbumCover . "albumcover_" . $model->id . "." . $getImageFile->extension);
            }
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'modelGenres' => $modelGenres,
            'albumsFromCurrentProfile' => $albumsFromCurrentProfile]);
    }

    /**
     * Deletes an existing Albums model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $album
     * @param $music
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     * @throws \Throwable
     */

    public function actionMusicdel($album, $music)
    {
        $currentUser= $this->getCurrentUser();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'producer') {
                break;
            } else {
                return $this->redirect(['index']);
            }
        }
            $getAlbumId=$this->findModel($album)->id;
            $getOneMusicFromAll=Musics::find($music)->one();
            $currentMusic=Musics::find($getOneMusicFromAll)->where(['albums_id' => $getAlbumId])->one();
            $deleteMusic=$currentMusic->unlink('albums',$currentMusic);
            return $this->redirect(['index']);
    }
    public function actionDeleteallmusic($album){
        $currentUser= $this->getCurrentUser();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'producer') {
                break;
            } else {
                return $this->redirect(['index']);
            }
        }
        $albums=$this->findModel($album)->id;
        $allMusic=Musics::find()->where(['albums_id' => $albums])->all();
        foreach ($allMusic as $currentMusic)
            $deleteMusic=$currentMusic->unlink('albums',$currentMusic);
        return $this->redirect(['index']);
    }
    public function actionDelete($id)
    {
        $currentUser= $this->getCurrentUser();
        $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
        foreach ($roles as $role) {
            if ($role->name === 'producer') {
                break;
            } else {
                return $this->redirect(['index']);
            }
        }
        $currentAlbum = $this->findModel($id)->id;
        $profileHasAlbumAlbumDelete = ProfileHasAlbums::find()->where(['albums_id' => $currentAlbum])->one()->delete();
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


    private function getProducerAlbumsIds(){
        $profile = $this->getCurrentProfile();
        $ProfileHasAlbums = ProfileHasAlbums::find()->where(['profile_id' => Yii::$app->user->id])->all();
        $albums[] = null;
        foreach ($ProfileHasAlbums as $album ) {
            array_push($albums, $album->albums_id);
        }
        return $albums;
    }

    private function getCurrentUser(){
        return User::find()->where(['id'=>Yii::$app->user->id])->one();
    }

    private function getCurrentProfile(){
        return Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
    }
}
