<?php

namespace frontend\controllers;


use bar\baz\source_with_namespace;
use common\models\LoginForm;
use common\models\Playlists;
use common\models\PlaylistsHasMusics;
use DeepCopy\f001\B;
use Faker\Provider\Base;
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
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'musicdel','addtoplaylist'],
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
        $currentProfile = $this->getCurrentProfile();
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $currentUser = $this->getCurrentUser();
            $albums = $currentProfile->albums;
            if(!is_null($currentProfile->playlists) || !empty($currentProfile->playlists)) {
                $playlists = $currentProfile->playlists;
                return $this->render('index', [
                    'currentProfile' => $currentProfile,
                    'playlists' => $playlists,
                    'currentUser' => $currentUser,
                    'albums' => $albums,]);

            }else{
                return $this->render('index', [
                    'currentProfile' => $currentProfile,
                    'currentUser' => $currentUser,
                    'albums' => $albums,
                ]);
            }
        }
            return $this->redirect(['site/index']);
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
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $currentUser = $this->getCurrentUser();
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
        return $this->redirect(['site/index']);
    }

    public function actionEdit(){
        $currentProfile = $this->getCurrentProfile();
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $currentUser = $this->getCurrentUser();
            $model = $currentProfile->albums();
            return $this->render('edit', ['userProvider' => $currentUser, 'profileProvider' => $currentProfile, 'model' => $model]);
        }
        return $this->redirect(['site/index']);
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
        $currentProfile = $this->getCurrentProfile();
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $currentUser = $this->getCurrentUser();
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
        return $this->redirect(['site/index']);
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
        $currentProfile = $this->getCurrentProfile();
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $currentAlbum = $this->findModel($album);
            $currentMusic = Musics::find($music)->where(['albums_id' => $album])->one();
            $deleteMusic = $currentAlbum->unlink('musics', $currentMusic);
            return $this->redirect(['index']);
        }
        return $this->redirect(['site/index']);
    }
    
    public function dellAllMusic($album){
        $currentProfile = $this->getCurrentProfile();
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $albums = $this->findModel($album);
            $allMusic = Musics::find()->where(['albums_id' => $albums])->all();
            foreach ($allMusic as $currentMusic)
                $deleteMusic = $albums->unlink('musics', $currentMusic);
        }
        return $this->redirect(['site/index']);
    }

    public function actionDelete($id)
    {
        $currentProfile = $this->getCurrentProfile();
        if (Yii::$app->user->can('accessAll')&&($currentProfile->isprodutor == 'S')) {
            $currentAlbum = $this->findModel($id)->id;
            $deleteAllMusicsOnAlbum = $this->dellAllMusic($id);
            $profileHasAlbumAlbumDelete = ProfileHasAlbums::find()->where(['albums_id' => $currentAlbum])->one()->delete();
            return $this->redirect(['index']);
        }
        return $this->redirect(['site/index']);
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

    public function actionAddtoplaylist($musics_id, $playlists_id) {
        if ((Yii::$app->user->can('accessAll'))) {
            $currentUser = $this->getCurrentUser();
            $roles = Yii::$app->authManager->getRolesByUser($currentUser->id);
            foreach ($roles as $role) {
                if ($role->name === 'producer') {
                    break;
                } else {
                    return $this->redirect(['index']);
                }
            }
            $modelMusics = Musics::find()->where(['id' => $musics_id])->one();

            $modelPlaylists = Playlists::find()->where(['id' => $playlists_id])->one();

            $playlistsHasMusics = new PlaylistsHasMusics();

            $playlistsHasMusics->playlists_id = $modelPlaylists->id;

            $playlistsHasMusics->musics_id = $modelMusics->id;

            $playlistsHasMusics->save();

            return $this->redirect(['index']);
        }
        return $this->redirect(['site/index']);
    }

    private function getCurrentUser(){
        return User::find()->where(['id'=>Yii::$app->user->id])->one();
    }

    private function getCurrentProfile(){
        return Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
    }
}
