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
                             /**AllPages**/
        $accessAll = $auth->createPermission('accessAll');
        $accessAll->description = 'Acess All pages';
        $auth->add($accessAll);

                            /**PlayLists**/
        $accessPlaylists = $auth->createPermission('accessPlaylists');
        $accessPlaylists->description = 'Acess Playlist';
        $auth->add($accessPlaylists);

        $client = $auth->createRole('client');
        $auth->add($client);
        $auth->addChild($client, $accessPlaylists);

        $producer = $auth->createRole('producer');
        $auth->add($producer);
        $auth->addChild($producer, $accessAll);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $accessAll);

        // Assign roles to users. 1, 2 and 3 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($client, 3);
        $auth->assign($producer, 2);
        $auth->assign($admin, 1);
    }
}