<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();
        /**AllPages**/
        $accessAll = $authManager->createPermission('accessAll');
        $accessAll->description = 'Acess All pages (frontend) ';
        $authManager->add($accessAll);

        /**PlayLists**/
        $accessPlaylists = $authManager->createPermission('accessPlaylists');
        $accessPlaylists->description = 'Acess Playlist';
        $authManager->add($accessPlaylists);

        $accessIsAdmin = $authManager->createPermission('IsAdmin');
        $accessIsAdmin->description = 'Acess ALL';
        $authManager->add($accessIsAdmin);

        $client = $authManager->createRole('client');
        $authManager->add($client);
        $authManager->addChild($client, $accessPlaylists);

        $producer = $authManager->createRole('producer');
        $authManager->add($producer);
        $authManager->addChild($producer, $accessAll);

        $admin = $authManager->createRole('admin');
        $authManager->add($admin);
        $authManager->addChild($admin, $accessIsAdmin);

        $authManager->assign($client, 3);
        $authManager->assign($producer, 2);
        $authManager->assign($admin, 1);
    }
}