<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property int $id
 * @property int $saldo
 * @property string $nome
 * @property int $nif
 * @property string $isprodutor
 * @property string $profileimage
 * @property int $user_id
 *
 * @property Musics[] $musics
 * @property User $user
 * @property ProfileHasAlbums[] $profileHasAlbums
 * @property Albums[] $albums
 * @property ProfileHasPlaylists[] $profileHasPlaylists
 * @property Playlists[] $playlists
 * @property Venda[] $vendas
 */
class Profile extends \yii\db\ActiveRecord
{
    public $saldoAdd;
    public $profileFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['saldo', 'nif', 'user_id'], 'integer'],
            [['nome', 'isprodutor', 'user_id', 'profileFile'], 'required'],
            [['saldoAdd'], 'integer'],
            [['profileFile'], 'file', 'extensions' => 'png'],
            [['isprodutor'], 'string'],
            [['nome'], 'string', 'max' => 45],
            [['profileimage'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saldo' => 'Saldo',
            'nome' => 'Nome',
            'nif' => 'Nif',
            'isprodutor' => 'Isprodutor',
            'profileimage' => 'Profileimage',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasMany(Musics::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasAlbums()
    {
        return $this->hasMany(ProfileHasAlbums::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Albums::className(), ['id' => 'albums_id'])->viaTable('{{%profile_has_albums}}', ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasPlaylists()
    {
        return $this->hasMany(ProfileHasPlaylists::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlists::className(), ['id' => 'playlists_id'])->viaTable('{{%profile_has_playlists}}', ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Venda::className(), ['profile_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $id = $this->id;
        $saldo = $this->saldo;
        $nome= $this->nome;
        $nif =$this->nif;
        $isprodutor =$this->isprodutor;
        $profileimage= $this->profileimage;
        $user_id= $this->user_id;

        $myObj = new Profile();
        $myObj->id = $id;
        $myObj->saldo =$saldo;
        $myObj->nome = $nome;
        $myObj->nif =$nif;
        $myObj->isprodutor = $isprodutor;
        $myObj->profileimage =$profileimage;
        $myObj->user_id=$user_id;

        $myJSON = Json::encode($myObj);
        if ($insert) {
            $this->FazPublish("INSERT_Profile_foi_Criado", $myJSON);
        } else
            $this->FazPublish("UPDATE_Profile_foi_Atualizado", $myJSON);
    }

    public function FazPublish($canal, $msg)
    {
        $server = '127.0.0.1';
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = uniqid();
        $mqtt= new phpMQTT($server, $port, $client_id);
        try {
            if ($mqtt->connect(true)) {
                $mqtt->publish($canal, $msg, 1);
                $mqtt->disconnect();
                $mqtt->close();
            } else {
                file_put_contents("debug.output", "Time out!");
            }
        }catch (\Exception $X)
        {}
    }
}
