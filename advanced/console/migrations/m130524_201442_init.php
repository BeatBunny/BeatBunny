<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
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

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

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
    }


    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
