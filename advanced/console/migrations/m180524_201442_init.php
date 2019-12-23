<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

class m180524_201442_init extends Migration
{
    public function up()
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

        $accessIsAdmin = $authManager->createPermission('accessIsAdmin');
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

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $tableName = $this->db->tablePrefix . 'user';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable('{{%user}}', [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull()->unique(),
                'auth_key' => $this->string(32)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string()->unique(),
                'email' => $this->string()->notNull()->unique(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ], $tableOptions);
            $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));
        }
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropColumn('{{%user}}', 'verification_token');
    }
}
