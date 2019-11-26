<?php

namespace frontend\controllers;
use Yii;
use common\models\Musics;
use frontend\controllers\PlaylistsController;
use common\models\User;
use yii\web\Controller;
use yii\helpers\BaseVarDumper;
use yii\web\NotFoundHttpException;
use common\models\Profile;
use common\models\ProfileHasMusics;
use common\models\Venda;
use common\models\Linhavenda;

/**
 * UserController implements the CRUD actions for User model.
 * @property string password_hash
 * @property mixed password
 */
class UserController extends Controller
{

    // /**
    //  * {@inheritdoc}
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    // /**
    //  * Lists all User models.
    //  * @return mixed
    //  */
    // public function actionIndex()
    // {
    //     $searchModel = new SearchUser();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // /**
    //  * Displays a single User model.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    // /**
    //  * Creates a new User model.
    //  * If creation is successful, the browser will be redirected to the 'view' page.
    //  * @return mixed
    //  */
    // public function actionCreate()
    // {
    //     $model = new User();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing User model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Deletes an existing User model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    public function getCurrentUser()
    {
        return User::find()->where(['id' => Yii::$app->user->id])->one();
    }

    public function getCurrentProfile()
    {
        return Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
    }

    public function countHowManyMusicsProducerHas()
    {
        return count(ProfileHasMusics::find()->where(['profile_id' => Yii::$app->user->id])->all());
    }

    public function getPlaylistsDoUser()
    {
        $currentProfile = $this->getCurrentProfile();

        $playlistsDoUser = [];

        foreach ($currentProfile->playlists as $musicInPlaylist) {
            array_push($playlistsDoUser, $musicInPlaylist);
        }

        return $playlistsDoUser;
    }

    public function getGenerosDasPlaylists($cadaUmaDasPlaylists)
    {
        $currentProfile = $this->getCurrentProfile();

        $genresDasMusicas = [];

        //die();

        foreach ($cadaUmaDasPlaylists->musics as $musicaDaPlaylist) {
            //BaseVarDumper::dump($musicaDaPlaylist->genres->nome);

            if(!in_array($musicaDaPlaylist->genres->nome, $cadaUmaDasPlaylists->generosDaPlaylist)){
                array_push($cadaUmaDasPlaylists->generosDaPlaylist, $musicaDaPlaylist->genres->nome);
            }

        }


        return $cadaUmaDasPlaylists;
    }

    //BUSCA A LISTA DE MUSICAS DO PRODUTOR
    private function getProducerMusicsIds()
    {
        $profile = $this->getCurrentProfile();
        $user = $this->getCurrentUser();
        $ProfileHasMusics = ProfileHasMusics::find()->where(['profile_id' => $user->id])->all();
        $musicas[] = null;
        foreach ($ProfileHasMusics as $music) {
            array_push($musicas, $music->musics_id);
        }
        return $musicas;
    }

    public function getProducerMusics()
    {
        $arrayDeMusicasIds[] = $this->getProducerMusicsIds();
        $arrayDeMusicas = null;
        foreach ($arrayDeMusicasIds as $idDaMusica) {
            $arrayDeMusicas = Musics::find()->where(['id' => $idDaMusica])->all();
        }
        return $arrayDeMusicas;
    }


    public function countHowManyAlbumsProducerHas()
    {
        return count(ProfileHasAlbums::find()->where(['profile_id' => Yii::$app->user->id])->all());
    }

    private function getProducerAlbumsIds()
    {
        $profile = $this->getCurrentProfile();
        $ProfileHasAlbums = ProfileHasAlbums::find()->where(['profile_id' => $profile->id_user])->all();
        $albums[] = null;
        foreach ($ProfileHasAlbums as $album) {
            array_push($albums, $album->albums_id);
        }
        return $albums;
    }

    public function getProducerAlbums()
    {
        $arrayDeAlbumsIds[] = $this->getProducerAlbumsIds();
        $arrayDeAlbums = null;
        foreach ($arrayDeAlbumsIds as $idDoAlbum) {
            $arrayDeAlbums = Albums::find()->where(['id' => $idDoAlbum])->all();
        }
        return $arrayDeAlbums;
    }


    public function getVendasUserLogado()
    {
        $profile = $this->getCurrentProfile();
        $vendaDoUserLogado = Venda::find()->where(['profile_id' => $profile->id])->all();

        return $vendaDoUserLogado;
    }


    public function getLinhavendaUserLogado()
    {
        $arrayVendasIds = $this->getVendasUserLogado();

        // BaseVarDumper::dump($arrayVendasIds);

        // die();

        $LinhavendaUserLogado = [];
        array_filter($LinhavendaUserLogado);

        foreach ($arrayVendasIds as $venda) {
            array_push($LinhavendaUserLogado, Linhavenda::find()->where(['venda_id' => $venda->id])->one());
        }


        // BaseVarDumper::dump($LinhavendaUserLogado);

        // die();

        return $LinhavendaUserLogado;
    }


    public function getMusicasPelasLinhaDeVendaDoUserLogado()
    {

        $LinhavendaDoUser = $this->getLinhavendaUserLogado();
        $musicasCompradasPeloUser = [];

        for ($i = 0; $i < count($LinhavendaDoUser); $i++) {
            array_push($musicasCompradasPeloUser, Musics::find()->where(['id' => $LinhavendaDoUser[$i]->musics_id])->one());
        }

        return $musicasCompradasPeloUser;

    }

