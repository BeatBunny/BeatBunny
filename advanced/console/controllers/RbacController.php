<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // add "author" role and give this role the "createPost" permission
        $client = $auth->createRole('client');
        $auth->add($client);

        $producer = $auth->createRole('producer');
        $auth->add($producer);
        $auth->addChild($producer, $client);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $producer);

        // Assign roles to users. 1, 2 and 3 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($client, 3);
        $auth->assign($producer, 2);
        $auth->assign($admin, 1);
    }
}