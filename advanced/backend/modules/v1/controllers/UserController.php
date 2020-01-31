<?php

namespace backend\modules\v1\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\base\Exception;
use Yii;

class UserController extends ActiveController 
{
	public $modelClass = 'common\models\User';
    public $modelMusics = 'common\models\Musics';
    public $modelVendas = 'common\models\Venda';
	public $modelProfile = 'common\models\Profile';
    public $modelPlaylists = 'common\models\Playlists';
	public $modelSignin = 'common\models\Signupform';
	public $modelLogin = 'common\models\Loginform';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
        'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
    //if ($action === ‘post' or $action === 'delete')
        if ($action === 'usernameget' or $action === 'delete')
            throw new \yii\web\ForbiddenHttpException('Apenas poderá '.$action.' utilizadores registados…');

    }



    public function actionUsernameget($id){
    	$model = new $this->modelClass;
    	$req = $model::findOne($id);
    	return $req->username;
    }

    public function actionAuthkeyget($id){
    	$model = new $this->modelClass;
    	$req = $model::findOne($id);
    	return $req->auth_key;
    }

    public function actionEmailget($id){
    	$model = new $this->modelClass;
    	$req = $model::findOne($id);
    	return $req->email;
    }

    public function actionPlaylistsget($id){
        $model = new $this->modelClass;
        $user = $model::findOne($id);
        $modelProfile = new $this->modelProfile;
        $profile = $modelProfile::find()->where(['user_id' => $user->id])->one();
        return $profile->playlists;
    }

    public function actionPlaylistmusicsget($id, $idplaylist){
        $modelPlaylists = new $this->modelPlaylists;

        $modelProfile = new $this->modelProfile;
        $profile = $modelProfile::find()->where(['user_id' => $id])->one();

        foreach ($profile->playlists as $playlist) {
            if($playlist->id == $idplaylist){
                return $playlist->musics;
            }
        }
    }

    /*public function actionRegisteruser(){
        $signinModel = new $this->modelSignin;

        $signinModel->username = Yii::$app->request->post('username');
        $signinModel->email = Yii::$app->request->post('email');
        $signinModel->password = Yii::$app->request->post('password');
        $signinModel->nome = Yii::$app->request->post('nome');
        $signinModel->nif = Yii::$app->request->post('nif');

        if ($signinModel->signup()) {
            return ['Saved' => 'true'];
        }

        return ['Saved' => 'false'];
    }

    public function actionLoginuser(){
    	$loginModel = new $this->modelLogin;
    	$modelUser = new $this->modelClass;

    	$loginModel->username = Yii::$app->request->post('username');
    	$loginModel->password = Yii::$app->request->post('password');

    	if($loginModel->login()){
    		$req = $modelUser::find()->where(['username' => $loginModel->username])->one();
    		return $req;
    	}
        return ['Logged in' => 'false'];	
    */

    public function actionWithprofile(){
        $modelsProfile = new $this->modelProfile;
        $req = $modelsProfile::find()->all();
        $usersWithProfile = [];
        foreach ($req as $profile) {
            array_push($usersWithProfile, $profile);
        }
        return $usersWithProfile;
    }
                        /** PROFILE PART **/
    public function actionIndexprofile($id){
        $modelProfile = new $this->modelClass;
        return $modelProfile->findOne($id);
    }


    public function actionSearch($txcode){
        $modelProfile = new $this->modelClass;
        $request = $modelProfile::find()->where("lower(title) LIKE '%".strtolower($txcode)."%'")->all();
        return $request;
    }
    public function actionNomeprofile($id){
        $modelProfile = new $this->modelClass;
        $model = $modelProfile::findOne($id);
        return $model->nome;
    }
    public function actionSaldoprofile($id){
        $modelsUser = new $this->modelClass;
        $modelsProfile = new $this->modelProfile;

        $user = $modelsUser->findOne($id);
        $profile = $modelsProfile::find()->where(['user_id' => $user->id])->one();

        return ['saldo' => $profile->saldo];
    }
    public function actionProfileimage($id){
        $modelProfile = new $this->modelClass;
        $model = $modelProfile::findOne($id);
        return $model->profileimage;
    }
    public function actionProfile($id){
        $modelsUser = new $this->modelClass;
        $modelsProfile = new $this->modelProfile;

        $user = $modelsUser->findOne($id);
        $profile = $modelsProfile::find()->where(['user_id' => $user->id])->one();
        return $profile;
    }

    public function actionGetmusicfromprofilehasproducer($id){
        $modelUser = new $this->modelClass;
        $modelProfile = new $this->modelProfile;

        $userById = $modelUser::findOne($id);
        if(is_null($userById))
            return false;

        $profileByUserId = $modelProfile::find()->where(['user_id' => $userById->id])->one();

        return $profileByUserId->musics;
    }
    public function actionGetmusicfromprofilehasclient($id){
        $modelUser = new $this->modelClass;
        $modelProfile = new $this->modelProfile;

        $userById = $modelUser::findOne($id);
        if(is_null($userById))
            return false;

        $profileByUserId = $modelProfile::find()->where(['user_id' => $userById->id])->one();
        $array_com_todas_as_compras = [];
        foreach ($profileByUserId->vendas as $venda){
            array_push($array_com_todas_as_compras, $venda->musics);
        }
        return $array_com_todas_as_compras;
    }

    public function actionBuysong(){
        $modelUser = new $this->modelClass;
        $modelProfiles = new $this->modelProfile;
        $modelMusic = new $this->modelMusics;

        $idUser = Yii::$app->request->post('idUser');
        $idMusicaParaComprar = Yii::$app->request->post('idMusicaParaComprar');

        $musicaEmQuestao = $modelMusic::findOne($idMusicaParaComprar);
        if(is_null($musicaEmQuestao))
            return ['SaveError' => "Music doesn't exist"];
            

        $profileEmQuestao = $modelProfiles::find()->where(['user_id' => $idUser])->one();

        if(is_null($profileEmQuestao))
            return ['SaveError' => "User doesn't exist"];


        foreach ($profileEmQuestao->vendas as $venda)
            if($venda->musics->id == $musicaEmQuestao->id)
            return ['SaveError' => "You already have purchased this music"];


        if($profileEmQuestao->saldo < $musicaEmQuestao->pvp)
            return ['SaveError' => "Your balance isn't enough for this purchase"];

        $profileEmQuestao->saldo = $profileEmQuestao->saldo - $musicaEmQuestao->pvp;

        $modelVenda = new $this->modelVendas;

        $modelVenda->data = date("Y/m/d");
        $modelVenda->valorTotal = $musicaEmQuestao->pvp;
        $modelVenda->profile_id = $profileEmQuestao->id;
        $modelVenda->musics_id = $musicaEmQuestao->id;

        
        if($modelVenda->save()){
            $profileEmQuestao->save(false);
            return ['SaveError' => "Music Bought"];
        }
        
        return false;

    }

    public function actionSavesettings(){
        $idUser = Yii::$app->request->post('idUser');
        $modelProfiles = new $this->modelProfile;

        $profileEmQuestao = $modelProfiles::find()->where(['user_id' => $idUser])->one();

        if(is_null($profileEmQuestao))
            throw new Exception("User doesn't exist");


        $nomeNovo = Yii::$app->request->post('nomeNovo');
        $nifNovo = Yii::$app->request->post('nifNovo');

        $profileEmQuestao->nome = $nomeNovo;
        $profileEmQuestao->nif = $nifNovo;

        if($profileEmQuestao->save(false))
            return $profileEmQuestao;

        return false;
    }



}