    public function getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica()
    {

        $musicasCompradasPeloUser = $this->getMusicasPelasLinhaDeVendaDoUserLogado();

        $profileHasMusics = ProfileHasMusics::find()->all();

        $arrayComTodasAsMusicas = [];
        array_filter($arrayComTodasAsMusicas);

        foreach ($profileHasMusics as $phm) {
            $criadorDestaMusica = User::find()->where(['id' => $phm->profile_id])->one();
            $musicaDesteProfile = Musics::find()->where(['id' => $phm->musics_id])->one();
            $musicaDesteProfile->producerOfThisSong = $criadorDestaMusica->username;
            array_push($arrayComTodasAsMusicas, $musicaDesteProfile);
        }
        if (!is_null($musicasCompradasPeloUser) && !empty($musicasCompradasPeloUser)) {
            for ($l = 0; $l < count($musicasCompradasPeloUser); $l++) {

                for ($i = 0; $i < count($arrayComTodasAsMusicas); $i++) {
                    if ($musicasCompradasPeloUser[$l]->id === $arrayComTodasAsMusicas[$i]->id) {
                        $musicasCompradasPeloUser[$l]->producerOfThisSong = $arrayComTodasAsMusicas[$i]->producerOfThisSong;
                    }
                }
            }
            return $musicasCompradasPeloUser;
        } else {
            return null;
        }
    }


    public function meterUsernameNoCampoProducer(){
        $profileProvider = $this->getCurrentProfile();
        $userProvider = $this->getCurrentUser();

        foreach ($profileProvider->musics as $musicFromProfile) {
            $musicFromProfile->producerOfThisSong = $userProvider->username;
        }

        return $profileProvider->musics;

    }


    public function getMusicasCompradasdoUserLogado(){
        $profileProvider = $this->getCurrentProfile();
        $userProvider = $this->getCurrentUser();
        $comprasDoUser = [];
        foreach ($profileProvider->vendas as $venda) {
            array_push($comprasDoUser, $venda->linhavendas[0]->musics);
        }
        return $comprasDoUser;
    }

    public function meterUsernameNoCampoProducerNasMusicasCompradas($musicasCompradas){
        $profileProvider = $this->getCurrentProfile();
        $userProvider = $this->getCurrentUser();

        $musicasSemProducer = Musics::find()->all();
        $todosOsProfiles = Profile::find()->all();


        foreach ($todosOsProfiles as $profile) {
            $thisUser = User::find()->where(['id' => $profile->id_user])->one();
            for ($i=0; $i < count($profile->musics); $i++) { 
                if($profile->musics[$i]->id === $musicasCompradas[$i]->id){
                    $musicasCompradas[$i]->producerOfThisSong = $thisUser->username;
                }
            }
        }

        return $musicasCompradas;

    }




    public function actionIndex()
    {


        $profileProvider = $this->getCurrentProfile();

        $userProvider = $this->getCurrentUser();

        $musicsFromProducerWithUsername = $this->meterUsernameNoCampoProducer();

        $numberOfSongsYouHave = count($musicsFromProducerWithUsername);

        $musicasCompradas = $this->getMusicasCompradasdoUserLogado();

        $playlistsUserLogado = $this->getPlaylistsDoUser();

        foreach ($playlistsUserLogado as $cadaUmaDasPlaylists) {
            //BaseVarDumper::dump($cadaUmaDasPlaylists);
            $cadaUmaDasPlaylists = $this->getGenerosDasPlaylists($cadaUmaDasPlaylists);
            //BaseVarDumper::dump($cadaUmaDasPlaylists);
        }





        if(empty($musicasCompradas))
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'playlistsUserLogado' => $playlistsUserLogado]);

        elseif(empty($allThePlaylistsFromCurrentUser)) {
            $musicasCompradas = $this->meterUsernameNoCampoProducerNasMusicasCompradas($musicasCompradas);
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'musicasCompradas' => $musicasCompradas, 'playlistsUserLogado' => $playlistsUserLogado]);
        }
        elseif(empty($musicasCompradas && empty($allThePlaylistsFromCurrentUser)))
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'playlistsUserLogado' => $playlistsUserLogado ]);

        else{
            $musicasCompradas = $this->meterUsernameNoCampoProducerNasMusicasCompradas($musicasCompradas);
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'musicasCompradas' => $musicasCompradas, 'playlistsUserLogado' => $playlistsUserLogado]);
        }
    }

    /* public function actionSettings(){

         $profileProvider = $this->getCurrentProfile();
         $userProvider = $this->getCurrentUser();
         //$userProvider = Yii::$app->user;
         return $this->render('settings', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider]);
     }*

     /**
      * Finds the User model based on its primary key value.
      * If the model is not found, a 404 HTTP exception will be thrown.
      * @param integer $id
      * @return User the loaded model
      * @throws NotFoundHttpException if the model cannot be found
      */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //GUARDAR SETTINGS
    public function actionSettings()
    {
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        if ($currentProfile->load(Yii::$app->request->post())) {
            $path = "uploads/";
            if (!file_exists($path))
                mkdir($path, 0777, true);

            $getImageFile = \yii\web\UploadedFile::getInstance($currentProfile, 'profileFile');

            if (!empty($getImageFile)) 
                $currentProfile->profileFile = $getImageFile;
            else
                return $this->render('augment');

            if (!file_exists($path . $currentUser->id))
                mkdir($path . $currentUser->id, 0777, true);

            $pathToProfileimage = $path . $currentUser->id . "/";
            $currentProfile->profileimage = $pathToProfileimage;


            $currentProfile->save();

            if (!empty($getImageFile))
                $getImageFile->saveAs($pathToProfileimage . "profileimage_" . $currentUser->id . "." . $getImageFile->extension);
        }
//        $currentUser->setScenario('changePwd');
//        $currentUser->password = md5($currentUser->new_password);
        $currentUser->save();
        return $this->render('settings', ['userProvider' => $currentUser, 'profileProvider' => $currentProfile]);
    }
}




