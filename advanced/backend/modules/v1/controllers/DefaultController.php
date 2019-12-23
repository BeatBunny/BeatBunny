<?php

namespace backend\modules\v1\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class DefaultController extends ActiveController
{
	public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}
