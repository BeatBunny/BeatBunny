<?php

namespace backend\modules\v1\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;

class UserregisterandloginController extends ActiveController 
{
	public $modelClass = 'common\models\User';
	public $modelProfile = 'common\models\Profile';
	public $modelSignin = 'common\models\Signupform';
	public $modelLogin = 'common\models\Loginform';

    protected function verbs() {
        $verbs = parent::verbs();
        $verbs =  [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
        return $verbs;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'index' || $action === 'view' || $action === 'create' || $action === 'update' || $action === 'delete')
            throw new \yii\web\ForbiddenHttpException('That action must be performed at /user');
        
    }

    public function actionRegisteruser()
    {

        $signinModel = new $this->modelSignin;

        $signinModel->username = Yii::$app->request->post('username');
        $signinModel->email = Yii::$app->request->post('email');
        $signinModel->password = Yii::$app->request->post('password');
        $signinModel->nome = Yii::$app->request->post('nome');
        $signinModel->nif = Yii::$app->request->post('nif');

        if (!is_null($signinModel->signup())) {
            return true;
        }

        return false;


        /*$this->checkAccess('Register');
        if (Yii::$app->user->isGuest === true)
            throw new \yii\web\ForbiddenHttpException('Only unlogged in users can ');
        return Yii::$app->user->id;*/

        
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

    public function actionCreate(){

    }

}
