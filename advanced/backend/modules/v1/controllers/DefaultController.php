<?php

namespace backend\modules\v1\controllers;
use yii\rest\ActiveController;

class DefaultController extends ActiveController
{
	public $modelClass = 'common\models\User';
}
