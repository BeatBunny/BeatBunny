<?php

namespace backend\modules\v1\controllers;
use yii\rest\ActiveController;
use Yii;

class UserController extends ActiveController
{
	public $modelClass = 'common\models\User';
	public $modelProfile = 'common\models\Profile';
	public $modelSignin = 'common\models\Signupform';
	public $modelLogin = 'common\models\Loginform';

    protected function verbs() {
        //$verbs = parent::verbs();
        $verbs =  [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
        return $verbs;
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

    public function actionRegisteruser(){
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
}
