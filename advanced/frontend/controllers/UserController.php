<?php

namespace frontend\controllers;
use Yii;
use common\models\Musics;
use common\models\PlaylistsHasMusics;
use frontend\controllers\PlaylistsController;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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

     /**
      * {@inheritdoc}
      */
     public function behaviors(){
         return [
                 'access' => [
                     'class' => AccessControl::className(),
                     'rules' => [
                         [
                             'actions' => ['login', 'error'],
                             'allow' => true,
                         ],
                         [
                             'actions' => ['logout', 'index', 'view', 'create', 'update', 'settings','musicdelete'],
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

    public function getCurrentUser(){

        return User::find()->where(['id' => Yii::$app->user->id])->one();
    }

    public function getCurrentProfile(){

        return Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
    }

    public function getPlaylistsDoUser(){
        $currentProfile = $this->getCurrentProfile();

        $playlistsDoUser = [];

        foreach ($currentProfile->playlists as $musicInPlaylist) {
            array_push($playlistsDoUser, $musicInPlaylist);
        }

        return $playlistsDoUser;
    }

    public function getGenerosDasPlaylists($cadaUmaDasPlaylists){
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

    public function getMusicasCompradasdoUserLogado(){
        $profileProvider = $this->getCurrentProfile();
        $userProvider = $this->getCurrentUser();

        BaseVarDumper::dump($profileProvider->vendas);
        die();

    }

    public function actionIndex(){

       // $this->getMusicasCompradasdoUserLogado();


        $profileProvider = $this->getCurrentProfile();

        $userProvider = $this->getCurrentUser();

        $playlistHasMusics = new PlaylistsHasMusics();

        $numberOfSongsYouHave = count($profileProvider->musics);

        //$musicasCompradas = $this->getMusicasCompradasdoUserLogado();

        $playlistsUserLogado = $this->getPlaylistsDoUser();

        foreach ($playlistsUserLogado as $cadaUmaDasPlaylists) {
            //BaseVarDumper::dump($cadaUmaDasPlaylists);
            $cadaUmaDasPlaylists = $this->getGenerosDasPlaylists($cadaUmaDasPlaylists);
            //BaseVarDumper::dump($cadaUmaDasPlaylists);
        }

        if(!empty($playlistsUserLogado)){

            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'playlistsUserLogado' => $playlistsUserLogado]);
        }


        return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'numberOfSongsYouHave' => $numberOfSongsYouHave]);



        /*if(empty($musicasCompradas))
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'playlistsUserLogado' => $playlistsUserLogado, 'playlistHasMusics' => $playlistHasMusics]);

        elseif(empty($playlistsUserLogado)) {
            $musicasCompradas = $this->meterUsernameNoCampoProducerNasMusicasCompradas($musicasCompradas);
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'musicasCompradas' => $musicasCompradas, 'playlistsUserLogado' => $playlistsUserLogado, 'playlistHasMusics' => $playlistHasMusics]);
        }
        elseif(empty($musicasCompradas && empty($playlistsUserLogado)))
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'playlistsUserLogado' => $playlistsUserLogado, 'playlistHasMusics' => $playlistHasMusics ]);

        else{
            $musicasCompradas = $this->meterUsernameNoCampoProducerNasMusicasCompradas($musicasCompradas);
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'musicsFromProducerWithUsername' => $musicsFromProducerWithUsername, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'musicasCompradas' => $musicasCompradas, 'playlistsUserLogado' => $playlistsUserLogado, 'playlistHasMusics' => $playlistHasMusics]);
        }*/
    }

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
    public function actionSettings(){
        $currentUser = $this->getCurrentUser();
        $currentProfile = $this->getCurrentProfile();
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

    public function actionMusicdelete($id)
    {
        $currentUser = $this->getCurrentUser();
        $getCurrentProfile = $this->getCurrentProfile();
        if ((Yii::$app->user->can('accessAll') && ($getCurrentProfile->isprodutor == 'S')) || (Yii::$app->user->can('accessIsAdmin'))){
        $playlistsUserLogado = $this->getPlaylistsDoUser();
        $getCurrentMusic = Musics::find($id)->one();
        $numberOfSongsYouHave = count($getCurrentProfile->musics);
        if($verificarNaPlaylist = PlaylistsHasMusics::find($getCurrentMusic)->one())
            $delDaPlaylist = PlaylistsHasMusics::find($getCurrentMusic)->one()->delete();
        $verificarNaLinhaVenda = Venda::find($getCurrentMusic)->one();
        if (count($verificarNaLinhaVenda) != null) {
            $popup = true;
            return $this->render('index', ['popup' => $popup, 'profileProvider' => $getCurrentProfile, 'userProvider' => $currentUser, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'playlistsUserLogado' => $playlistsUserLogado]);

        }
        $delMusic = Musics::find($getCurrentMusic)->one()->delete();
        return $this->redirect(['index']);
    }
    }
}




