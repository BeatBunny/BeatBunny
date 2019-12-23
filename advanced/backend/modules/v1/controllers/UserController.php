<?php

namespace backend\modules\v1\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;

class UserController extends ActiveController 
{
	public $modelClass = 'common\models\User';
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
        $modelProfile = new $this->modelClass;
        $model = $modelProfile::findOne($id);
        return $model->saldo;
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


}
